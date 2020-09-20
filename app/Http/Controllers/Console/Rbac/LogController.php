<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2019-01-03 20:14:16
 * @Description: 所有非get请求的日志
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-20 20:02:10
 * @FilePath: /CoinCMF/app/Http/Controllers/Console/Rbac/LogController.php
 */

namespace App\Http\Controllers\Console\Rbac;

use Carbon\Carbon;
use App\Models\Rbac\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Console\ResponseController;

class LogController extends ResponseController
{
	// 查询
    public function getList(Request $req)
    {
        try {
            $title = '日志列表';
            $page = $req->input('page',0);
            $size = $req->input('size',10);
        	// 超级管理员可以查看所有用户日志，其它人只能看自己的
            if ($req->admin_id == '1') {
                $admin_id = $req->input('admin_id',0);
                if ($admin_id != 0) {
                    $list = Log::where('admin_id',$admin_id)->offset(($page - 1) * $size)->limit($size)->orderBy('id','desc')->get();
                    $total = Log::where('admin_id',$admin_id)->count();
                }
                else
                {
                    $list = Log::offset(($page - 1) * $size)->limit($size)->orderBy('id','desc')->get();
                    $total = Log::count();
                }
            }
            else
            {
                $list = Log::where('admin_id',$req->admin_id)->offset(($page - 1) * $size)->limit($size)->orderBy('id','desc')->get();
                $total = Log::where('admin_id',$req->admin_id)->count();
            }
            $res = ['list'=>$list,'total'=>$total];
            return $this->resData(200,'获取成功...',$res);;
        } catch (\Throwable $e) {
            return $this->resData(500,'获取失败，请稍后再试...');
        }
    }
    // 清除7天前日志
    public function postClear()
    {
        try {
            $logs = Log::where('created_at','<',Carbon::now()->addWeek(-1))->delete();
            return $this->resData(200,'操作成功...');;
        } catch (\Throwable $e) {
            return $this->resData(500,'操作失败，请稍后再试...');
        }
    }
}
