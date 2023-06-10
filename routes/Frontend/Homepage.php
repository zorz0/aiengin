<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-08-01
 * Time: 20:37
 */
Route::get('/', 'HomeController@index')->name('homepage');
Route::post('/payment-canceled', 'PaymentController@availablePayments')->name('payment.canceled');
Route::post('/available-payments', 'PaymentController@availablePayments')->name('payment.available.payments');
Route::any('/download-image/{imageUrl}', 'DownloadController@downloadImage')->where('imageUrl', '.+')->name('download');
Route::get('/{path}', 'HomeController@index')->name('homepage.path')->where('path', '.+');;
