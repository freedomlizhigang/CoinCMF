<?php
/*
 * @package [App\Http\Controllers\Admin\User]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 用户组
 *
 */
namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\GroupRequest;
use App\Models\User\Group;
use Cache;
use DB;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function getIndex(Request $res)
    {
    	$title = '用户组列表';
        $list = Group::where('status',1)->orderBy('id','asc')->paginate(10);
        return view('admin.console.group.index',compact('list','title'));
    }

    // 添加用户组
    public function getAdd()
    {
        $title = '添加用户组';
        return view('admin.console.group.add',compact('title'));
    }

    public function postAdd(GroupRequest $request)
    {
        $data = $request->input('data');
        Group::create($data);
        $this->groupCache();
        return $this->adminJson(1,'添加用户组成功！',url('/console/group/index'));
    }
    // 修改用户组
    public function getEdit($id)
    {
        $title = '修改用户组';
        // 拼接返回用的url参数
        $info = Group::findOrFail($id);
        return view('admin.console.group.edit',compact('title','info'));
    }
    public function postEdit(GroupRequest $request,$id)
    {
        Group::where('id',$id)->update($request->input('data'));
        $this->groupCache();
        return $this->adminJson(1,'修改用户组成功！');
    }
    // 删除用户组
    public function getDel($id)
    {
        // 查询下属用户
        if(is_null(User::where('gid',$id)->first()))
        {
            // 开启事务
            DB::beginTransaction();
            try {
                // 同时删除关联的用户关系
                Group::where('id',$id)->update(['status'=>0]);
                // 没出错，提交事务
                DB::commit();
                $this->groupCache();
                return back()->with('message', '删除用户组成功！');
            } catch (\Throwable $e) {
                // 出错回滚
                DB::rollBack();
                return back()->with('message','删除失败，请稍后再试！');
            }
        }
        else
        {
            return back()->with('message', '用户组下有用户！');
        }
    }
    // 缓存会员组信息
    public function groupCache()
    {
        $data = Group::where('status',1)->select('id','name','points','discount')->get()->keyBy('id')->toArray();
        // 更新缓存
        Cache::forever('group',$data);
    }
}
