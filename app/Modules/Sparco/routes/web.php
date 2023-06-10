<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-06-23
 * Time: 18:10
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    Route::get('subscription/sparco/{id}', '\App\Modules\Sparco\Controller@subscriptionAuthorization')->name('sparco.subscription.authorization');
    Route::get('subscription/sparco/callback/{id}', '\App\Modules\Sparco\Controller@subscriptionCallback')->name('sparco.subscription.callback');
});
