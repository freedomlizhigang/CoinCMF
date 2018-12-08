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
Route::group(['prefix'=>'c-api','namespace' => 'Admin'],function(){
    // 登录
    Route::post('login', 'LoginController@postLogin');
});
// 管理中心API
Route::group(['prefix'=>'c-api','namespace' => 'Admin','middleware'=>['c-api']],function(){
    // 文章管理用的
    Route::get('article/list', 'ArticleController@getList');
    Route::post('article/delete', 'ArticleController@postDelete');
    Route::post('article/deleteall', 'ArticleController@postDeleteAll');
    Route::post('article/sort', 'ArticleController@postSort');
    // 栏目
    Route::get('cate/select', 'CateController@getSelect');
    // 系统配置
    Route::get('config/get', 'ConfigController@getDetail');
    Route::post('config/edit', 'ConfigController@postEdit');
    // 面包屑
    Route::get('breadcrumb/list', 'CommonController@getBreadCrumbList');
    // 管理员管理
    Route::get('admin/list', 'AdminController@getList');
    Route::post('admin/create', 'AdminController@postCreate');
    Route::post('admin/editinfo', 'AdminController@postEditInfo');
    Route::post('admin/editpassword', 'AdminController@postEditPassword');
    Route::post('admin/remove', 'AdminController@postRemove');
    Route::post('admin/status', 'AdminController@postStatus');
    Route::post('admin/detail', 'AdminController@postDetail');
    // 角色管理
    Route::get('role/list', 'RoleController@getList');
    Route::post('role/create', 'RoleController@postCreate');
    Route::post('role/edit', 'RoleController@postEdit');
    Route::post('role/remove', 'RoleController@postRemove');
    Route::post('role/status', 'RoleController@postStatus');
    Route::get('role/priv', 'RoleController@getPriv');
    Route::post('role/priv', 'RoleController@postPriv');
    // 部门管理
    Route::get('section/list', 'SectionController@getList');
    Route::post('section/create', 'SectionController@postCreate');
    Route::post('section/edit', 'SectionController@postEdit');
    Route::post('section/remove', 'SectionController@postRemove');
    Route::post('section/status', 'SectionController@postStatus');
    // 左侧导航菜单
    Route::get('menu/list', 'MenuController@getList');
    Route::get('menu/tree', 'MenuController@getTree');
    Route::get('menu/select', 'MenuController@getSelect');
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