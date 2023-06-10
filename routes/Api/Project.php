<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-08-01
 * Time: 20:34
 */
Route::post('auth/projects', 'AuthController@getProjects')->name('project.getProjects');
Route::post('auth/project/create', 'AuthController@createProject')->name('project.create');
Route::post('auth/project/delete', 'AuthController@deleteProject')->name('project.delete');
