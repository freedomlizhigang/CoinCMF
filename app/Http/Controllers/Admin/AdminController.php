<?php

namespace App\Http\Controllers\Admin;

use App\Customize\Func;
use App\Http\Controllers\Controller;
use App\Models\Console\Admin;
use App\Models\Console\RoleUser;
use DB;
use Illuminate\Http\Request;
use Validator;

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
            $list = Admin::where(function($q) use($key){
                    if ($key != '') {
                        $q->where('name','like','%'.$key.'%');
                    }
                })->orderBy('id','asc')->get();
            return $this->resData(200,'获取用户数据成功...',$list);
        } catch (\Throwable $e) {
            return $this->anyErrors(400,'获取数据失败，请稍后再试！',[]);
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
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            $admin = Admin::findOrFail($req->input('admin_id'));
            $admin->section_id = $admin->section->id;
            $admin->role_ids = $admin->role->pluck('id');
            return $this->resData(200,'查询成功...',$admin);
        } catch (\Throwable $e) {
            return $this->resData(400,'查询失败，请稍后再试...');
        }
    }
    // 创建用户
    public function postCreate(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'section_id' => 'required|integer',
                'name' => 'required|max:255',
                'realname' => 'required|max:255',
                'phone' => 'nullable|regex:/^1[3456789]\d{9}$/',
                'email' => 'nullable|email',
                'password' => 'confirmed|min:6|max:15|alpha_dash',
            ]);
             $attrs = array(
                'section_id' => '部门',
                'name' => '名称',
                'realname' => '姓名',
                'phone' => '手机号',
                'email' => '邮箱',
                'password' => '密码',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            $crypt = str_random(10);
            $pwd = Func::makepwd($req->input('password'),$crypt);
            $create = ['section_id'=>$req->input('section_id'),'name'=>$req->input('name'),'realname'=>$req->input('realname'),'phone'=>$req->input('phone'),'email'=>$req->input('email'),'password'=>$pwd,'crypt'=>$crypt];
            $admin = Admin::create($create);
            $rids = $req->input('role_ids');
            if (is_array($rids)) {
                $rdata = [];
                foreach ($rids as $k) {
                    $rdata[] = ['role_id'=>$k,'user_id'=>$admin->id];
                }
            }
            RoleUser::insert($rdata);
            return $this->resData(200,'创建用户成功...');
        } catch (\Throwable $e) {
            return $this->resData(400,'创建用户失败，请稍后再试...');
        }
    }
    // 修改名称
    public function postEditInfo(Request $req)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($req->input(), [
                'admin_id' => 'required|integer',
                'section_id' => 'required|integer',
                'realname' => 'required|max:255',
                'phone' => 'nullable|regex:/^1[3456789]\d{9}$/',
                'email' => 'nullable|email',
            ]);
             $attrs = array(
                'admin_id' => '用户ID',
                'section_id' => '部门',
                'realname' => '姓名',
                'phone' => '手机号',
                'email' => '邮箱',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            $id = $req->input('admin_id');
            $data = ['section_id'=>$req->input('section_id'),'realname'=>$req->input('realname'),'phone'=>$req->input('phone'),'email'=>$req->input('email')];
            Admin::where('id',$id)->update($data);
            $rids = $req->input('role_ids');
            // 先删除再添加
            RoleUser::where('user_id',$id)->delete();
            if (is_array($rids)) {
                $rdata = [];
                foreach ($rids as $k) {
                    $rdata[] = ['role_id'=>$k,'user_id'=>$id];
                }
                RoleUser::insert($rdata);
            }
            DB::commit();
            return $this->resData(200,'更新用户名称成功...');
        } catch (\Throwable $e) {
            DB::rollback();
            return $this->resData(400,'更新用户名称失败，请稍后再试...');
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
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            $id = $req->input('admin_id');
            $crypt = str_random(10);
            $pwd = Func::makepwd($req->input('password'),$crypt);
            $data = ['password'=>$pwd,'crypt'=>$crypt];
            Admin::where('id',$id)->update($data);
            DB::commit();
            return $this->resData(200,'更新用户密码成功...');
        } catch (\Throwable $e) {
            DB::rollback();
            return $this->resData(400,'更新用户密码失败，请稍后再试...');
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
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            $status = $req->input('status') == 'true' ? 1 : 0;
            Admin::where('id',$req->input('admin_id'))->update(['status'=>$status]);
            return $this->resData(200,'更新用户状态成功...');
        } catch (\Throwable $e) {
            return $this->resData(400,'更新用户状态失败，请稍后再试...');
        }
    }
    // 删除用户
    public function postRemove(Request $req)
    {
        DB::beginTransaction();
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
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            $id = $req->input('admin_id');
            Admin::destroy($id);
            RoleUser::where('user_id',$id)->delete();
            DB::commit();
            return $this->resData(200,'删除用户成功...');
        } catch (\Throwable $e) {
            DB::rollback();
            return $this->resData(400,'删除用户失败，请稍后再试...');
        }
    }
}
