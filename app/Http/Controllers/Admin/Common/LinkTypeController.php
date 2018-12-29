<?php
/*
 * @package [App\Http\Controllers\Admin\Common]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 友情链接分类管理
 *
 */
namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\LinkTypeRequest;
use App\Models\Common\Link;
use App\Models\Common\LinkType;
use Illuminate\Http\Request;

class LinkTypeController extends Controller
{
    public function getIndex(Request $res)
    {
        try {
            $title = '友情链接分类列表';
            $list = LinkType::orderBy('id','desc')->paginate(10);
            return view('admin.console.linktype.index',compact('list','title'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }

    // 添加友情链接分类
    public function getAdd()
    {
        try {
            $title = '添加友情链接分类';
            return view('admin.console.linktype.add',compact('title'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }

    public function postAdd(LinkTypeRequest $request)
    {
        try {
            $data = $request->input('data');
            LinkType::create($data);
            return $this->adminJson(1,'添加友情链接分类成功！',url('/console/linktype/index'));
        } catch (\Throwable $e) {
            return $this->adminJson(0,'添加友情链接分类失败！');
        }
    }
    // 修改友情链接分类
    public function getEdit($id)
    {
        try {
            $title = '修改友情链接分类';
            // 拼接返回用的url参数
            $info = LinkType::findOrFail($id);
            return view('admin.console.linktype.edit',compact('title','info'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postEdit(LinkTypeRequest $request,$id)
    {
        try {
            LinkType::where('id',$id)->update($request->input('data'));
            return $this->adminJson(1,'修改友情链接分类成功！');
        } catch (\Throwable $e) {
            return $this->adminJson(0,'修改友情链接分类失败！');
        }
    }
    // 删除友情链接分类
    public function getDel($id)
    {
        try {
            // 查询下属链接
            if(is_null(Link::where('link_type_id',$id)->first()))
            {
                try {
                    LinkType::destroy($id);
                    return back()->with('message', '删除友情链接分类成功！');
                } catch (\Throwable $e) {
                    return back()->with('message','删除失败，请稍后再试！');
                }
            }
            else
            {
                return back()->with('message', '友情链接分类下有用户！');
            }
        } catch (\Throwable $e) {
            return view('errors.500');
        }

    }
}
