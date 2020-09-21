<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-09-21 08:42:29
 * @Description: 后端请求日志统一处理
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-21 09:39:27
 * @FilePath: /CoinCMF/app/Http/Middleware/ConsoleLog.php
 */

namespace App\Http\Middleware;

use Closure;
use App\Models\Rbac\Log;

class ConsoleLog
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
        return $next($request);
    }
    public function terminate($request, $response)
    {
        // 此处记录请求及响应
        if (!$request->isMethod('get')) {
            $user = $request->req_user;
            $priv = $request->req_priv;
            if (is_null($user)) {
                $user = (object) ['id' => 0, 'name' => '0'];
            }
            Log::create(['admin_id' => $user->id, 'user' => $user->name, 'method' => $request->method(), 'url' => $request->fullUrl(), 'action_name' => $priv, 'data' => json_encode($request->all()), 'res_data' => json_encode($response->original), 'created_at' => date('Y-m-d H:i:s')]);
        }
    }
}
