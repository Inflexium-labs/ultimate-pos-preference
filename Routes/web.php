<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['can:superadmin', 'web', 'authh', 'auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu']], function () {
    Route::get('preference/install', 'InstallController@index')->name('preference.install');

    Route::resource('preference', 'PreferenceController');

    Route::prefix('preferences')->group(function () {
        Route::get('get-columns/{module}', 'ColumnController@getColumns')->name('hide-columns.get-columns');
        Route::resource('hide-columns', 'ColumnController');

        Route::get('get-inputs/{module}', 'InputController@getInputs')->name('hide-inputs.get-inputs');
        Route::resource('hide-inputs', 'InputController');
    });
});
