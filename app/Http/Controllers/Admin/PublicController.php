<?php
/*
 * @package [App\Http\Controllers\Admin]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 管理后台用户登录
 *
 */
namespace App\Http\Controllers\Admin;

use App\Customize\Func;
use App\Http\Controllers\Controller;
use App\Models\Console\Admin;
use App\Models\Console\Priv;
use App\Models\Console\RoleUser;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function getLogin()
    {
        try {
            if(\Session::has('console')){return redirect('/console/index/index');}
            return view('admin.login');
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    /**
     * 登录提交数据验证功能，成功后跳转到后台首页
     * @param  Request $request [description]
     */
    public function postLogin(Request $res)
    {
        try {
            if(\Session::has('console')){return redirect('/console/index/index');}
            $username = $res->input('name');
            $pwd = $res->input('password');
            $user = Admin::where('status',1)->where('name',$username)->first();
            if (is_null($user)) {
                return back()->with('message','用户不存在或已被禁用！');
            }
            else
            {
                if ($user->password != Func::makepwd($pwd,$user->crypt)) {
                    return back()->with('message','密码不正确！');
                }
                // 查出所有用户权限并存储下来
                $allRole = RoleUser::where('user_id',$user->id)->pluck('role_id')->toArray();
                $user->allRole = $allRole;
                $allPriv = Priv::whereIn('role_id',$allRole)->pluck('label');
                $user->allPriv = $allPriv->unique()->toArray();
                \Session::put('console',$user);
                return redirect('/console/index/index');
            }
        } catch (\Throwable $e) {
            return back()->with('message','登录失败！');
        }
    }
    /**
     * 自写logout，实现登出后的跳转页面控制
     */
    public function getLogout()
    {
        try {
            \Session::put('console',null);
            return redirect('/console/login');
        } catch (\Throwable $e) {
            return back()->with('message','退出登录失败！');
        }
    }
}
