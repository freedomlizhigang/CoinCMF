<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // 登陆判断
    public function getLogin(Request $req)
    {
        try {
            // 存下来源页面
            $backurl = url()->previous() == '' || url()->previous() == config('app.url').'/login' ? url('/') : url()->previous();
            session()->put('home_backurl',$backurl);
            if (!session()->has('member')) {
                $wechat = app('wechat.official_account');
                $oauth = $wechat->oauth->withRedirectUrl(config('app.url').'/wxlogin');
                return $oauth->redirect();
            }
            else
            {
                return redirect($backurl);
            }
        } catch (\Throwable $e) {
            $message = '登录页面出问题了~';
            return view('errors.404',compact('message'));
        }
    }
    // 微信直接登陆
    public function getWxLogin(Request $req)
    {
        try {
            $backurl = session('home_backurl') == '' || session('home_backurl') == url('/login') ? url('/') : session('home_backurl');
            $wechat = app('wechat.official_account');
            $oauth = $wechat->oauth;
            // 获取 OAuth 授权结果用户信息
            $wxuser = $oauth->user();
            // 判断是否取得了微信用户信息
            if (is_null($wxuser) || is_null($wxuser->id)) {
                return redirect($backurl);
            }
            // 查一下有没有绑定过的
            $sid = 0;
            $user = User::where('openid',$wxuser->id)->where('delflag',0)->first();
            if (!is_null($user)) {
                $sid = $user->id;
            }
            session()->put('member',(object)['openid'=>$wxuser->id,'staff_id'=>$sid]);
            return redirect($backurl);
        } catch (\Throwable $e) {
            // dd($e);
            return redirect($backurl);
        }
    }
}
