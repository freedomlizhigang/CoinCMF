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

Route::get('/', 'Admin\IndexController@getIndex');

// Home PC版
Route::group(['namespace' => 'Home'], function () {
	// Test
	// Route::get('/test', 'HomeController@test');
	// // 首页
	// Route::get('/', 'HomeController@getIndex');
	// // 微信登陆
	// Route::get('/login', 'LoginController@getLogin');
	// 微信登陆的回调
	// Route::get('/wxlogin', 'LoginController@getWxLogin');
	// 所有没有的放这里
	Route::pattern('path', '.+');
	Route::any('{path}', 'HomeController@getIndex');
});

// 支付回调
Route::group([], function () {
	// 支付宝应用网关,异步回调
	Route::post('alipay/gateway', 'Pay\AlipayController@gateway');
	// 支付宝应用网关,同步回调
	Route::post('alipay/return', 'Pay\AlipayController@gateway');
	// 微信回调
	Route::post('weixin/return', 'Pay\WxpayController@gateway');
});