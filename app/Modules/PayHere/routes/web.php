<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-06-23
 * Time: 18:10
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    Route::get('subscription/payhere/{id}', '\App\Modules\PayHere\Controller@subscriptionAuthorization')->name('payhere.subscription.authorization');
    Route::get('subscription/payhere/callback/{id}', '\App\Modules\PayHere\Controller@subscriptionCallback')->name('payhere.subscription.callback');
});
