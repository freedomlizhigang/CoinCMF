<?php
/*
 * @package [App\Http\Controllers\Admin\Common]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 分类管理
 *
 */
namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\TypeRequest;
use App\Models\Common\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * 分类列表
     * @return [type] [description]
     */
    public function getIndex($pid = 0)
    {
    	try {
            $title = '分类管理';
            $list = Type::where('parentid',$pid)->orderBy('sort','asc')->get();
        	return view('admin.console.type.index',compact('title','list','pid'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    /**
     * 添加分类
     * @param  integer $pid [父分类ID]
     * @return [type]       [description]
     */
    public function getAdd($pid = '0')
    {
        try {
        	$title = '添加分类';
        	return view('admin.console.type.add',compact('title','pid'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postAdd(TypeRequest $req,$pid = '0')
    {
        // 开启事务
        try {
            $data = $req->input('data');
            $resId = Type::create($data);
            // 后台用户组权限
            app('com')->updateCache(new Type(),'typeCache',1);
            return $this->adminJson(1,'添加成功！');
        } catch (\Throwable $e) {
            return $this->adminJson(0,'添加失败，请稍后再试！');
        }
    }
    /**
     * 修改分类
     * @param  string $id [要修改的分类ID]
     * @return [type]     [description]
     */
    public function getEdit($id = '')
    {
        try {
            $title = '修改分类';
            $info = Type::findOrFail($id);
            $all = Type::orderBy('sort','asc')->get();
            $tree = app('com')->toTree($all,'0');
            $treeHtml = app('com')->toTreeSelect($tree,$info->parentid);
            return view('admin.console.type.edit',compact('title','info','treeHtml'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postEdit(TypeRequest $req,$id = '')
    {
        try {
            $data = $req->input('data');
            Type::where('id',$id)->update($data);
            // 更新缓存
            app('com')->updateCache(new Type(),'typeCache',1);
            return $this->adminJson(1,'修改成功！');
        } catch (\Throwable $e) {
            return $this->adminJson(0,'修改失败，请稍后再试！');
        }
    }
    public function getDel($id)
    {
        try {
            // 先找出所有子分类
            $allChild = Type::where('id',$id)->value('arrchildid');
            // 所有子分类ID转换为集合，查看是否含有文章或者专题
            $childs = collect(explode(',',$allChild));
            Type::destroy($childs);
            app('com')->updateCache(new Type(),'typeCache',1);
            return back()->with('message', '删除成功！');
        } catch (\Throwable $e) {
            return back()->with('message','删除失败，请稍后再试！');
        }
    }
}
