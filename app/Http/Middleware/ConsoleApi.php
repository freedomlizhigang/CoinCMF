<?php
/*
 * @package [App\Http\Middleware]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 后台接口权限验证
 *
 */
namespace App\Http\Middleware;

use App\Models\Console\Log;
use Closure;

class ConsoleApi
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
            if(is_null(session('console')))
            {
                return response()->json(['code'=>401,'msg'=>'请先登录！']);
            }
            // 拼接权限名字，url的第二个跟第三个参数
            $toArr = explode('/',$request->path());
            if ($toArr[0] != 'console' || $toArr[1] != 'api') {
                return response()->json(['code'=>401,'msg'=>'此用户无权限！']);
            }
            // 如果不写方法名，默认为index
            $priv = $toArr[2].'-'.$toArr[3];
            // 取当前用户
            $user = session('console');
            // 在这里进行一部分权限判断，主要是判断打开的页面是否有权限
            if(in_array(1,$user->allRole) || in_array($priv,$user->allPriv))
            {
                // 日志记录，只记录post或者del操作(通过比较url来得出结果)
                Log::create(['admin_id'=>$user->id,'method'=>$request->method(),'url'=>$request->fullUrl(),'user'=>$user->name,'data'=>json_encode($request->all()),'created_at'=>date('Y-m-d H:i:s')]);
                $respond = $next($request);
                return $respond;
            }
            else
            {
                return response()->json(['code'=>401,'msg'=>'此用户无权限！']);
            }
        } catch (\Throwable $e) {
            return response()->json(['code'=>401,'msg'=>'此用户无权限！']);
        }
    }
}
