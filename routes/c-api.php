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
Route::group(['prefix'=>'c-api','namespace' =>'Console', 'middleware' => ['c-log']],function(){
    // 登录
    Route::post('login', 'LoginController@postLogin');
});
// 文件上传
Route::group(['prefix' => 'common', 'namespace' => 'Common'], function () {
    Route::post('/upload/file', 'FileController@postFile');
    Route::post('/upload/base64', 'FileController@postBase64');
});
// 管理中心API
Route::group(['prefix'=>'c-api','namespace' => 'Console','middleware'=>['c-api', 'c-log']],function(){
    // 友情链接管理
    Route::group(['prefix' => 'link','namespace' => 'Content'], function (){
        Route::get('/list', 'LinkController@getList');
        Route::post('/create', 'LinkController@postCreate');
        Route::post('/detail', 'LinkController@postDetail');
        Route::post('/edit', 'LinkController@postEdit');
        Route::post('/remove', 'LinkController@postRemove');
        Route::post('/sort', 'LinkController@postSort');
    });
    // 广告管理
    Route::group(['prefix' => 'ad', 'namespace' => 'Content'], function () {
        Route::get('/list', 'AdController@getList');
        Route::post('/create', 'AdController@postCreate');
        Route::post('/detail', 'AdController@postDetail');
        Route::post('/edit', 'AdController@postEdit');
        Route::post('/remove', 'AdController@postRemove');
        Route::post('/sort', 'AdController@postSort');
    });
    // 广告位管理
    Route::group(['prefix' =>'adpos', 'namespace' => 'Content'], function () {
        Route::get('/list', 'AdPosController@getList');
        Route::post('/create', 'AdPosController@postCreate');
        Route::post('/detail', 'AdPosController@postDetail');
        Route::post('/edit', 'AdPosController@postEdit');
        Route::post('/remove', 'AdPosController@postRemove');
    });
    // 文章管理用的
    Route::group(['prefix' => 'article', 'namespace' => 'Content'], function () {
        Route::get('list', 'ArticleController@getList');
        Route::post('create', 'ArticleController@postCreate');
        Route::get('detail', 'ArticleController@getDetail');
        Route::post('edit', 'ArticleController@postEdit');
        Route::post('remove', 'ArticleController@postRemove');
        Route::post('sort', 'ArticleController@postSort');
        Route::post('deleteall', 'ArticleController@postDeleteAll');
    });
    // 栏目
    Route::group(['prefix' => 'cate', 'namespace' => 'Content'], function () {
        Route::get('select', 'CateController@getSelect');
        Route::get('list', 'CateController@getList');
        Route::post('create', 'CateController@postCreate');
        Route::get('detail', 'CateController@getDetail');
        Route::post('edit', 'CateController@postEdit');
        Route::post('remove', 'CateController@postRemove');
        Route::post('sort', 'CateController@postSort');
    });
    // 分类管理
    Route::group(['prefix' => 'type', 'namespace' => 'Common'], function () {
        Route::get('list', 'TypeController@getList');
        Route::post('detail', 'TypeController@postDetail');
        Route::post('create', 'TypeController@postCreate');
        Route::post('edit', 'TypeController@postEdit');
        Route::post('sort', 'TypeController@postSort');
        Route::post('remove', 'TypeController@postRemove');
    });
    // 系统配置
    Route::group(['prefix' => 'config', 'namespace' => 'Common'],function () {
        Route::get('get', 'ConfigController@getDetail');
        Route::post('edit', 'ConfigController@postEdit');
    });
    // 面包屑
    Route::group(['namespace' => 'Common'], function () {
        Route::get('breadcrumb/list', 'CommonController@getBreadCrumbList');
    });
    // 日志
    Route::group(['prefix' => 'log', 'namespace' => 'Rbac'], function () {
        Route::get('list', 'LogController@getList');
        Route::post('clear', 'LogController@postClear');
    });
    // 个人修改资料
    Route::group(['prefix' => 'admin', 'namespace' => 'Rbac'], function () {
        Route::post('selfeditinfo', 'AdminController@postSelfEditInfo');
        Route::post('selfeditpassword', 'AdminController@postSelfEditPassword');
        // 管理员管理
        Route::get('list', 'AdminController@getList');
        Route::post('create', 'AdminController@postCreate');
        Route::post('editinfo', 'AdminController@postEditInfo');
        Route::post('editpassword', 'AdminController@postEditPassword');
        Route::post('remove', 'AdminController@postRemove');
        Route::post('status', 'AdminController@postStatus');
        Route::post('detail', 'AdminController@postDetail');
    });
    // 角色管理
    Route::group(['prefix' => 'role', 'namespace' => 'Rbac'], function () {
        Route::get('list', 'RoleController@getList');
        Route::post('create', 'RoleController@postCreate');
        Route::post('edit', 'RoleController@postEdit');
        Route::post('remove', 'RoleController@postRemove');
        Route::post('status', 'RoleController@postStatus');
        Route::get('priv', 'RoleController@getPriv');
        Route::post('priv', 'RoleController@postPriv');
    });
    // 部门管理
    Route::group(['prefix' => 'section', 'namespace' => 'Rbac'], function () {
        Route::get('list', 'SectionController@getList');
        Route::post('create', 'SectionController@postCreate');
        Route::post('edit', 'SectionController@postEdit');
        Route::post('remove', 'SectionController@postRemove');
        Route::post('status', 'SectionController@postStatus');
    });
    // 左侧导航菜单
    Route::group(['prefix' => 'menu', 'namespace' => 'Rbac'], function () {
        Route::get('list', 'MenuController@getList');
        Route::get('tree', 'MenuController@getTree');
        Route::get('select', 'MenuController@getSelect');
        Route::post('detail', 'MenuController@postDetail');
        Route::post('create', 'MenuController@postCreate');
        Route::post('edit', 'MenuController@postEdit');
        Route::post('remove', 'MenuController@postRemove');
    });
    // 直接用正则控制所有错误请求到一个地址
    Route::pattern('path','.+');
    Route::any('{path}','ResponseController@anyErrors');
});