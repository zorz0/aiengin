<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-06-23
 * Time: 18:10
 */

Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    Route::get('subscription/flutterwave/{id}', '\App\Modules\FlutterWave\Controller@subscriptionAuthorization')->name('flutterwave.subscription.authorization');
    Route::get('subscription/flutterwave/callback/{id}', '\App\Modules\FlutterWave\Controller@subscriptionCallback')->name('flutterwave.subscription.callback');
});
