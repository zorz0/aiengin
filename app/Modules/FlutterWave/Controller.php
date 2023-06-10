<?php

namespace App\Modules\FlutterWave;

use App\Models\Service;
use App\Modules\MobileHelper\APISession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Email;
use App\Models\Subscription;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Controller extends APISession
{
    protected $publicKey;
    protected $env = 'staging';
    protected $baseUrl;
    protected $body;
    protected $amount;
    protected $description;
    protected $country;
    protected $currency;
    protected $email;
    protected $firstName;
    protected $lastName;
    protected $phoneNumber;
    protected $handler;
    protected $meta;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function subscriptionAuthorization()
    {
        $this->apiSession();

        if(auth()->user()->subscription) {
            abort(403, 'You are already have a subscription.');
        }

        $service = Service::findOrFail($this->request->route('id'));

        $checkoutData = array(
            'public_key' =>  config('payment.gateways.flutterwave.public_key'),
            'tx_ref' => rand(),
            'amount' => round($service->price),
            'currency' => config('settings.currency', 'USD'),
            'country' => 'NG',
            'payment_options' => 'card, mobilemoneyghana, ussd',
            'redirect_url' => route('frontend.flutterwave.subscription.callback', ['id' => $this->request->route('id')]),
            'meta' => [
                'consumer_id' => auth()->user()->id,
                'consumer_mac' => rand()
            ],
            'customer' => [
                'email' => auth()->user()->email,
                'phone_number' => '',
                'name' => auth()->user()->name,
            ],
            'customizations' => [
                'title' => env('APP_NAME'),
                'description' => $service->title,
                'logo' => asset('assets/images/logo.png')
            ]
        );

        echo '<html>';
        echo '<body>';
        echo '<center>Processing...<br /><img style="height: 50px;" src="https://media.giphy.com/media/swhRkVYLJDrCE/giphy.gif" /></center>';
        echo '<script type="text/javascript" src="https://checkout.flutterwave.com/v3.js"></script>';
        echo '<script>';
        echo 'document.addEventListener("DOMContentLoaded", function(event) {';
        echo 'FlutterwaveCheckout(' . \GuzzleHttp\json_encode($checkoutData) . ');';
        echo '});';
        echo '</script>';
        echo '</body>';
        echo '</html>';

        exit;
    }

    public function subscriptionCallback()
    {
        if(auth()->user()->subscription) {
            abort(403, 'You are already have a subscription.');
        }

        $response = Http::post(config('payment.gateways.flutterwave.environment') == 'live' ? 'https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify' :  'https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/v2/verify', [
            "SECKEY" => config('payment.gateways.flutterwave.secret_key'),
            "txref" => $this->request->input('tx_ref')
        ]);

        if ($response->successful() && $response->object()->data->txid == $this->request->input('transaction_id')) {
            $service = Service::findOrFail($this->request->route('id'));
            $user = auth()->user();
            $user->increment('tokens', $service->tokens);

            $subscription = new Subscription();
            $subscription->gate = 'flutterwave';
            $subscription->user_id = auth()->user()->id;
            $subscription->service_id = $service->id;
            $subscription->payment_status = 1;
            $subscription->transaction_id = $this->request->input('transaction_id');
            $subscription->token = $this->request->input('tx_ref');
            $subscription->trial_end = null;
            $subscription->next_billing_date = $service->plan_period == 'M' ? Carbon::now()->addMonth() : Carbon::now()->addYear();
            $subscription->cycles = 1;
            $subscription->amount = $service->price;
            $subscription->currency = config('settings.currency', 'USD');

            if(! $service->trial) {
                $subscription->last_payment_date = Carbon::now();
            }

            $subscription->save();

            (new Email)->subscriptionReceipt(auth()->user(), $subscription);

            return view()->make('frontend.payment-return');
        }  else {
            abort(403, 'Unable to authenticate FlutterWave');
        }
    }
}
