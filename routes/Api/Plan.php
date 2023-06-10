<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-06-23
 * Time: 09:51
 */

Route::post('plans', 'PlansController@getPlans')->name('plans.get');
Route::post('plan/{id}', 'PlansController@getPlanById')->name('plans.get.by.id');
