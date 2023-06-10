<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-06-23
 * Time: 18:10
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    Route::get('subscription/dpo/{id}', '\App\Modules\DPO\Controller@subscriptionAuthorization')->name('dpo.subscription.authorization');
    Route::get('subscription/dpo/callback/{id}', '\App\Modules\DPO\Controller@subscriptionCallback')->name('dpo.subscription.callback');
});
