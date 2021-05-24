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

    Route::get('get-columns/{module}', 'PreferenceController@getColumns')->name('preference.get-columns');
    Route::resource('preference', 'PreferenceController');
});
