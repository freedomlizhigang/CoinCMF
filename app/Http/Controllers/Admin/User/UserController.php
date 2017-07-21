<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Address;
use App\Models\Consume;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function getIndex(Request $res)
    {
    	$title = '会员列表';
    	$q = trim($res->input('q',''));
        $list = User::where(function($r)use($q){
        	if ($q != '') {
        		$r->where('username',$q)->orWhere('email',$q)->orWhere('phone',$q)->orWhere('nickname',$q);
        	}
        })->orderBy('id','desc')->paginate(15);
        return view('admin.member.index',compact('list','title'));
    }
   

    // 审核会员
    public function getStatus($id,$status)
    {
        User::where('id',$id)->update(['status'=>$status]);
        return back()->with('message', '修改会员状态成功！');
    }
    // 修改会员
    public function getEdit($id)
    {
        $title = '修改会员';
        $info = User::findOrFail($id);
        return view('admin.member.edit',compact('title','info'));
    }
    public function postEdit(Request $req,$id)
    {
        $pwd = $req->input('data.password');
        $rpwd = $req->input('data.repassword');
        if(strlen($pwd) < 6)
        {
            return $this->ajaxReturn(0,'密码长度小于6位');
        }
        if ($pwd == $rpwd) {
            User::where('id',$id)->update(['password'=>encrypt($rpwd)]);
            return $this->ajaxReturn(1,'改密码成功！');
        }
        else
        {
            return $this->ajaxReturn(0,'两次密码不相同，请重新输入');
        }
    }
}
