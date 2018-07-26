<?php
/*
 * @package [App\Http\Controllers\Admin]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 管理员管理
 *
 */
namespace App\Http\Controllers\Admin;

use App\Customize\Func;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Console\Admin;
use App\Models\Console\Role;
use App\Models\Console\RoleUser;
use App\Models\Console\Section;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getIndex(Request $req)
    {
        try {
        	$title = '用户列表';
            $key = isset($req->q) ? $req->q : 0;
            $list = Admin::with(['section','role'])->where(function($q) use($key){
                        if($key)
                        {
                            $q->where('name','like','%'.$key.'%')->orWhere('realname','like','%'.$key.'%');
                        }
                    })->paginate(10);
            return view('admin.console.admins.index',compact('list','title','key'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    // 添加用户
    public function getAdd()
    {
        try {
            $title = '添加用户';
            $section = Section::where('status',1)->get();
            $rolelist = Role::where('status',1)->get();
            return view('admin.console.admins.add',compact('title','rolelist','section'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postAdd(AdminRequest $req)
    {
        // 添加，事务
        DB::beginTransaction();
        try {
            $data = $req->input('data');
            unset($data['password_confirmation']);
            $crypt = str_random(10);
            $pwd = Func::makepwd($req->input('data.password'),$crypt);
            $data['password'] = $pwd;
            $data['crypt'] = $crypt;
            $data['lastip'] = $req->ip();
            $data['lasttime'] = Carbon::now();
            $admin = Admin::create($data);
            $rids = $req->role_id;
            if (is_array($rids)) {
                $rdata = [];
                foreach ($rids as $k) {
                    $rdata[] = ['role_id'=>$k,'user_id'=>$admin->id];
                }
            }
            RoleUser::insert($rdata);
            // 没出错，提交事务
            DB::commit();
            return $this->adminJson(1,'添加用户成功！',url('/console/admin/index'));
        } catch (\Throwable $e) {
            // 出错回滚
            DB::rollBack();
            return $this->adminJson(0,'添加失败，请稍后再试！');
        }
    }
    // 修改资料
    public function getEdit($uid)
    {
        try{
            $title = '修改资料';
            $rolelist = Role::where('status',1)->get();
            $section = Section::where('status',1)->get();
            $info = Admin::with('role')->findOrFail($uid);
            $rids = '';
            foreach ($info->role as $r) {
                $rids .= "'".$r->id."',";
            }
            return view('admin.console.admins.edit',compact('title','info','rolelist','section','rids'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postEdit(AdminRequest $req,$uid)
    {
        // 添加，事务
        DB::beginTransaction();
        try {
            $data = $req->input('data');
            Admin::where('id',$uid)->update($data);
            $rids = $req->role_id;
            // 先删除再添加
            RoleUser::where('user_id',$uid)->delete();
            if (is_array($rids)) {
                $rdata = [];
                foreach ($rids as $k) {
                    $rdata[] = ['role_id'=>$k,'user_id'=>$uid];
                }
            }
            RoleUser::insert($rdata);
            // 没出错，提交事务
            DB::commit();
            return $this->adminJson(1,'修改用户成功！');
        } catch (\Throwable $e) {
            // 出错回滚
            DB::rollBack();
            return $this->adminJson(0,'修改失败，请稍后再试！');
        }
    }
    // 修改密码
    public function getPwd($uid)
    {
        try {
            $title = '修改密码';
            // 拼接返回用的url参数
            $info = Admin::findOrFail($uid);
            return view('admin.console.admins.pwd',compact('title','info'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postPwd(AdminRequest $req,$uid)
    {
        try {
            $crypt = str_random(10);
            $pwd = Func::makepwd($req->input('data.password'),$crypt);
            Admin::where('id',$uid)->update(['password'=>$pwd,'crypt'=>$crypt]);
            return $this->adminJson(1,'修改密码成功！');
        } catch (\Throwable $e) {
            return $this->adminJson(0,'修改密码失败！');
        }
    }
    // 删除用户
    public function getDel($uid)
    {
        try {
            if($uid != 1)
            {
                Admin::destroy($uid);
                RoleUser::where('user_id',$uid)->delete();
                return back()->with('message', '删除用户成功！');
            }
            else
            {
                return back()->with('message', '超级管理员不能被删除！');
            }
        } catch (\Throwable $e) {
            return back()->with('message', '删除失败！');
        }
    }

    // 个人修改资料
    public function getMyedit()
    {
        try {
            $title = '修改个人资料';
            $info = Admin::with('role')->findOrFail(session('console')->id);
            return view('admin.console.admins.myedit',compact('title','info'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postMyedit(AdminRequest $request)
    {
        try {
            $data = $request->input('datas');
            Admin::where('id',session('console')->id)->update($data);
            return $this->adminJson(1,'修改个人资料成功！');
        } catch (\Throwable $e) {
            return $this->adminJson(0,'修改个人资料失败！');
        }
    }
    // 修改密码
    public function getMypwd()
    {
        try {
            $title = '修改密码';
            $info = Admin::findOrFail(session('console')->id);
            return view('admin.console.admins.mypwd',compact('title','info'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postMypwd(AdminRequest $req)
    {
        try {
            $crypt = str_random(10);
            $pwd = Func::makepwd($req->input('data.password'),$crypt);
            $res = Admin::where('id',session('console')->id)->update(['password'=>$pwd,'crypt'=>$crypt]);
            if ($res) {
                \Session::put('console',null);
                return $this->adminJson(1,'修改密码成功，请登陆登录！',url('/console/login'));
            }
            else
            {
                return $this->adminJson(0,'修改密码失败！');
            }
        } catch (\Throwable $e) {
            return $this->adminJson(0,'修改密码失败！');
        }
    }
}
