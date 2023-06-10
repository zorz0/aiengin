<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-06-23
 * Time: 18:10
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    Route::get('subscription/paypal/{id}', '\App\Modules\Paypal\Controller@subscriptionAuthorization')->name('paypal.subscription.authorization');
    Route::get('subscription/paypal/callback/{id}', '\App\Modules\Paypal\Controller@subscriptionCallback')->name('paypal.subscription.callback');
});
