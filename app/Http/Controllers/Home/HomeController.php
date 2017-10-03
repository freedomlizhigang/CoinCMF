<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Common\BaseController;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
      $user = json_encode(['id'=>1,'name'=>'Li']);
      return view('home.layout',compact('user'));
    }
    // 微信授权页面
    public function wxlogin()
    {
    	$wechat = app('wechat');
		$oauth = $wechat->oauth;
		// 获取 OAuth 授权结果用户信息
		$user = $oauth->user();
		session()->put('wechat_user',$user->toArray());
		return redirect('/');
    }
}
