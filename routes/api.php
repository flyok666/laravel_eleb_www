<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register','UserController@register');
Route::post('/login','UserController@login');
Route::get('/logout','UserController@logout');
//Route::get('/test','UserController@test');
//Route::get('/test2','UserController@test2');

Route::get('/sms','UserController@sms');

Route::get('/user','UserController@user');


