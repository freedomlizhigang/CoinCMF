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

// 管理中心API
Route::group(['prefix'=>'c-api','namespace' => 'Admin\Api'],function(){
    // 登录
    Route::post('login', 'LoginController@postLogin');
});
// 管理中心API
Route::group(['prefix'=>'c-api','namespace' => 'Admin\Api','middleware'=>['c-api']],function(){
    // 文章管理用的
    Route::get('article/list', 'ArticleController@getList');
    Route::post('article/delete', 'ArticleController@postDelete');
    Route::post('article/deleteall', 'ArticleController@postDeleteAll');
    Route::post('article/sort', 'ArticleController@postSort');
    // 栏目
    Route::get('cate/select', 'CateController@getSelect');
    // 面包屑
    Route::get('breadcrumb/list', 'CommonController@getBreadCrumbList');
    // 左侧导航菜单
    Route::get('menu/list', 'MenuController@getList');
    Route::get('menu/tree', 'MenuController@getTree');
    Route::post('menu/detail', 'MenuController@postDetail');
    Route::post('menu/create', 'MenuController@postCreate');
    Route::post('menu/edit', 'MenuController@postEdit');
    Route::post('menu/remove', 'MenuController@postRemove');
    // 直接用正则控制所有错误请求到一个地址
    Route::pattern('path','.+');
    Route::any('{path}','ResponseController@anyErrors');
});

// 后台首页，其它页面的导航
Route::group(['prefix'=>'console','namespace' => 'Admin'],function(){
    // 直接用正则控制所有请求到一个地址
    Route::pattern('path','.+');
    Route::any('{path}','IndexController@getIndex');
});