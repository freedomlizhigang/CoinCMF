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

// 后台路由
Route::group(['prefix'=>'console','namespace' => 'Admin'],function(){
    // 后台管理不用其它，只用登陆，退出
    Route::get('login', 'PublicController@getLogin');
    Route::post('login', 'PublicController@postLogin');
    // 退出登陆
    Route::get('logout', 'PublicController@getLogout');
});

// 管理中心API
Route::group(['prefix'=>'c-api','namespace' => 'Admin\Api'],function(){
    // 文章管理用的
    Route::get('article/list', 'ArticleController@getList');
    Route::post('article/delete', 'ArticleController@postDelete');
    Route::post('article/deleteall', 'ArticleController@postDeleteAll');
    Route::post('article/sort', 'ArticleController@postSort');
    // 左侧导航菜单
    Route::get('menu/list', 'MenuController@getList');
    // 栏目树形下拉
    Route::get('cate/select', 'CateController@getSelect');
    // 直接用正则控制所有错误请求到一个地址
    Route::pattern('path','.+');
    Route::any('{path}','ResponseController@anyErrors');
});

// 后台首页，其它页面的导航
Route::group(['prefix'=>'console','middleware' => ['rbac'],'namespace' => 'Admin'],function(){
    // Index
    Route::get('index/index', 'IndexController@getIndex');
    // 直接用正则控制所有请求到一个地址
    Route::pattern('path','.+');
    Route::any('{path}','IndexController@getAll');
});