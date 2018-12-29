<?php
/*
 * @package [App\Http\Controllers\Admin\Common]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 友情链接管理
 *
 */
namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\LinkRequest;
use App\Models\Common\Link;
use App\Models\Common\LinkType;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * 友情链接管理
     * @return [type] [description]
     */
    public function getIndex(Request $req)
    {
        try {
            $title = '友情链接管理';
            // 搜索关键字
            $key = $req->input('q','');
            $typeid = $req->input('typeid');
            $types = LinkType::get();
            $list = Link::with('linktype')->where(function($q) use($key){
                        if ($key != '') {
                            $q->where('linkname','like','%'.$key.'%');
                        }
                    })->where(function($q) use($typeid){
                        if ($typeid != '') {
                            $q->where('link_type_id',$typeid);
                        }
                    })->orderBy('sort','desc')->orderBy('id','desc')->paginate(10);
            return view('admin.console.link.index',compact('title','list','key','types','typeid'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    // 添加友情链接
    public function getAdd()
    {
        try {
            $title = '添加友情链接';
            $types = LinkType::get();
            return view('admin.console.link.add',compact('title','types'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postAdd(LinkRequest $req)
    {
        try {
            $data = $req->input('data');
            Link::create($data);
            return $this->adminJson(1,'添加成功！',url('/console/link/index'));
        } catch (\Throwable $e) {
            return $this->adminJson(0,'添加友情链接失败！');
        }
    }
    // 修改友情链接
    public function getEdit($id = '')
    {
        try {
            $title = '修改友情链接';
            $info = Link::findOrFail($id);
            $types = LinkType::get();
            return view('admin.console.link.edit',compact('title','info','types'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postEdit(LinkRequest $req,$id = '')
    {
        try {
            $data = $req->input('data');
            Link::where('id',$id)->update($data);
            return $this->adminJson(1,'修改成功！');
        } catch (\Throwable $e) {
            return $this->adminJson(0,'修改友情链接失败！');
        }
    }
    // 删除
    public function getDel($id = '')
    {
        try {
            Link::where('id',$id)->delete();
            return back()->with('message','删除成功！');
        } catch (\Throwable $e) {
            return back()->with('message','删除失败！');
        }
    }
    // 排序
    public function postSort(Request $req)
    {
        try {
            $ids = $req->input('sids');
            $sort = $req->input('sort');
            if (is_array($ids))
            {
                foreach ($ids as $v) {
                    Link::where('id',$v)->update(['sort'=>(int) $sort[$v]]);
                }
                return back()->with('message', '排序成功！');
            }
            else
            {
                return back()->with('message', '请先选择友情链接！');
            }
        } catch (\Throwable $e) {
            return back()->with('message','排序失败！');
        }
    }
}
