<?php
/*
 * @package [App\Http\Controllers\Admin]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 部门管理
 *
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Models\Console\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function getIndex(Request $res)
    {
    	$title = '部门列表';
        $list = Section::orderBy('id','desc')->paginate(10);
        return view('admin.console.section.index',compact('list','title'));
    }

    // 添加部门
    public function getAdd()
    {
        $title = '添加部门';
        return view('admin.console.section.add',compact('title'));
    }

    public function postAdd(SectionRequest $request)
    {
        $data = $request->input('data');
        Section::create($data);
        return $this->adminJson(1,'添加部门成功！',url('/console/section/index'));
    }
    // 修改部门
    public function getEdit($id)
    {
        $title = '修改部门';
        // 拼接返回用的url参数
        $info = Section::findOrFail($id);
        return view('admin.console.section.edit',compact('title','info'));
    }
    public function postEdit(SectionRequest $request,$id)
    {
        Section::where('id',$id)->update($request->input('data'));
        return $this->adminJson(1,'修改部门成功！');
    }
    // 删除部门
    public function getDel($id)
    {
        // 查询下属用户
        if(is_null(Admin::where('section_id',$id)->first()))
        {
            // 开启事务
            DB::beginTransaction();
            try {
                // 同时删除关联的用户关系
                Section::destroy($id);
                // 没出错，提交事务
                DB::commit();
                return back()->with('message', '删除部门成功！');
            } catch (\Throwable $e) {
                // 出错回滚
                DB::rollBack();
                return back()->with('message','删除失败，请稍后再试！');
            }
        }
        else
        {
            return back()->with('message', '部门下有用户！');
        }

    }
}
