<?php

namespace App\Http\Controllers\Admin\Api;

use App\Customize\Func;
use App\Http\Controllers\Controller;
use App\Models\Console\Admin;
use App\Models\Console\Priv;
use App\Models\Console\RoleUser;
use Illuminate\Http\Request;
use Redis;
use Validator;

class LoginController extends ResponseController
{
    // 登录
    public function postLogin(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'name' => 'required|min:2|max:15',
                'password' => 'required|min:6|max:15',
            ]);
             $attrs = array(
                'name' => '用户名',
                'password' => '密码',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $username = $req->input('name');
            $pwd = $req->input('password');
            $user = Admin::where('status',1)->where('name',$username)->first();
            if (is_null($user)) {
                return $this->resData(400,'用户不存在或已被禁用...');
            }
            else
            {
                if ($user->password != Func::makepwd($pwd,$user->crypt)) {
                    return $this->resData(400,'密码不正确...');
                }
                $token = md5(md5($user->id.'-SMZ-'.$user->name));
                $allRole = RoleUser::where('user_id',$user->id)->pluck('role_id')->unique()->toArray();
                $allPriv = Priv::whereIn('role_id',$allRole)->pluck('label')->unique()->toArray();
                // 放到redis里边，先删除旧的，有效期一天
                Redis::del('c-token:'.$token);
                Redis::setex('c-token:'.$token,3600*24,json_encode(['id'=>$user->id,'name'=>$user->name,'allRole'=>$allRole,'allPriv'=>$allPriv]));
                $res = ['id'=>$user->id,'name'=>$user->name,'token'=>$token];
                return $this->resData(200,'登录成功！',$res);
            }
        } catch (\Throwable $e) {
            return $this->resData(400,'获取失败，请稍后再试...');
        }
    }
}
