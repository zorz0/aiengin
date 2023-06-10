<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'App\Http\Controllers\Frontend', 'as' => 'api.'], function () {
    Route::post('auth/signup', 'AuthController@signup')->name('auth.signup');
    Route::post('auth/login', 'AuthController@login')->name('auth.login');
    Route::post('auth/emailValidate', 'AuthController@emailValidate')->name('auth.info.validate.email');
    Route::post('reset-password/send', 'AccountController@sendResetPassword')->name('account.send.request.reset.password');
    Route::get('connect/redirect/{service}', 'AuthController@socialiteLogin')->name('auth.login.socialite.redirect');
    Route::any('connect/callback/{service}', 'AuthController@socialiteLogin')->name('auth.login.socialite.callback');
});

Route::group(['namespace' => 'App\Http\Controllers\Frontend', 'as' => 'api.', 'middleware' => 'auth:api'], function () {
    Route::post('auth/user', 'AuthController@user')->name('auth.user');
    Route::post('auth/user/settings/profile', 'AuthController@settingsProfile')->name('auth.user.settings.profile');
    Route::post('auth/user/settings/account', 'AuthController@settingsAccount')->name('auth.user.settings.account');
    Route::post('auth/user/settings/password', 'AuthController@settingsPassword')->name('auth.user.settings.password');
    Route::post('auth/user/settings/preferences', 'AuthController@settingsPreferences')->name('auth.user.settings/preferences');
    Route::post('auth/user/notifications', 'AuthController@notifications')->name('auth.user.notifications');
    Route::post('auth/user/notification-count', 'AuthController@notificationCount')->name('auth.user.notification.count');
    Route::post('auth/user/favorite', 'AuthController@favorite')->name('auth.user.favorite');
    Route::post('auth/user/text-generator', 'AuthController@textGenerator')->name('auth.user.textGenerator');
    Route::post('auth/user/image-generator', 'AuthController@imageGenerator')->name('auth.user.imageGenerator');

    Route::post('auth/user/library', 'AuthController@library')->name('auth.user.library');
    Route::post('auth/user/song/library', 'AuthController@songLibrary')->name('auth.user.song.library');
    Route::post('auth/user/subscription/cancel', 'AuthController@cancelSubscription')->name('auth.user.cancel.subscription');
    Route::post('auth/logout', 'AuthController@logout')->name('auth.logout');
});

if(app('request')->header('authorization')) {
    Route::group(['laroute' => true, 'namespace' => 'App\Http\Controllers\Frontend', 'as' => 'api.', 'middleware' => 'auth:api'], function () {
        includeRouteFiles(__DIR__.'/Api/');
    });
} else {
    Route::group(['laroute' => true, 'namespace' => 'App\Http\Controllers\Frontend', 'as' => 'api.'], function () {
        includeRouteFiles(__DIR__.'/Api/');
    });
}
