<?php
/*
 * @package [App\Http\Controllers\Admin\Common]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 全国社区信息
 *
 */
namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\CommunityRequest;
use App\Models\Common\Community;
use DB;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    /**
     * 社区列表
     * @return [type] [description]
     */
    public function getIndex(Request $req)
    {
    	$title = '社区管理';
        $q = $req->input('q','');
        // 超级管理员可查看所有部门下社区
        $list = Community::where(function($r)use($q){
            if ($q != '') {
                $r->where('name','like','%$q%');
            }
        })->orderBy('id','desc')->paginate(10);
    	return view('admin.console.community.index',compact('title','list','q'));
    }
    /**
     * 添加社区
     * @param  integer $pid [父社区ID]
     * @return [type]       [description]
     */
    public function getAdd()
    {
    	$title = '添加社区';
    	return view('admin.console.community.add',compact('title'));
    }
    public function postAdd(CommunityRequest $req)
    {
        // 开启事务
        DB::beginTransaction();
        try {
            $data = $req->input('data');
            $resId = Community::create($data);
            // 没出错，提交事务
            DB::commit();
            return $this->adminJson(1, '添加成功！',url('console/community/index'));
        } catch (\Throwable $e) {
            // 出错回滚
            DB::rollBack();
            return $this->adminJson(0, '添加失败，请稍后再试！');
        }
    }
    /**
     * 修改社区
     * @param  string $id [要修改的社区ID]
     * @return [type]     [description]
     */
    public function getEdit($id = '')
    {
        $title = '修改社区';
        $info = Community::findOrFail($id);
        return view('admin.console.community.edit',compact('title','info'));
    }
    public function postEdit(CommunityRequest $req,$id = '')
    {
        // 开启事务
        DB::beginTransaction();
        try {
            $data = $req->input('data');
            Community::where('id',$id)->update($data);
            // 没出错，提交事务
            DB::commit();
            return $this->adminJson(1, '修改成功！');
        } catch (\Throwable $e) {
            // 出错回滚
            DB::rollBack();
            return $this->adminJson(1, '修改失败，请稍后再试！');
        }
    }
    public function getDel($id)
    {
        Community::where('id',$id)->delete();
        return back()->with('message', '删除完成！');
    }
}
