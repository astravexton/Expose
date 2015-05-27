<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    if (Auth::guest()) {
        return redirect(route('Auth.Login'));
    } else {
        return redirect(route('Dashboard'));
    }
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [
        'as'   => 'Dashboard',
        'uses' => 'AppController@getDashboard'
    ]);

    Route::post('annotate', [
        'as'   => 'Annotate',
        'uses' => 'AppController@postAnnotation'
    ]);
});


Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [
        'middleware' => 'guest',
        'uses'       => 'AuthController@getLogin',
        'as'         => 'Auth.Login'
    ]);

    Route::post('login', [
        'middleware' => 'guest',
        'uses'       => 'AuthController@postLogin',
    ]);
});
