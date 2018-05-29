<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Common\BaseController;
use App\Models\Common\Article;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $req)
    {
        // $all = Article::where('id',8)->update(['title'=>'就是要调试一下jieba分词好用']);
        // Article::where('id',8)->searchable();
        // // dump($all);
        // $search = Article::search($req->key)->get()->toArray();
        // dump($search);
        // foreach ($all as $key => $value) {
        //     dump($value->title);
        // }
        dd('xycmf');
        // $user = json_encode(['id'=>1,'name'=>'Li']);
        // return view('home.layout',compact('user'));
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
