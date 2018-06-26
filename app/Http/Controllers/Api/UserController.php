<?php
/*
 * @package [App\Http\Controllers\Api]
 * @author [李志刚]
 * @createdate  [2018-05-02]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 用户 API
 *
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use Redis;

class UserController extends Controller
{
	/**
     * 获取Jwt认证的Token信息
     * method: POST
     * request:[openid]
     */
    public function postLogin(Request $req){
        try {
            $validator = Validator::make($req->input(), [
                'code' => 'required|max:255',
            ]);
             $attrs = array(
                'code' => '微信授权code参数',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                $result = $this->resJson(204,$validator->errors()->all()[0],'');
                return $result;
            }
            // 微信认证部分
            $code = $req->input('code');
            $app = app('wechat.mini_program');
            try{
                $data = $app->auth->session($code);
                if(!isset($data['openid'])) return $this->resJson(204,'微信授权登录失败+1');
            }catch (\Throwable $e){
                return $this->resJson(204,'微信授权登录失败+2');
            }
            $openid = $data['openid'];
            $isnew = 0;
            DB::beginTransaction();
            try {
                /*
                * 查有没有
                * 1. 有，直接登陆
                * 2. 没有，先生成UUID，再生成用户，登陆
                 */
                $uuid = Uuid::where('openid',$openid)->value('uuid');
                if (is_null($uuid)) {
                    $uuid = app('com')->create_uuid();
                    Uuid::create(['uuid'=>$uuid,'openid'=>$openid]);
                    $user = User::create(['uuid'=>$uuid]);
                    $isnew = 1;
                }
                else
                {
                    $user = User::where('uuid',$uuid)->select('uuid','phone','username','nickname','thumb','token','token_time')->first();
                    if (is_null($user->nickname) || is_null($user->thumb)) {
                        $isnew = 1;
                    }
                }
                $token = $user->token;
                // 过期再更新token
                $havtoken = Redis::get('token:'.$token);
                if (is_null($havtoken) || $user->token_time <= time() - 24*3600) {
                    $token_time = config('jwt.addtime');
                    // 新的token生成方式，不可反解析
                    $token = md5(md5($uuid.config('jwt.jwt-key').$token_time));
                    User::where('uuid',$uuid)->update(['token'=>$token,'token_time'=>$token_time]);
                    // 放到redis里边，jwt用，先删除旧的
                    Redis::del('token:'.$user->token);
                    Redis::setex('token:'.$token,3600*24*365,json_encode(['uuid'=>$uuid,'token_time'=>$token_time]));
                }
                DB::commit();
                $res = ['openid'=>$openid,'token'=>$token,'isnew'=>$isnew,'uuid'=>$uuid];
                return $this->resJson(200,'获取成功！',$res);
            } catch (\Throwable $e) {
                DB::rollback();
                // return $this->resJson(204,$e->getLine().': '.$e->getMessage());
                return $this->resJson(204,'登录失败，请稍后再试+1！');
            }
        } catch (\Throwable $e) {
            return $this->resJson(204,'登录失败，请稍后再试！');
        }
    }
	// 注册
    public function postRegister(Request $req)
    {
    	$validator = Validator::make($req->input(), [
	        'username' => 'required|between:2,20',
	        'password' => 'required|between:6,20',
	        'email' => 'required|email',
	    ]);
	     $attrs = array(
            'username' => '用户名',
            'password' => '密码',
            'email' => '邮箱',
        );
        $validator->setAttributeNames($attrs);
        if ($validator->fails()) {
            // 如果有错误，提示第一条
            $result = $this->resJson(204,$validator->errors()->all()[0],'');
            return $result;
        }

    	if(!is_null(session('member')))
		{
			return redirect(url()->previous())->with('message','您已登录！');
		}

		$username = trim($req->username);
    	// 查一样有没有重复的用户名
    	$ishav = User::where('username',$username)->first();
    	if (!is_null($ishav)) {
    		return $this->resJson(204,'用户名已经被使用，请换一个再试！');
    	}
    	$pwd = encrypt($req->passwords);
    	$email = $req->email;
    	try {
	    	$user = User::create(['username'=>$username,'password'=>$pwd,'email'=>$email,'last_ip'=>$req->ip(),'last_time'=>Carbon::now()->toDateTimeString()]);
	    	// 生成token并更新
	    	$token = encrypt($user->id.'.'.config('jwt.jwt-key').'.'.config('jwt.addtime'));
	    	User::where('id',$user->id)->update(['token'=>$token]);
	    	$user->token = $token;
	    	return $this->resJson(200,'注册成功!',$user);
    	} catch (\Throwable $e) {
    		return $this->resJson(204,$e->getMessage());
    	}
    }
    // 退出登录
    public function postLogout(Request $req)
    {
    	$validator = Validator::make($req->input(), [
	        'token' => 'required',
	        'uid' => 'required|integer',
	    ]);
	     $attrs = array(
            'token' => 'Token',
            'uid' => '用户ID',
        );
        $validator->setAttributeNames($attrs);
        if ($validator->fails()) {
            // 如果有错误，提示第一条
            $result = $this->resJson(204,$validator->errors()->all()[0],'');
            return $result;
        }
    	// 清除token
    	User::where('id',$req->uid)->update(['token'=>'']);
    	return $this->resJson(200,'退出成功！');
    }
}
