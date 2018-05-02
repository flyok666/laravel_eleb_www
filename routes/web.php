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

Route::get('/', function () {
    return view('welcome');
});

//商家列表
Route::get('/shops','ApiController@shops');
Route::get('/shop','ApiController@shop');

//测试发送短信
//Route::get('/sms','UserController@sms');

//注册
Route::post('/register','UserController@register');
//登录
Route::post('/login','UserController@login');

//Route::get('/test','UserController@test');
//Route::get('/test2','UserController@test2');
