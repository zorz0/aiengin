<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-06-23
 * Time: 18:10
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    Route::get('subscription/tipme/{id}', '\App\Modules\TipMe\Controller@subscriptionAuthorization')->name('tipme.subscription.authorization');
    Route::post('subscription/tipme/callback/{id}', '\App\Modules\TipMe\Controller@subscriptionCallback')->name('tipme.subscription.callback');
});
