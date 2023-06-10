<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-06-23
 * Time: 18:10
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    Route::get('subscription/stripe/{id}', '\App\Modules\Stripe\Controller@subscriptionAuthorization')->name('stripe.subscription.authorization');
    Route::get('subscription/stripe/callback/{id}', '\App\Modules\Stripe\Controller@subscriptionCallback')->name('stripe.subscription.callback');
});
