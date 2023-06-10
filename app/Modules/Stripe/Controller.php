<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-08-06
 * Time: 17:06
 */

namespace App\Modules\Stripe;

use App\Models\Email;
use App\Models\Service;
use App\Modules\MobileHelper\APISession;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Subscription;
use Illuminate\Http\Request;
use View;
use Stripe\Checkout\Session;

class Controller extends APISession
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function subscriptionAuthorization()
    {
        $this->apiSession();
        if (auth()->user()->subscription) {
            abort(403, 'You are already have a subscription.');
        }

        $service = Service::findOrFail($this->request->route('id'));
        $amount = in_array(config('settings.currency', 'USD'), config('payment.currency_decimals')) ? $service->price : intval($service->price);
        \Stripe\Stripe::setApiKey(config('payment.gateways.stripe.secret_key'));

        $product = \Stripe\Product::create([
            'name' => $service->title,
            'type' => 'service',
        ]);

        $price = \Stripe\Price::create([
            'unit_amount' => $amount * 100,
            'currency' => config('settings.currency', 'USD'), // set the currency here
            'product' => $product,
            'recurring' => [
                'interval' => $service->plan_period == 'M' ? 'month' : 'year',
                'usage_type' => 'licensed',
            ],
        ]);

        $checkout_session = \Stripe\Checkout\Session::create([
            'success_url' => route('frontend.stripe.subscription.callback', ['id' => $service->id]),
            'cancel_url' => route('frontend.payment.canceled'),
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price' => $price->id,
                    'quantity' => 1,
                ],
            ],
            'mode' => 'subscription',
        ]);

        return response()
            ->redirectTo($checkout_session->url)
            ->cookie('stripe_session_id', $checkout_session->id);
    }

    public function subscriptionCallback()
    {
        $this->apiSession();

        if (auth()->user()->subscription) {
            abort(403, 'You are already have a subscription.');
        }
        \Stripe\Stripe::setApiKey(config('payment.gateways.stripe.secret_key'));

        $stripe_session_id = request()->cookie('stripe_session_id');
        $checkout_session = Session::retrieve($stripe_session_id);

        if ($checkout_session->status === 'complete') {
            $service = Service::findOrFail($this->request->route('id'));
            $user = auth()->user();
            $user->increment('tokens', $service->tokens);
            $subscription = new Subscription();
            $subscription->gate = 'stripe';
            $subscription->user_id = auth()->user()->id;
            $subscription->service_id = $service->id;
            $subscription->payment_status = 1;
            $subscription->transaction_id = $checkout_session->subscription;
            $subscription->token = $checkout_session->id;
            $subscription->tokens = $service->tokens;
            $subscription->next_billing_date = $service->plan_period == 'M' ? Carbon::now()->addMonth() : Carbon::now()->addYear();
            $subscription->amount = $service->price;
            $subscription->currency = config('settings.currency', 'USD');
            $subscription->cycles = 1;
            $subscription->last_payment_date = Carbon::now();

            $subscription->save();
            (new Email)->subscriptionReceipt(auth()->user(), $subscription);

            $view = View::make('frontend.payment-return');
            return $view;
        } else {
            return response()->json([
                'message' => 'Payment failed',
                'errors' => array('message' => array(__('web.PAYMENT_FAILED_DESCRIPTION')))
            ], 500);
        }
    }
}
