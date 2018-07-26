<?php
/*
 * @package [App\Http\Controllers\Admin\Common]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 附件管理
 *
 */
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Common\Attr;
use Illuminate\Http\Request;
use Storage;

class AttrController extends Controller
{
    public function getIndex(Request $res)
    {
        try {
            $title = '附件列表';
            // 搜索关键字
            $key = trim($res->input('q'));
            $starttime = $res->input('starttime');
            $endtime = $res->input('endtime');
            $list = Attr::orderBy('id','desc')->where(function($q) use($key){
                    if ($key != '') {
                        $q->where('filename','like','%'.$key.'%');
                    }
                })->where(function($q) use($starttime){
                    if ($starttime != '') {
                        $q->where('created_at','>',$starttime);
                    }
                })->where(function($q) use($endtime){
                    if ($endtime != '') {
                        $q->where('created_at','<',$endtime);
                    }
                })->paginate(10);
            return view('admin.console.attr.index',compact('title','list','key','starttime','endtime'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    // 删除文件
    public function getDelfile(Request $res,$id = '')
    {
        try {
            // 找localurl
            $url = Attr::where('id',$id)->value('url');
            if (!is_null($url)) {
                // 数据库删除
                Attr::destroy($id);
                // 文件删除
                // Storage::delete($url);
            }
            return back()->with('message', '删除附件成功！');
        } catch (\Throwable $e) {
            return back()->with('message', '删除附件失败！');
        }
    }
}
