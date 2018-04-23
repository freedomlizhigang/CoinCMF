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
    // Route::auth();
    Route::get('login', 'PublicController@getLogin');
    Route::post('login', 'PublicController@postLogin');
    // 退出登陆
    Route::get('logout', 'PublicController@getLogout');
});

Route::group(['prefix'=>'console','middleware' => ['rbac'],'namespace' => 'Admin'],function(){
    // 广告位
    Route::get('adpos/index', 'Common\AdposController@getIndex');
    Route::get('adpos/add', 'Common\AdposController@getAdd');
    Route::post('adpos/add', 'Common\AdposController@postAdd');
    Route::get('adpos/edit/{id}', 'Common\AdposController@getEdit');
    Route::post('adpos/edit/{id}', 'Common\AdposController@postEdit');
    Route::get('adpos/del/{id}', 'Common\AdposController@getDel');
    // 社区
    Route::get('community/index', 'Common\CommunityController@getIndex');
    Route::get('community/add', 'Common\CommunityController@getAdd');
    Route::post('community/add', 'Common\CommunityController@postAdd');
    Route::get('community/edit/{id}', 'Common\CommunityController@getEdit');
    Route::post('community/edit/{id}', 'Common\CommunityController@postEdit');
    Route::get('community/del/{id}', 'Common\CommunityController@getDel');
    // 省市区域
    Route::get('area/index/{pid?}', 'Common\AreaController@getIndex');
    Route::get('area/add/{pid}', 'Common\AreaController@getAdd');
    Route::post('area/add/{pid}', 'Common\AreaController@postAdd');
    Route::get('area/edit/{id}', 'Common\AreaController@getEdit');
    Route::post('area/edit/{id}', 'Common\AreaController@postEdit');
    Route::get('area/del/{id}', 'Common\AreaController@getDel');
    Route::get('area/get/{pid}', 'Common\AreaController@getGet');
    // 广告管理
    Route::get('ad/index', 'Common\AdController@getIndex');
    Route::get('ad/add', 'Common\AdController@getAdd');
    Route::post('ad/add', 'Common\AdController@postAdd');
    Route::get('ad/edit/{id}', 'Common\AdController@getEdit');
    Route::post('ad/edit/{id}', 'Common\AdController@postEdit');
    Route::get('ad/del/{id}', 'Common\AdController@getDel');
    Route::post('ad/sort', 'Common\AdController@postSort');
    Route::post('ad/alldel', 'Common\AdController@postAlldel');
    // Index
    Route::get('index/index', 'IndexController@getIndex');
    Route::get('index/main', 'IndexController@getMain');
    Route::get('index/left/{id}', 'IndexController@getLeft');
    Route::get('index/cache', 'IndexController@getCache');
    // 系统配置
    Route::get('config/index', 'ConfigController@index');
    Route::post('config/index', 'ConfigController@postIndex');
    // admin
    Route::get('admin/index', 'AdminController@getIndex');
    Route::get('admin/add', 'AdminController@getAdd');
    Route::post('admin/add', 'AdminController@postAdd');
    Route::post('admin/edit/{id?}', 'AdminController@postEdit');
    Route::get('admin/edit/{id?}', 'AdminController@getEdit');
    Route::get('admin/pwd/{id?}', 'AdminController@getPwd');
    Route::post('admin/pwd/{id?}', 'AdminController@postPwd');
    Route::get('admin/del/{id?}', 'AdminController@getDel');
    Route::get('admin/myedit', 'AdminController@getMyedit');
    Route::post('admin/myedit', 'AdminController@postMyedit');
    Route::get('admin/mypwd', 'AdminController@getMypwd');
    Route::post('admin/mypwd', 'AdminController@postMypwd');
    // role
    Route::get('role/index', 'RoleController@getIndex');
    Route::get('role/add', 'RoleController@getAdd');
    Route::post('role/add', 'RoleController@postAdd');
    Route::get('role/edit/{id?}', 'RoleController@getEdit');
    Route::post('role/edit/{id?}', 'RoleController@postEdit');
    Route::get('role/del/{id?}', 'RoleController@getDel');
    Route::get('role/priv/{id?}', 'RoleController@getPriv');
    Route::post('role/priv/{id?}', 'RoleController@postPriv');
    // 部门
    Route::get('section/index', 'SectionController@getIndex');
    Route::get('section/add', 'SectionController@getAdd');
    Route::post('section/add', 'SectionController@postAdd');
    Route::get('section/edit/{id}', 'SectionController@getEdit');
    Route::post('section/edit/{id}', 'SectionController@postEdit');
    Route::get('section/del/{id}', 'SectionController@getDel');
    // menu
    Route::get('menu/index', 'MenuController@getIndex');
    Route::get('menu/add/{id?}', 'MenuController@getAdd');
    Route::post('menu/add/{id?}', 'MenuController@postAdd');
    Route::get('menu/edit/{id}', 'MenuController@getEdit');
    Route::post('menu/edit/{id}', 'MenuController@postEdit');
    Route::get('menu/del/{id}', 'MenuController@getDel');
    // log
    Route::get('log/index', 'LogController@getIndex');
    Route::get('log/del', 'LogController@getDel');
    // cate
    Route::get('cate/index', 'Common\CateController@getIndex');
    Route::get('cate/cache', 'Common\CateController@getCache');
    Route::get('cate/add/{id?}', 'Common\CateController@getAdd');
    Route::post('cate/add/{id?}', 'Common\CateController@postAdd');
    Route::get('cate/edit/{id?}', 'Common\CateController@getEdit');
    Route::post('cate/edit/{id?}', 'Common\CateController@postEdit');
    Route::get('cate/del/{id?}', 'Common\CateController@getDel');
    // attr
    Route::get('attr/index', 'Common\AttrController@getIndex');
    Route::get('attr/delfile/{id?}', 'Common\AttrController@getDelfile');
    // art
    Route::get('art/index', 'Common\ArtController@getIndex');
    Route::get('art/add/{id?}', 'Common\ArtController@getAdd');
    Route::post('art/add/{id?}', 'Common\ArtController@postAdd');
    Route::get('art/edit/{id}', 'Common\ArtController@getEdit');
    Route::post('art/edit/{id}', 'Common\ArtController@postEdit');
    Route::get('art/del/{id}', 'Common\ArtController@getDel');
    Route::get('art/show/{id}', 'Common\ArtController@getShow');
    Route::get('art/select', 'Common\ArtController@getSelect');
    Route::post('art/alldel', 'Common\ArtController@postAlldel');
    Route::post('art/listorder', 'Common\ArtController@postListorder');
    // database
    Route::get('database/export', 'DatabaseController@getExport');
    Route::post('database/export', 'DatabaseController@postExport');
    Route::get('database/import/{pre?}', 'DatabaseController@getImport');
    Route::post('database/delfile', 'DatabaseController@postDelfile');
    // type
    Route::get('type/index/{pid?}', 'Common\TypeController@getIndex');
    Route::get('type/add/{id?}', 'Common\TypeController@getAdd');
    Route::post('type/add/{id?}', 'Common\TypeController@postAdd');
    Route::get('type/edit/{id?}', 'Common\TypeController@getEdit');
    Route::post('type/edit/{id?}', 'Common\TypeController@postEdit');
    Route::get('type/del/{id?}', 'Common\TypeController@getDel');
    // 会员组
    Route::get('group/index', 'User\GroupController@getIndex');
    Route::get('group/add', 'User\GroupController@getAdd');
    Route::post('group/add', 'User\GroupController@postAdd');
    Route::get('group/edit/{id}', 'User\GroupController@getEdit');
    Route::post('group/edit/{id}', 'User\GroupController@postEdit');
    Route::get('group/del/{id}', 'User\GroupController@getDel');
    // 会员
    Route::get('user/index', 'User\UserController@getIndex');
    Route::get('user/edit/{id}', 'User\UserController@getEdit');
    Route::post('user/edit/{id}', 'User\UserController@postEdit');
    Route::get('user/status/{id}/{status}', 'User\UserController@getStatus');
});
