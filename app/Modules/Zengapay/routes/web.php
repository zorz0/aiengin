<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-06-23
 * Time: 18:10
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    Route::get('subscription/zengapay/{id}', '\App\Modules\Zengapay\Controller@subscriptionAuthorization')->name('zengapay.subscription.authorization');
    Route::post('subscription/zengapay/callback/{id}', '\App\Modules\Zengapay\Controller@subscriptionCallback')->name('zengapay.subscription.callback');
});
