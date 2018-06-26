<?php
/*
 * @package [App\Http\Middleware]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions token验证方法
 *
 */
namespace App\Http\Middleware;

use App\Models\User\User;
use Closure;

class Jwt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            // 反向解析token
            $token = $request->token;
            // 查有没有这个用户，及用户状态
            $hav = Redis::exists('token:'.$token);
            if (!$hav) {
                return response()->json(['code'=>401,'msg' => 'Token无效+1！']);
            }
            $token_info = Redis::get('token:'.$token);
            $token_info = json_decode($token_info);
            // $user = User::where('token',$token)->first();
            // 先判断时间及key的正确性
            if($token != md5(md5($token_info->uuid.config('jwt.jwt-key').$token_info->token_time)))
            {
                return response()->json(['code'=>401,'msg' => 'Token无效！'.$token]);
            }
            if($token_info->token_time <= time())
            {
                return response()->json(['code'=>401,'msg' => 'Token过期！']);
            }
            // if (!$user->status) {
            //     return response()->json(['code'=>401,'msg' => '用户被禁用，请联系管理员！']);
            // }
            $request->uuid = $token_info->uuid;
            return $next($request);
        } catch (\Throwable $e) {
            return response()->json(['code'=>401,'msg' => '用户身份验证失败！']);
        }
    }
}
