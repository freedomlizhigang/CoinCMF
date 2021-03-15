<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2019-01-03 20:14:16
 * @Description: 管理员登录
 * @LastEditors: 李志刚
 * @LastEditTime: 2021-03-15 16:15:49
 * @FilePath: /CoinCMF/app/Http/Controllers/Console/LoginController.php
 */

namespace App\Http\Controllers\Console;

use Validator;
use App\Customize\Func;
use App\Customize\Sign;
use App\Models\Rbac\Priv;
use Illuminate\Http\Request;
use App\Models\Rbac\Admin;
use App\Models\Rbac\RoleAdmin;
use Illuminate\Support\Facades\Redis;

class LoginController extends ResponseController {
	// 登录
	public function postLogin(Request $req) {
		try {
			// 先验证签名
			$res = Sign::aes_decrypt($req->all());
			if ($res['code'] != 200) {
				return $this->resData(['code' => 403, 'msg' => $res['msg'] . '...', 'data' => []]);
			}
			// 合并解析到的参数进请求中
			$req->merge($res['data']);
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
				return $this->resData(400, $validator->errors()->all()[0] . '...');
			}
			$username = $req->input('name');
			$pwd = $req->input('password');
			$user = Admin::where('status', 1)->where('name', $username)->first();
			if (is_null($user)) {
				return $this->resData(400, '用户不存在或已被禁用...');
			} else {
				if ($user->password != Func::makepwd($pwd, $user->crypt)) {
					return $this->resData(400, '密码不正确...');
				}
				// 更新一些信息
				Admin::where('id', $user->id)->update(['lasttime' => date('Y-m-d H:i:s'), 'lastip' => $req->ip()]);
				$token = md5(md5($user->id . '-SMZ-' . $user->name));
				$allRole = RoleAdmin::where('admin_id', $user->id)->pluck('role_id')->unique()->toArray();
				$allPriv = Priv::whereIn('role_id', $allRole)->pluck('label')->unique()->toArray();
				// 放到redis里边，先删除旧的，有效期一天
				Redis::del('c-token:' . $token);
				Redis::setex('c-token:' . $token, 3600 * 24, json_encode(['id' => $user->id, 'name' => $user->name, 'allRole' => $allRole, 'allPriv' => $allPriv]));
				$res = ['id' => $user->id, 'name' => $user->name, 'token' => $token];
				return $this->resData(200, '登录成功！', $res);
			}
		} catch (\Throwable $e) {
			return $this->resData(500, '获取失败，请稍后再试...',$e->getMessage());
		}
	}
}
