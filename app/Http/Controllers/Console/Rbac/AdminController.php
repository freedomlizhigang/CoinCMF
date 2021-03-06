<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2019-01-03 20:14:16
 * @Description: 管理员管理
 * @LastEditors: 李志刚
 * @LastEditTime: 2021-03-15 17:22:12
 * @FilePath: /CoinCMF/app/Http/Controllers/Console/Rbac/AdminController.php
 */

namespace App\Http\Controllers\Console\Rbac;

use DB;
use Validator;
use App\Customize\Func;
use App\Models\Rbac\Admin;
use Illuminate\Http\Request;
use App\Models\Rbac\RoleAdmin;
use App\Http\Controllers\Console\ResponseController;
use App\Models\Rbac\DepartmentAdmin;

class AdminController extends ResponseController
{
    /**
     * 用户列表
     * @return [type] [description]
     */
    public function getList(Request $req)
    {
        try {
            // 搜索关键字
            $key = $req->input('key','');
            $page = $req->input('page', 1);
            $size = $req->input('size', 10);
            $list = Admin::where(function($q) use($key){
                    if ($key != '') {
                        $q->where('name','like','%'.$key.'%');
                    }
                })->limit($size)->offset(($page - 1) * $size)->orderBy('id','asc')->get();
            $count = Admin::where(function ($q) use ($key) {
                if ($key != '') {
                    $q->where('name', 'like', '%' . $key . '%');
                }
            })->count();
            return $this->resData(200,'获取用户数据成功...', ['list' => $list, 'count' => $count]);
        } catch (\Throwable $e) {
            return $this->resData(500,'获取数据失败，请稍后再试！',[]);
        }
    }
    // 查看单条信息
    public function postDetail(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'admin_id' => 'required|integer',
            ]);
            $attrs = array(
                'admin_id' => '用户ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $admin = Admin::findOrFail($req->input('admin_id'));
            $admin->department_ids = $admin->department->pluck('id');
            $admin->role_ids = $admin->role->pluck('id');
            return $this->resData(200,'查询成功...',$admin);
        } catch (\Throwable $e) {
            return $this->resData(500,'查询失败，请稍后再试...');
        }
    }
    // 创建用户
    public function postCreate(Request $req)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($req->input(), [
                'name' => 'required|max:255',
                'realname' => 'required|max:255',
                'phone' => 'nullable|regex:/^1[3456789]\d{9}$/',
                'email' => 'nullable|email',
                'password' => 'confirmed|min:6|max:15|alpha_dash',
            ]);
            $attrs = array(
                'name' => '名称',
                'realname' => '姓名',
                'phone' => '手机号',
                'email' => '邮箱',
                'password' => '密码',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $crypt = Func::str_random(10);
            $pwd = Func::makepwd($req->input('password'),$crypt);
            $create = ['name'=>$req->input('name'),'realname'=>$req->input('realname'),'phone'=>$req->input('phone'),'email'=>$req->input('email'),'password'=>$pwd,'crypt'=>$crypt];
            $admin = Admin::create($create);
            $rids = $req->input('role_ids',[]);
            if (is_array($rids)) {
                $rdata = [];
                foreach ($rids as $k) {
                    $rdata[] = ['role_id' => $k, 'admin_id' => $admin->id];
                }
                RoleAdmin::insert($rdata);
            }
            $department_ids = $req->input('department_ids', []);
            if (is_array($department_ids)) {
                $rdata = [];
                foreach ($department_ids as $k) {
                    $rdata[] = ['department_id' => $k, 'admin_id' => $admin->id];
                }
                DepartmentAdmin::insert($rdata);
            }
            DB::commit();
            return $this->resData(200,'创建用户成功...');
        } catch (\Throwable $e) {
            DB::rollback();
            return $this->resData(500,'创建用户失败，请稍后再试...');
        }
    }
    // 修改资料
    public function postEditInfo(Request $req)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($req->input(), [
                'admin_id' => 'required|integer',
                'realname' => 'required|max:255',
                'phone' => 'nullable|regex:/^1[3456789]\d{9}$/',
                'email' => 'nullable|email',
            ]);
            $attrs = array(
                'admin_id' => '用户ID',
                'realname' => '姓名',
                'phone' => '手机号',
                'email' => '邮箱',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $id = $req->input('admin_id');
            $data = ['realname'=>$req->input('realname'),'phone'=>$req->input('phone'),'email'=>$req->input('email')];
            Admin::where('id',$id)->update($data);
            $rids = $req->input('role_ids',[]);
            // 先删除再添加
            RoleAdmin::where('admin_id',$id)->delete();
            if(is_array($rids)){
                $rdata = [];
                foreach ($rids as $k) {
                    $rdata[] = ['role_id'=>$k,'admin_id'=>$id];
                }
                RoleAdmin::insert($rdata);
            }
            // 先删除再添加
            DepartmentAdmin::where('admin_id', $id)->delete();
            $department_ids = $req->input('department_ids', []);
            if (is_array($department_ids)) {
                $rdata = [];
                foreach ($department_ids as $k) {
                    $rdata[] = ['department_id' => $k, 'admin_id' => $id];
                }
                DepartmentAdmin::insert($rdata);
            }
            DB::commit();
            return $this->resData(200,'更新用户资料成功...');
        } catch (\Throwable $e) {
            DB::rollback();
            return $this->resData(500,'更新用户资料失败，请稍后再试...');
        }
    }
    // 个人修改资料
    public function postSelfEditInfo(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'admin_id' => 'required|integer',
                'realname' => 'required|max:255',
                'phone' => 'nullable|regex:/^1[3456789]\d{9}$/',
                'email' => 'nullable|email',
            ]);
            $attrs = array(
                'admin_id' => '用户ID',
                'realname' => '姓名',
                'phone' => '手机号',
                'email' => '邮箱',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $id = $req->input('admin_id');
            $data = ['realname'=>$req->input('realname'),'phone'=>$req->input('phone'),'email'=>$req->input('email')];
            Admin::where('id',$id)->update($data);
            return $this->resData(200,'更新用户资料成功...');
        } catch (\Throwable $e) {
            return $this->resData(500,'更新用户资料失败，请稍后再试...');
        }
    }
    // 修改密码
    public function postEditPassword(Request $req)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($req->input(), [
                'admin_id' => 'required|integer',
                'password' => 'confirmed|min:6|max:15|alpha_dash',
            ]);
            $attrs = array(
                'admin_id' => '用户ID',
                'password' => '密码',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $id = $req->input('admin_id');
            $crypt = Func::str_random(10);
            $pwd = Func::makepwd($req->input('password'),$crypt);
            $data = ['password'=>$pwd,'crypt'=>$crypt];
            Admin::where('id',$id)->update($data);
            DB::commit();
            return $this->resData(200,'更新用户密码成功...');
        } catch (\Throwable $e) {
            DB::rollback();
            return $this->resData(500,'更新用户密码失败，请稍后再试...');
        }
    }
    // 个人修改密码
    public function postSelfEditPassword(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'admin_id' => 'required|integer',
                'password' => 'confirmed|min:6|max:15|alpha_dash',
            ]);
            $attrs = array(
                'admin_id' => '用户ID',
                'password' => '密码',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $id = $req->input('admin_id');
            $crypt = Func::str_random(10);
            $pwd = Func::makepwd($req->input('password'),$crypt);
            $data = ['password'=>$pwd,'crypt'=>$crypt];
            Admin::where('id',$id)->update($data);
            return $this->resData(200,'更新用户密码成功...');
        } catch (\Throwable $e) {
            return $this->resData(500, '更新用户密码失败，请稍后再试...');
        }
    }
    // 修改状态
    public function postStatus(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'admin_id' => 'required|integer',
                'status' => 'required|in:true,false',
            ]);
            $attrs = array(
                'admin_id' => '用户ID',
                'status' => '状态',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $status = $req->input('status') == 'true' ? 1 : 0;
            Admin::where('id',$req->input('admin_id'))->update(['status'=>$status]);
            return $this->resData(200,'更新用户状态成功...');
        } catch (\Throwable $e) {
            return $this->resData(500,'更新用户状态失败，请稍后再试...');
        }
    }
    // 删除用户
    public function postRemove(Request $req)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($req->input(), [
                'admin_id' => 'required|array',
            ]);
            $attrs = array(
                'admin_id' => '用户ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $id = $req->input('admin_id');
            Admin::whereIn('id',$id)->delete();
            RoleAdmin::where('admin_id',$id)->delete();
            DB::commit();
            return $this->resData(200,'删除用户成功...');
        } catch (\Throwable $e) {
            DB::rollback();
            return $this->resData(500,'删除用户失败，请稍后再试...');
        }
    }
}
