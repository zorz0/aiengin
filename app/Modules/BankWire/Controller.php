<?php

namespace App\Modules\BankWire;

use App\Models\Order;
use App\Models\Service;
use App\Modules\MobileHelper\APISession;
use Carbon\Carbon;
use Cart;
use Illuminate\Http\Request;
use App\Models\Email;
use App\Models\Subscription;
use View;
use Session;
use Validator;
use Image;

class Controller extends APISession
{
    protected $request;

    public function __construct(Request $request, $protocol = 'https')
    {
        $this->request = $request;
        View::addLocation(app_path() . '/Modules/BankWire/views');
    }

    public function subscriptionAuthorization()
    {
        $this->apiSession();
        if(auth()->user()->subscription()->withoutGlobalScopes()->first()) {
            abort(403, 'You are already have a subscription or waiting for your subscription being activated.');
        }

        return View::make('bankwire.index')
            ->with('formUrl', route('frontend.bankwire.subscription.callback', ['id' => $this->request->route('id')]));
    }

    public function subscriptionCallback()
    {
        $this->apiSession();
        if(auth()->user()->subscription) {
            abort(403, 'You are already have a subscription.');
        }

        $validator = Validator::make($this->request->all(), [ 'artwork' => 'required|image|mimes:jpeg,png,jpg,gif|max:' . config('settings.max_image_file_size', 8096) ]);

        if ($validator->fails()) {
            return redirect()->back()->with('status', 'failed')->with('message', trans('Please upload image filetype only (png, bmp, gif).'));
        } else {
            if ($this->request->file('artwork')) {
                $service = Service::findOrFail($this->request->route('id'));
                $subscription = new Subscription();
                $subscription->gate = 'bankwire';
                $subscription->user_id = auth()->user()->id;
                $subscription->service_id = $service->id;
                $subscription->payment_status = 1;
                $subscription->transaction_id = $this->request->input('transaction_id');
                $subscription->token = $this->request->input('transaction_id');
                $subscription->trial_end = null;
                $subscription->approved = 0;

                $subscription->clearMediaCollection('artwork');
                $subscription->addMediaFromBase64(base64_encode(Image::make($this->request->file('artwork'))->orientate()->fit(intval(config('settings.image_artwork_max', 500)), intval(config('settings.image_artwork_max', 500)))->encode('jpg', config('settings.image_jpeg_quality', 90))->encoded))
                    ->usingFileName(time() . '.jpg')
                    ->toMediaCollection('artwork', config('settings.storage_artwork_location', 'public'));
                $subscription->next_billing_date = $service->plan_period == 'M' ? Carbon::now()->addMonth() : Carbon::now()->addYear();
                $subscription->cycles = 1;
                $subscription->amount = $service->price;
                $subscription->currency = config('settings.currency', 'USD');

                if (!$service->trial) {
                    $subscription->last_payment_date = Carbon::now();
                }

                $subscription->save();

                (new Email)->subscriptionReceipt(auth()->user(), $subscription);

                echo '<script type="text/javascript">
                    alert(\'Thanks for your payment, we will let you know when your bank wire being processed.\');
                    var opener = window.opener;
                    if(opener) {
                        window.close();
                    }
                    </script>';
                exit;
            }
        }
        return redirect()->route('frontend.bankwire.purchase.authorization')->with('status', 'failed')->with('message', 'Something gone wrong, please contact administrator.');
    }
}
