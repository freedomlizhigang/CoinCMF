<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2019-01-03 20:14:16
 * @Description: 部门管理
 * @LastEditors: 李志刚
 * @LastEditTime: 2021-03-15 18:01:33
 * @FilePath: /CoinCMF/app/Http/Controllers/Console/Rbac/DepartmentController.php
 */

namespace App\Http\Controllers\Console\Rbac;

use Validator;
use App\Models\Rbac\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Console\ResponseController;
use App\Models\Rbac\Admin;
use App\Models\Rbac\DepartmentAdmin;

class DepartmentController extends ResponseController
{
    /**
     * 部门列表
     * @return [type] [description]
     */
    public function getList()
    {
        try {
            // 所有菜单
            $all = Department::select('id', 'name')->where('status',1)->where('del_flag', 0)->orderBy('id', 'asc')->get();
            return $this->resData(200, '获取成功...', $all);
        } catch (\Throwable $e) {
            return $this->resData(500, '获取失败，请稍后再试...');
        }
    }
    public function getTree()
    {
        try {
            // 所有菜单
            $all = Department::select('id', 'parentid', 'name', 'status')->where('del_flag', 0)->orderBy('id', 'asc')->get();
            $tree = $this->toTree($all, 0);
            return $this->resData(200, '获取成功...', $tree);
        } catch (\Throwable $e) {
            return $this->resData(500, '获取失败，请稍后再试...');
        }
    }
    // 转成树形菜单数组
    private function toTree($data, $pid)
    {
        $tree = [];
        if ($data->count() > 0) {
            foreach ($data as $v) {
                if ($v->parentid == $pid) {
                    $v = ['department_id' => $v->id, 'title' => $v->name, 'status' => $v->status, '_showChildren' => true];
                    $v['children'] = $this->toTree($data, $v['department_id']);
                    $tree[] = $v;
                }
            }
        }
        return $tree;
    }
    // 取下拉框菜单
    public function getSelect()
    {
        try {
            $department = Department::select('id', 'parentid', 'name')->orderBy('id', 'asc')->get();
            $res = [];
            $f_department = $department->where('parentid', 0)->all();
            // 只查三级
            foreach ($f_department as $v) {
                // 一级
                $res[] = ['name' => $v->name, 'id' => $v->id];
                // 二级
                $s_department = $department->where('parentid', $v->id)->all();
                foreach ($s_department as $s) {
                    $res[] = ['name' => '|- ' . $s->name, 'id' => $s->id];
                    // 三级的
                    $t_department = $department->where('parentid', $s->id)->all();
                    foreach ($t_department as $t) {
                        $res[] = ['name' => '||- ' . $t->name, 'id' => $t->id];
                    }
                }
            }
            return $this->resData(200, '获取成功...', $res);
        } catch (\Throwable $e) {
            return $this->resData(500, '获取失败，请稍后再试...');
        }
    }
    // 创建部门
    public function postCreate(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'parentid' => 'required|integer',
                'name' => 'required|max:255',
                'status' => 'required|in:true,false',
            ]);
            $attrs = array(
                'parentid' => '上级部门',
                'name' => '名称',
                'status' => '状态',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $name = $req->input('name');
            $status = $req->input('status') == true ? 1 : 0;
            Department::create(['parentid' => $req->input('parentid', 0), 'name'=>$name,'status'=>$status]);
            // 更新缓存
            app('com')->updateCache(new Department());
            return $this->resData(200,'创建部门成功...');
        } catch (\Throwable $e) {
            return $this->resData(500,'创建部门失败，请稍后再试...');
        }
    }
    // 修改名称
    public function postEdit(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'parentid' => 'integer',
                'department_id' => 'required|integer',
                'name' => 'required|max:255',
                'status' => 'required|in:true,false',
            ]);
            $attrs = array(
                'parentid' => '上级部门',
                'department_id' => '部门ID',
                'name' => '名称',
                'status' => '状态',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $name = $req->input('name');
            $status = $req->input('status') == 'true' ? 1 : 0;
            Department::where('id',$req->input('department_id'))->update(['parentid' => $req->input('parentid', 0), 'name'=>$name,'status'=>$status]);
            // 更新缓存
            app('com')->updateCache(new Department());
            return $this->resData(200,'更新部门名称成功...');
        } catch (\Throwable $e) {
            return $this->resData(500,'更新部门名称失败，请稍后再试...');
        }
    }
    // 修改状态
    public function postStatus(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'department_id' => 'required|integer',
                'status' => 'required|in:true,false',
            ]);
            $attrs = array(
                'department_id' => '部门ID',
                'status' => '状态',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $status = $req->input('status') == 'true' ? 1 : 0;
            Department::where('id',$req->input('department_id'))->update(['status'=>$status]);
            return $this->resData(200,'更新部门状态成功...');
        } catch (\Throwable $e) {
            return $this->resData(500,'更新部门状态失败，请稍后再试...');
        }
    }
    // 查看单条信息
    public function postDetail(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'department_id' => 'required|integer',
            ]);
            $attrs = array(
                'department_id' => '部门ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $section = Department::findOrFail($req->input('department_id'));
            return $this->resData(200, '查询成功...', $section);
        } catch (\Throwable $e) {
            return $this->resData(500, '查询失败，请稍后再试...');
        }
    }
    // 删除部门
    public function postRemove(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'department_id' => 'required|integer',
            ]);
            $attrs = array(
                'department_id' => '部门ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $id = $req->input('department_id');
            $info = Department::find($id);
            $arr = explode(',', $info->arrchildid);
            // 查询下属用户
            if(is_null(DepartmentAdmin::whereIn('department_id', $arr)->first()))
            {
                Department::whereIn('id',$arr)->update(['del_flag'=>1]);
                // 更新缓存
                app('com')->updateCache(new Department());
                return $this->resData(200,'删除部门成功...');
            }
            else
            {
                return $this->resData(403,'部门下有用户...');
            }
        } catch (\Throwable $e) {
            return $this->resData(500,'删除部门失败，请稍后再试...',$e->getMessage());
        }
    }
    /**
     * 角色下用户列表
     * @return [type] [description]
     */
    public function postAdminList(Request $req)
    {
        try {
            $admin_ids = DepartmentAdmin::where('department_id', $req->input('department_id'))->pluck('admin_id');
            $list = Admin::whereIn('id', $admin_ids)->orderBy('id', 'asc')->get();
            return $this->resData(200, '获取数据成功...', $list);
        } catch (\Throwable $e) {
            return $this->resData(500, '获取数据失败，请稍后再试！', []);
        }
    }
    /**
     * 移出角色下用户
     * @return [type] [description]
     */
    public function postRemoveAdmin(Request $req)
    {
        try {
            DepartmentAdmin::where('admin_id', $req->input('admin_id'))->delete();
            return $this->resData(200, '操作成功...');
        } catch (\Throwable $e) {
            return $this->resData(500, '操作失败，请稍后再试！', []);
        }
    }
}
