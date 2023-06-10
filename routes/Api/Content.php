<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-08-01
 * Time: 20:34
 */
Route::post('auth/content/save', 'AuthController@saveContent')->name('content.save');
Route::post('auth/content/save-image', 'AuthController@saveImageContent')->name('content.saveImageContent');
Route::post('auth/content/delete', 'AuthController@deleteContentById')->name('content.deleteContentById');
Route::post('auth/content/get-by-id', 'AuthController@getContentById')->name('content.getContentById');
Route::post('auth/contents', 'AuthController@getContents')->name('content.getContents');
