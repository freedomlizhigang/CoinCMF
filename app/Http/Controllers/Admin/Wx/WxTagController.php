<?php

namespace App\Http\Controllers\Admin\Wx;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Wx\WxTagRequest;
use App\Models\Wx\WxTag;
use App\Models\Wx\WxUserTag;
use DB;
use Illuminate\Http\Request;

class WxTagController extends BaseController
{
    // 标签组
    public function getIndex(Request $req)
    {
    	$title = '标签组';
    	$list = WxTag::orderBy('id','desc')->get();
    	return view('admin.wxtag.index',compact('title','list'));
    }
    // 初次同步标签组
    public function getSync()
    {
    	DB::beginTransaction();
    	try {
			// 先清除数据库
			WxTag::truncate();
			$group = app('wechat')->user_tag;
			$list = $group->lists()->tags;
			$insert = [];
			$times = date('Y-m-d H:i:s');
			foreach ($list as $v) {
				$insert[] = ['id'=>$v['id'],'name'=>$v['name'],'created_at'=>$times,'updated_at'=>$times];
			}
			WxTag::insert($insert);
    		DB::commit();
    		return back()->with('message','同步成功！');
    	} catch (\Exception $e) {
    		DB::rollback();
    		return back()->with('message','同步失败，请稍后再试~');
    	}
    }
    // 添加标签组
    public function getAdd()
    {
        $title = '添加标签组';
        return view('admin.wxtag.add',compact('title'));
    }

    public function postAdd(WxTagRequest $request)
    {
    	try {
	        $data = $request->input('data');
	        $group = app('wechat')->user_tag;
	        $group->create($data['name']);
	        WxTag::create($data);
	        return $this->ajaxReturn(1,'添加标签组成功！',url('/console/wxtag/index'));
    	} catch (\Exception $e) {
    		return $this->ajaxReturn(0,'添加失败，请稍后再试！');
    	}
    }
    // 修改标签组
    public function getEdit($id)
    {
        $title = '修改标签组';
        $info = WxTag::findOrFail($id);
        return view('admin.wxtag.edit',compact('title','info'));
    }
    public function postEdit(WxTagRequest $request,$id)
    {
    	try {
	    	$data = $request->input('data');
	        $group = app('wechat')->user_tag;
	        $group->update($id,$data['name']);
	        WxTag::where('id',$id)->update($data);
	        return $this->ajaxReturn(1,'修改标签组成功！');
    	} catch (\Exception $e) {
	        return $this->ajaxReturn(0,'修改失败，请确认不是系统默认设置后再试！');
    	}
    }
    // 删除标签组
    public function getDel($id)
    {
        // 开启事务
        DB::beginTransaction();
        try {
            // 同时删除关联的标签关系
            WxTag::where('id',$id)->delete();
            $group = app('wechat')->user_tag;
            $group->delete($id);
            // 对应的标签重置为未分组
            WxUserTag::where('t_id',$id)->delete();
            // 没出错，提交事务
            DB::commit();
            return back()->with('message', '删除标签组成功！');
        } catch (\Exception $e) {
            // 出错回滚
            DB::rollBack();
            return back()->with('message','删除失败，请确认不是系统默认设置后再试！');
        }
    }
}
