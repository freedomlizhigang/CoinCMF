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

// 会员功能
Route::group(['prefix'=>'user'],function(){
    // 注册
    Route::post('register','Api\UserController@postRegister');
    // 登陆
    Route::post('login','Api\UserController@postLogin');
});

Route::group(['prefix'=>'user','middleware' => ['jwt']],function(){
    // 注销
    Route::post('logout','Api\UserController@postLogout');
});