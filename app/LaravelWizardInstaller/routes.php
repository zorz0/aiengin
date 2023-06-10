<?php

use App\LaravelWizardInstaller\Controllers\InstallDatabaseController;
use App\LaravelWizardInstaller\Controllers\InstallFinishController;
use App\LaravelWizardInstaller\Controllers\InstallFolderController;
use App\LaravelWizardInstaller\Controllers\InstallIndexController;
use App\LaravelWizardInstaller\Controllers\InstallKeysController;
use App\LaravelWizardInstaller\Controllers\InstallMigrationsController;
use App\LaravelWizardInstaller\Controllers\InstallServerController;
use App\LaravelWizardInstaller\Controllers\InstallSetDatabaseController;
use App\LaravelWizardInstaller\Controllers\InstallSetKeysController;
use App\LaravelWizardInstaller\Controllers\InstallSetMigrationsController;
use App\LaravelWizardInstaller\Controllers\InstallAdminAccountController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'install',
    'as' => 'LaravelWizardInstaller::',
    'namespace' => 'App\LaravelWizardInstaller\Controllers',
    'middleware' => ['web', 'installer']
], static function () {
    Route::get('/', ['as' => 'install.index', 'uses' => InstallIndexController::class]);
    Route::get('/server', ['as' => 'install.server', 'uses' => InstallServerController::class]);
    Route::get('/folders', ['as' => 'install.folders', 'uses' => InstallFolderController::class]);
    Route::get('/database', ['as' => 'install.database', 'uses' => InstallDatabaseController::class]);
    Route::post('/database', ['uses' => InstallSetDatabaseController::class]);
    Route::get('/migrations', ['as' => 'install.migrations', 'uses' => InstallMigrationsController::class]);
    Route::post('/migrations', ['uses' => InstallSetMigrationsController::class]);
    Route::get('/keys', ['as' => 'install.keys', 'uses' => InstallKeysController::class]);
    Route::post('/keys', ['uses' => InstallSetKeysController::class]);
    Route::get('/create-admin', ['as' => 'install.admin', 'uses' => InstallAdminAccountController::class]);
    Route::post('/create-admin', ['as' => 'install.set.admin', 'uses' => InstallSetAdminAccountController::class]);
    Route::get('/finish', ['as' => 'install.finish', 'uses' => InstallFinishController::class]);
});
