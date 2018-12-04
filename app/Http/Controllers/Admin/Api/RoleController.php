<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Console\Menu;
use App\Models\Console\Priv;
use App\Models\Console\Role;
use App\Models\Console\RoleUser;
use DB;
use Illuminate\Http\Request;
use Validator;

class RoleController extends ResponseController
{
    /**
     * 角色列表
     * @return [type] [description]
     */
    public function getList(Request $req)
    {
        try {
            // 搜索关键字
            $key = $req->input('key','');
            $list = Role::where(function($q) use($key){
                    if ($key != '') {
                        $q->where('name','like','%'.$key.'%');
                    }
                })->orderBy('id','asc')->get();
            return $this->resData(200,'获取角色数据成功...',$list);
        } catch (\Throwable $e) {
            return $this->anyErrors(400,'获取数据失败，请稍后再试！',[]);
        }
    }
    // 创建角色
    public function postCreate(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'name' => 'required|max:255',
                'status' => 'required|in:true,false',
            ]);
             $attrs = array(
                'name' => '名称',
                'status' => '状态',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            $name = $req->input('name');
            $status = $req->input('status') == true ? 1 : 0;
            Role::create(['name'=>$name,'status'=>$status]);
            return $this->resData(200,'创建角色成功...');
        } catch (\Throwable $e) {
            return $this->resData(400,'创建角色失败，请稍后再试...');
        }
    }
    // 修改名称
    public function postEdit(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'role_id' => 'required|integer',
                'name' => 'required|max:255',
            ]);
             $attrs = array(
                'role_id' => '角色ID',
                'name' => '名称',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            $name = $req->input('name');
            Role::where('id',$req->input('role_id'))->update(['name'=>$name]);
            return $this->resData(200,'更新角色名称成功...');
        } catch (\Throwable $e) {
            return $this->resData(400,'更新角色名称失败，请稍后再试...');
        }
    }
    // 修改状态
    public function postStatus(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'role_id' => 'required|integer',
                'status' => 'required|in:true,false',
            ]);
             $attrs = array(
                'role_id' => '角色ID',
                'status' => '状态',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            $status = $req->input('status') == 'true' ? 1 : 0;
            Role::where('id',$req->input('role_id'))->update(['status'=>$status]);
            return $this->resData(200,'更新角色状态成功...');
        } catch (\Throwable $e) {
            return $this->resData(400,'更新角色状态失败，请稍后再试...');
        }
    }
    // 删除角色
    public function postRemove(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'role_id' => 'required|integer',
            ]);
             $attrs = array(
                'role_id' => '角色ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            $rid = $req->input('role_id');
            if ($rid === 1) {
                return $this->resData(402,'超级管理员组不能删除...');
            }
            // 查询下属用户
            if(is_null(RoleUser::where('role_id',$rid)->first()))
            {
                // 开启事务
                DB::beginTransaction();
                try {
                    // 同时删除关联的用户关系
                    Role::destroy($rid);
                    Priv::where('role_id',$rid)->delete();
                    // 没出错，提交事务
                    DB::commit();
                    return $this->resData(200,'删除角色成功...');
                } catch (\Throwable $e) {
                    // 出错回滚
                    DB::rollBack();
                    return back()->with('message','删除失败，请稍后再试！');
                }
            }
            else
            {
                return $this->resData(402,'此角色下有用户...');
            }
        } catch (\Throwable $e) {
            return $this->resData(400,'删除角色失败，请稍后再试...');
        }
    }
    // 更新角色权限，主要是为了显示后台菜单
    public function getPriv(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'role_id' => 'required|integer',
            ]);
             $attrs = array(
                'role_id' => '角色ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            $rid = $req->input('role_id');
            // 所有权限
            $priv = Priv::where('role_id',$rid)->select('id','menu_id')->get();
            // 所有菜单
            $all = Menu::select('id','parentid','name','url')->orderBy('sort','asc')->orderBy('id','asc')->get();
            // 变成树形菜单用的
            $tree = $this->toTree($priv,$all,0);
            return $this->resData(200,'获取权限列表成功...',$tree);
        } catch (\Throwable $e) {
            return $this->resData(400,'获取权限列表失败...');
        }
    }
    // 转成树形菜单数组
    private function toTree($priv,$data,$pid)
    {
        $tree = [];
        if ($data->count() > 0) {
            foreach($data as $v)
            {
                if ($v->parentid == $pid) {
                    $v = ['menu_id'=>$v->id,'title'=>$v->name,'expand'=>false];
                    // 所有子菜单都选中的时候，此菜单选中checked，部分选中时selected
                    $child_count = $data->where('parentid',$v['menu_id'])->count();
                    // 没有子菜单的时候，判断他本身
                    if ($child_count == 0) {
                        $v['checked'] = $priv->where('menu_id',$v['menu_id'])->count() > 0 ? true : false;
                    }
                    $v['children'] = $this->toTree($priv,$data,$v['menu_id']);
                    $tree[] = $v;
                }
            }
        }
        return $tree;
    }
    public function postPriv(Request $req)
    {
        // 开启事务
        DB::beginTransaction();
        try {
            $validator = Validator::make($req->input(), [
                'role_id' => 'required|integer',
            ]);
             $attrs = array(
                'role_id' => '角色ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            $rid = $req->input('role_id');
            Priv::where('role_id',$rid)->delete();
            // 所有选中的菜单url，以此查找出所有url label
            $ids = $req->input('menu_id',[]);
            $all = Menu::whereIn('id',$ids)->get();
            // 将查出来的数据组成数组插入到role_privs表里
            if (!is_null($all) && count($all) > 0) {
                foreach ($all as $v) {
                    $insertArr = array('menu_id'=>$v->id,'role_id'=>$rid,'url'=>$v->url,'label'=>$v->label);
                    Priv::create($insertArr);
                }
            }
            DB::commit();
            return $this->resData(200,'更新权限菜单成功...');
        } catch (\Throwable $e) {
            return $this->resData(400,'更新权限菜单失败，请稍后再试...');
        }
    }
}
