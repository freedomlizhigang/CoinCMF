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
use App\Models\Console\Admin;
use App\Models\Console\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogController extends Controller
{
	// 查询
    public function getIndex(Request $res)
    {
        try {
        	$title = '日志列表';
        	$admins = Admin::select('id','realname','name')->get();
        	// 超级管理员可以查看所有用户日志，其它人只能看自己的
        	if (session('console')->id === 1) {
        		$admin_id = $res->input('admin_id',0);
        		if ($admin_id != 0) {
        			$list = Log::where('admin_id',$admin_id)->orderBy('id','desc')->paginate(10);
        		}
        		else
        		{
        			$list = Log::orderBy('id','desc')->paginate(10);
        		}
        	}
        	else
        	{
        		$list = Log::where('admin_id',Auth::guard('admin')->user()->id)->orderBy('id','desc')->paginate(10);
        	}
        	return view('admin.console.log.index',compact('title','list','admins'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    // 清除7天前日志
    public function getDel()
    {
        try {
        	$logs = Log::where('created_at','<',Carbon::now()->addWeek(-1))->delete();
            return back()->with('message','清除成功！');
        } catch (\Throwable $e) {
        	return back()->with('message','清除失败！');
        }
    }
}
