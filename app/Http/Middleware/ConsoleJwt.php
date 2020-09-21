<?php
/*
 * @package [App\Http\Middleware]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 后台管理权限验证，日志记录
 *
 */
namespace App\Http\Middleware;

use App\Customize\Sign;
use Closure;
use Illuminate\Support\Facades\Redis as Redis;

class ConsoleJwt {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		try {
			// 先验证签名
			$res = Sign::aes_decrypt($request->all());
			if ($res['code'] != 200) {
				return response()->json(['code' => 403, 'msg' => $res['msg'] . '...', 'data' => []]);
			}
			// 合并解析到的参数进请求中
			$request->merge($res['data']);
			// 验证 token
			$token = $request->header('Authorization');
			if (is_null($token) || $token == '') {
				return response()->json(['code' => 401, 'msg' => '请重新登录，获取验证信息...', 'data' => []]);
			}
			// 查有没有这个用户，及用户状态
			$hav = Redis::exists('c-token:' . $token);
			if (!$hav) {
				return response()->json(['code' => 401, 'msg' => '验证信息无效，请重新登录...', 'data' => []]);
			}
			$token_info = Redis::get('c-token:' . $token);
			// 解析用户信息，判断权限
			$user = json_decode($token_info);
			// 拼接权限名字，url的第二个跟第三个参数
			$toArr = explode('/', $request->path());
			if ($toArr[0] != 'c-api') {
				return response()->json(['code' => 402, 'msg' => '无权调用此接口数据...', 'data' => '1']);
			}
			// 如果不写方法名，默认为index
			$toArr[2] = count($toArr) == 2 ? 'index' : $toArr[2];
			$priv = $toArr[1] . '-' . $toArr[2];
			// 在这里进行一部分权限判断，主要是判断打开的页面是否有权限，所有角色ID，所有角色权限累加
			if ($user->id == '1' || in_array(1, $user->allRole) || in_array($priv, (array) $user->allPriv)) {
				// 日志记录，只记录post或者del操作(通过比较url来得出结果)
				$request->req_user = $user;
				$request->req_priv = $priv;
				$response = $next($request);
				return $response;
			} else {
				return response()->json(['code' => 402, 'msg' => '无权调用此接口数据...', 'data' => '2']);
			}
		} catch (\Throwable $e) {
			// dd($e);
			return response()->json(['code' => 401, 'msg' => '验证权限失败...', 'data' => '']);
		}
	}
}
