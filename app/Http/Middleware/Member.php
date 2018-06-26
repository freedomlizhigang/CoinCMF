<?php
/*
 * @package [App\Http\Middleware]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 用户验证
 *
 */
namespace App\Http\Middleware;

use Closure;

class Member
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
        if(is_null(session('member')))
        {
            return redirect('/user/login')->with('message','请先登录！');
        }
        else
        {
            return $next($request);
        }
    }
}
