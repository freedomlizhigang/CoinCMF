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

// Home PC版
Route::group(['namespace' => 'Home'],function(){
    // 首页
    Route::get('/','HomeController@getIndex');
    Route::get('/wxlogin','HomeController@wxlogin');
    Route::get('/{all}','HomeController@getIndex')->where('all','.*');
});

Route::group(['prefix'=>'wx','namespace' => 'Wx'],function(){
    Route::any('/index','WxController@index');
});


// 支付回调
Route::group([],function(){
    // 支付宝应用网关,异步回调
    Route::post('alipay/gateway','Pay\AlipayController@gateway');
    // 支付宝应用网关,同步回调
    Route::post('alipay/return','Pay\AlipayController@gateway');
    // 微信回调
    Route::post('weixin/return','Pay\WxpayController@gateway');
});
