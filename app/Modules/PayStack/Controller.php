<?php

namespace App\Modules\PayStack;

use App\Models\Order;
use App\Models\Service;
use App\Modules\MobileHelper\APISession;
use Carbon\Carbon;
use Cart;
use Illuminate\Http\Request;
use App\Models\Email;
use App\Models\Subscription;

class Controller extends APISession
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->apiSession();
    }

    public function subscriptionAuthorization()
    {
        if(auth()->user()->subscription) {
            abort(403, 'You are already have a subscription.');
        }

        $service = Service::findOrFail($this->request->route('id'));

        $curl = curl_init();
        $email = auth()->user()->email;
        $amount = $service->price * 100;
        $callback_url = route('frontend.paystack.subscription.callback', ['id' => $this->request->route('id')]);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'amount'=>$amount,
                'email'=>$email,
                'callback_url' => $callback_url
            ]),
            CURLOPT_HTTPHEADER => [
                "authorization: Bearer " . config('payment.gateways.paystack.secret_key'),
                "content-type: application/json",
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err){
            abort(500, 'Curl returned error: ' . $err);
        }

        $tranx = json_decode($response, true);

        if(!$tranx['status']){
            abort(500, 'API returned error: ' . $tranx['message']);
        }

        header('Location: ' . $tranx['data']['authorization_url']);
        exit;
    }

    public function subscriptionCallback()
    {
        $this->request->validate([
            'reference' => 'required|string',
        ]);

        $curl = curl_init();
        $reference = $this->request->input('reference');

        if(!$reference){
            abort(500, 'No reference supplied');
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer " . config('payment.gateways.paystack.secret_key'),
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err){
            // there was an error contacting the Paystack API
            abort(500, 'Curl returned error: ' . $err);
        }

        $tranx = json_decode($response);

        if(!$tranx->status){
            // there was an error from the API
            abort(500, 'API returned error: ' . $tranx->message);
        }

        if($tranx->data->status == 'success'){
            $service = Service::findOrFail($this->request->route('id'));

            $subscription = new Subscription();
            $user = auth()->user();
            $user->increment('tokens', $service->tokens);

            $subscription->gate = 'paypal';
            $subscription->user_id = auth()->user()->id;
            $subscription->service_id = $service->id;
            $subscription->payment_status = 1;
            $subscription->transaction_id = $this->request->input('token');
            $subscription->token = $tranx->data->reference;
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
        }
    }
}
