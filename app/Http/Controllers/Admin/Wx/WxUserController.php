<?php

namespace App\Http\Controllers\Admin\Wx;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Wx\WxTag;
use App\Models\Wx\WxUser;
use App\Models\Wx\WxUserTag;
use DB;
use Illuminate\Http\Request;

class WxUserController extends BaseController
{
    // 用户
    public function getIndex(Request $req)
    {
    	$title = '用户管理';
        $key = $req->input('q','');
        $gid = $req->input('gid','');
        $tlist = WxTag::orderBy('id','asc')->get();
        $ids = [];
        if ($gid != '') {
            $ids = WxUserTag::where('t_id',$gid)->pluck('u_id')->toArray();
        }
    	$list = WxUser::with(['tag'])->where(function($q) use($ids){
                    if (count($ids) != 0) {
                        $q->whereIn('id',$ids);
                    }
                })->where(function($q) use($key){
                    if ($key != '') {
                        $q->where('nickname','like','%'.$key.'%');
                    }
                })->orderBy('id','desc')->paginate(15);
    	return view('admin.wxuser.index',compact('title','list','tlist','gid','key'));
    }
    // 初次同步用户
    public function getSync()
    {
    	DB::beginTransaction();
    	try {
            $user = app('wechat')->user;
            // 每次最大10000条
            $users = [];
            $next_openid = null;
            $i = 0;
            do {
                $res = $user->lists($next_openid);
                $next_openid = $res->next_openid;
                $openids = $res->data['openid'];
                $tmp_user = $user->batchGet($openids)->user_info_list;
                if (count($users) != 0) {
                    $users = array_merge($users,$tmp_user);
                }
                else
                {
                    $users = $tmp_user;
                }
                if ($res->count < 10000) {
                    $i = 1;
                }
            } while ($i < 1);
			// 先清除数据库
			WxUser::truncate();
			WxUserTag::truncate();
            foreach ($users as $v) {
                $insert = ['groupid'=>$v['groupid'],'subscribe'=>$v['subscribe'],'openid'=>$v['openid'],'nickname'=>$v['nickname'],'sex'=>$v['sex'],'language'=>$v['language'],'city'=>$v['city'],'province'=>$v['province'],'country'=>$v['country'],'headimgurl'=>$v['headimgurl'],'subscribe_time'=>$v['subscribe_time'],'remark'=>$v['remark']];
                $tids = $v['tagid_list'];
                $wxu = WxUser::create($insert);
                $user_tag = [];
                foreach ($tids as $k) {
                    $user_tag[] = ['t_id'=>$k,'u_id'=>$wxu->id];
                }
                WxUserTag::insert($user_tag);
			}
			// 查出来新的
    		DB::commit();
    		return back()->with('message','同步成功！');
    	} catch (\Exception $e) {
    		DB::rollback();
    		return back()->with('message','同步失败，请稍后再试~');
    	}
    }
    // 批量打标签
    public function getTags()
    {
    	$list = WxTag::orderBy('id','asc')->get();
    	return view('admin.wxuser.tags',compact('list'));
    }
    // 批量打标签
    public function postTags(Request $req)
    {
    	$gid = explode(',', trim($req->gid,','));
    	$openids = $req->sids;
    	if (count($openids) == 0 || count($gid) == 0) {
    		return back()->with('message','请先选择要操作的内容！');
    	}
    	DB::beginTransaction();
    	// 修改
    	try {
    		$tag = app('wechat')->user_tag;
    		$users = WxUser::whereIn('openid',$openids)->get();
    		foreach ($users as $k => $v) {
                // 查一下这个用户的g_id，如果是0或者黑名单，更新成第一个
    			// 为每一个用户打上标签
    			$tmp = [];
    			foreach ($gid as $g) {
    				$tmp[$g] = ['u_id'=>$v->id,'t_id'=>$g];
    			}
    			// 去除已经有的标签
    			$hasTid = WxUserTag::where('u_id',$v->id)->pluck('t_id');
    			foreach ($hasTid as $k) {
    				if (isset($tmp[$k])) {
    					unset($tmp[$k]);
    				}
    			}
    			WxUserTag::insert($tmp);
    		}
    		// 微信端同步
			foreach ($gid as $g) {
				$tag->batchTagUsers($openids,$g);
			}
			DB::commit();
    		return back()->with('message','打标签成功！');
    	} catch (\Exception $e) {
    		// dd($e);
    		DB::rollback();
    		return back()->with('message','打标签失败，请稍后再试！');
    	}
    }
    // 拉黑，取消拉黑
    public function postBlock(Request $req)
    {
    	$gid = $req->input('gid','');
    	$openids = $req->sids;
    	if (count($openids) == 0 || $gid == '') {
    		return back()->with('message','请先选择要操作的内容！');
    	}
    	// 修改
    	try {
    		$user = app('wechat')->user;
    		if ($gid == 1) {
    			$user->batchBlock($openids);
            }
            if ($gid == 0) {
                $user->batchUnblock($openids);
    		}
    		return back()->with('message','操作成功！');
    	} catch (\Exception $e) {
    		return back()->with('message','操作失败，请稍后再试！');
    	}
    }
}
