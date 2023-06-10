<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-08-06
 * Time: 17:06
 */

namespace App\Modules\Paypal;

use App\Models\Email;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use DB;
use Auth;
use App\Models\User;
use Carbon\Carbon;
use PHPUnit\TextUI\ResultPrinter;
use App\Modules\MobileHelper\APISession;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class Controller extends APISession
{
    protected $baseUrl;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->apiSession();
        config('payment.gateways.paypal.sandbox') ? $this->baseUrl = 'https://www.sandbox.paypal.com' : $this->baseUrl = 'https://www.paypal.com';
    }

    public function subscriptionAuthorization()
    {
        if(auth()->user()->subscription) {
            abort(403, 'You are already have a subscription.');
        }

        $clientId = config('payment.gateways.paypal.public_key');
        $clientSecret = config('payment.gateways.paypal.secret_key');

        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $client = new PayPalHttpClient($environment);

        $service = Service::findOrFail($this->request->route('id'));

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => time(),
                "amount" => [
                    "value" => $service->price,
                    "currency_code" => config('settings.currency', 'USD')
                ]
            ]],
            "application_context" => [
                "cancel_url" => route('frontend.payment.canceled'),
                "return_url" => route('frontend.paypal.subscription.callback', ['id' => $service->id]),
            ]
        ];

        try {
            $response = $client->execute($request);
            return response()->redirectTo($response->result->links[1]->href);
        }catch (\HttpException $ex) {
            echo $ex->statusCode;
            dd($ex->getMessage());
        }
    }

    public function subscriptionCallback() {
        $this->request->validate([
            'token' => 'required|string',
        ]);

        if(auth()->user()->subscription && !auth()->user()->subscription->service->host_id) {
            abort(403, 'You are already have a subscription.');
        }

        $clientId = config('payment.gateways.paypal.public_key');
        $clientSecret = config('payment.gateways.paypal.secret_key');

        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $client = new PayPalHttpClient($environment);

        $request = new OrdersCaptureRequest($this->request->token);

        $request->prefer('return=representation');

        try {
            $response = $client->execute($request);
            if($response->result->status == 'COMPLETED') {

                $service = Service::findOrFail($this->request->route('id'));
                $user = auth()->user();
                $user->increment('tokens', $service->tokens);
                $subscription = new Subscription();
                $subscription->gate = 'paypal';
                $subscription->user_id = auth()->user()->id;
                $subscription->service_id = $service->id;
                $subscription->payment_status = 1;
                $subscription->transaction_id = $this->request->token;
                $subscription->token = $this->request->token;
                $subscription->tokens = $service->tokens;
                $subscription->next_billing_date = $service->plan_period == 'M' ? Carbon::now()->addMonth() : Carbon::now()->addYear();
                $subscription->amount = $service->price;
                $subscription->currency = config('settings.currency', 'USD');
                $subscription->cycles = 1;
                $subscription->last_payment_date = Carbon::now();

                $subscription->save();
                (new Email)->subscriptionReceipt(auth()->user(), $subscription);

                return view()->make('frontend.payment-return');
            }
        }catch (\HttpException $ex) {
            echo $ex->statusCode;
            dd($ex->getMessage());
        }
    }
}
