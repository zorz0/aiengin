<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-06-23
 * Time: 09:51
 */

Route::get('search', 'SearchController@generalSearch')->name('search');
Route::get('search/user', 'SearchController@user')->name('search.user');
