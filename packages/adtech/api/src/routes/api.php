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

Route::group(array('prefix' => 'auth'), function () {
    Route::get('login', 'Auth\LoginController@login');

    Route::group(['middleware' => ['jwt.auth']], function () {

        Route::get('get-info', 'Auth\LoginController@getUserInfo');
        Route::get('verify', 'Auth\LoginController@verify');
    });
});