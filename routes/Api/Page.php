<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-06-23
 * Time: 09:53
 */

Route::post('pages', 'PageController@getPages')->name('getPages');
Route::post('page/{slug}', 'PageController@getPageByAltName')->name('getPageByAltName');
