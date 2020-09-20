<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2018-07-25 11:39:56
 * @Description: 附件管理
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-20 20:10:42
 * @FilePath: /CoinCMF/app/Http/Controllers/Console/Content/AttrController.php
 */

namespace App\Http\Controllers\Console\Content;

use Storage;
use App\Models\Common\Attr;
use Illuminate\Http\Request;
use App\Http\Controllers\Console\ResponseController;

class AttrController extends ResponseController
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
