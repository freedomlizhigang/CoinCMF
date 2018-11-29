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

// 管理中心用的
Route::group(['prefix'=>'console/api','middleware' => ['consoleapi'],'namespace' => 'Admin\Api'],function(){
    // article
    Route::get('article/list', 'ArticleController@getList');
    Route::post('article/delete', 'ArticleController@postDelete');
    Route::post('article/deleteall', 'ArticleController@postDeleteAll');
    Route::post('article/sort', 'ArticleController@postSort');
});