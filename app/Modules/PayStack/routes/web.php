<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-06-23
 * Time: 18:10
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    Route::get('subscription/paystack/{id}', '\App\Modules\PayStack\Controller@subscriptionAuthorization')->name('paystack.subscription.authorization');
    Route::get('subscription/paystack/callback/{id}', '\App\Modules\PayStack\Controller@subscriptionCallback')->name('paystack.subscription.callback');
});
