<?php
/*
 * @package [App\Http\Controllers\Admin]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 日志记录
 *
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Console\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
