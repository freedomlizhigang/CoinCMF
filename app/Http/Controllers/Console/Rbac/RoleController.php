<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2019-01-03 20:14:16
 * @Description: 角色管理
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-20 21:12:36
 * @FilePath: /CoinCMF/app/Http/Controllers/Console/Rbac/RoleController.php
 */

namespace App\Http\Controllers\Console\Rbac;

use DB;
use Validator;
use App\Models\Rbac\Menu;
use App\Models\Rbac\Priv;
use App\Models\Rbac\Role;
use Illuminate\Http\Request;
use App\Models\Rbac\RoleUser;
use App\Http\Controllers\Console\ResponseController;

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
            $page = $req->input('page', 1);
            $size = $req->input('size', 10);
            $list = Role::where(function($q) use($key){
                    if ($key != '') {
                        $q->where('name','like','%'.$key.'%');
                    }
                })->limit($size)->offset(($page - 1) * $size)->orderBy('id','asc')->get();
            $count = Role::where(function ($q) use ($key) {
                if ($key != '') {
                    $q->where('name', 'like', '%' . $key . '%');
                }
            })->count();
            return $this->resData(200,'获取角色数据成功...', ['list' => $list, 'count' => $count]);
        } catch (\Throwable $e) {
            return $this->resData(500,'获取数据失败，请稍后再试！',[]);
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
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $name = $req->input('name');
            $status = $req->input('status') == true ? 1 : 0;
            Role::create(['name'=>$name,'status'=>$status]);
            return $this->resData(200,'创建角色成功...');
        } catch (\Throwable $e) {
            return $this->resData(500,'创建角色失败，请稍后再试...');
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
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $name = $req->input('name');
            Role::where('id',$req->input('role_id'))->update(['name'=>$name]);
            return $this->resData(200,'更新角色名称成功...');
        } catch (\Throwable $e) {
            return $this->resData(500,'更新角色名称失败，请稍后再试...');
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
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $status = $req->input('status') == 'true' ? 1 : 0;
            Role::where('id',$req->input('role_id'))->update(['status'=>$status]);
            return $this->resData(200,'更新角色状态成功...');
        } catch (\Throwable $e) {
            return $this->resData(500,'更新角色状态失败，请稍后再试...');
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
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $rid = $req->input('role_id');
            if ($rid === 1) {
                return $this->resData(403,'超级管理员组不能删除...');
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
                return $this->resData(403,'此角色下有用户...');
            }
        } catch (\Throwable $e) {
            return $this->resData(500,'删除角色失败，请稍后再试...');
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
                return $this->resData(400,$validator->errors()->all()[0].'...');
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
            return $this->resData(500,'获取权限列表失败...');
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
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $rid = $req->input('role_id');
            Priv::where('role_id',$rid)->delete();
            // 所有选中的菜单url，以此查找出所有url label
            $ids = $req->input('menu_id','');
            $ids = explode(',',$ids);
            $all = Menu::whereIn('id',$ids)->get();
            // 将查出来的数据组成数组插入到role_privs表里
            if (!is_null($all) && count($all) > 0) {
                foreach ($all as $v) {
                    $insertArr[] = ['role_id' => $rid, 'menu_id' => $v->id, 'name' => $v->name, 'url' => $v->url, 'label' => $v->label, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
                }
                Priv::insert($insertArr);
            }
            DB::commit();
            return $this->resData(200,'更新权限菜单成功...');
        } catch (\Throwable $e) {
            return $this->resData(500,'更新权限菜单失败，请稍后再试...');
        }
    }
}
