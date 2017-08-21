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
    public function index()
    {
    	$wechat = app('wechat');
    	/*$oauth = $wechat->oauth;
    	// 未登录
		if (!session()->has('wechat_user')) {
			return $oauth->redirect();
		}
		// 已经登录过
		$user = session('wechat_user');*/
        // 分享
        $js = $wechat->js;
        return view($this->theme.'.home',compact('js'));
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
