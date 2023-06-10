<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-06-23
 * Time: 18:10
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    Route::get('subscription/mpesa/{id}', '\App\Modules\Mpesa\Controller@subscriptionAuthorization')->name('mpesa.subscription.authorization');
    Route::post('subscription/mpesa/callback/{id}', '\App\Modules\Mpesa\Controller@subscriptionCallback')->name('mpesa.subscription.callback');
});
