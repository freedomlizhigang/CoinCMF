<?php

namespace App\Http\Controllers\Admin\Wx;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Wx\WxBroadcastRequest;
use App\Models\Wx\WxBroadcast;
use App\Models\Wx\WxMater;
use App\Models\Wx\WxTag;
use App\Models\Wx\WxUser;
use App\Models\Wx\WxUserTag;
use Illuminate\Http\Request;

class BroadcastController extends BaseController
{
    // 群发管理
    public function getIndex(Request $req)
    {
    	$title = '群发管理';
    	$list = WxBroadcast::orderBy('id','desc')->paginate(15);
        session()->put('backurl',$req->fullUrl());
    	return view('admin.wxbroadcast.index',compact('title','list'));
    }
    // 添加群发
    public function getAdd()
    {
    	/*$notice = app('wechat')->notice;
    	dd($notice->getPrivateTemplates());*/
    	/*// 发模板消息
    	$messageId = $notice->send([
	        'touser' => 'osxIs0mmwpMH5jHrcRFESwSEnW4k',
	        'template_id' => 'p1-MUmINJFKJrd-u49NC__jW5bSRZTj2ARZYGNQRl5I',
	        'url' => 'http://www.xi-yi.ren',
	        'data' => [
				"first"  => "恭喜你购买成功！",
				"keyword1"   => "巧克力",
				"keyword2"  => "39.8元",
				"keyword3"  => "一点也不贵啊！",
				"remark" => "欢迎再次购买！",
	        ],
	    ]);
	    dd($messageId);*/
    	// end
    	$title = '添加群发';
    	$tlist = WxTag::orderBy('id','asc')->get();
    	return view('admin.wxbroadcast.add',compact('title','tlist'));
    }
    public function postAdd(WxBroadcastRequest $req)
	{
		try {
	    	$data = $req->input('data');
	    	// 按用户标签找出来所有用户的ID
	    	if ($req->t_id) {
	    		$uids = WxUserTag::where('t_id',$req->t_id)->pluck('u_id')->unique();
	    		$openids = WxUser::whereIn('id',$uids)->pluck('openid');
	    		$targetId = $req->t_id;
	    	}
	    	else
	    	{
	    		$openids = WxUser::pluck('openid')->unique();
	    		$targetId = null;
	    	}
	    	// $openId = ['osxIs0mmwpMH5jHrcRFESwSEnW4k','osxIs0pVfbPczmnSyy1WreC6TIN4','osxIs0vj8ZeLi5KSLCQIMnpSHic4'];
	    	// 发消息
	    	$broadcast = app('wechat')->broadcast;
	    	switch ($data['type']) {
	    		case 'news':
	    			$wxRes = $broadcast->sendNews($data['media_id'], $targetId);
	    			// $wxRes = $broadcast->previewNews($data['media_id'], $openId);
	    			break;

	    		case 'voice':
	    			$wxRes = $broadcast->sendVoice($data['media_id'], $targetId);
	    			// $wxRes = $broadcast->previewVoice($data['media_id'], $openId);
	    			break;

	    		case 'video':
	    			$wxRes = $broadcast->sendVideo($data['media_id'], $targetId);
	    			// $wxRes = $broadcast->previewVideo($data['media_id'], $openId);
	    			break;

	    		case 'image':
	    			$wxRes = $broadcast->sendImage($data['media_id'], $targetId);
	    			// $wxRes = $broadcast->previewImage($data['media_id'], $openId);
	    			break;
	    		
	    		default:
	    			$wxRes = $broadcast->sendText($data['content'],$targetId);
	    			// $wxRes = $broadcast->previewText($data['content'],$openId);
	    			break;
	    	}
	    	$data['msg_id'] = $wxRes->msg_id;
	    	$data['openids'] = $openids->toJson();
	    	WxBroadcast::create($data);
	    	// 更新微信服务器
	        return $this->ajaxReturn(1,'添加成功',url('/console/mater/index').'?type='.$data['type']);
		} catch (\Exception $e) {
			// dd($e);
	        return $this->ajaxReturn(0,$e->getLine().' - '.$e->getMessage());
		}
	}
	// 查看群发状态
	public function getShow($id = '')
    {
        $title = '查看群发状态';
        // 搜索关键字
        $info = WxBroadcast::findOrFail($id);
        $broadcast = app('wechat')->broadcast;
        $wxstatus = $broadcast->status($info->msg_id);
        return $wxstatus->msg_status;
    }
    // 删除群发
	public function getDel($id = '')
    {
    	try {
	        $msgid = WxBroadcast::where('id',$id)->value('msg_id');
	        WxBroadcast::where('id',$id)->delete();
	        if (!is_null($msgid)) {
	        	$broadcast = app('wechat')->broadcast;
	        	$broadcast->delete($msgid);
	        }
	        return back()->with('message','删除成功');
    	} catch (\Exception $e) {
	        return back()->with('message','删除失败，一会再试~');
    	}
    }
	// 选择素材
	public function getSelect(Request $res)
    {
        $title = '选择素材';
        // 搜索关键字
        $key = trim($res->input('q',''));
        $type = $res->input('type');
        $list = WxMater::where(function($q) use($key){
                if ($key != '') {
                    $q->where('name','like','%'.$key.'%');
                }
            })->where('type',$type)->orderBy('id','desc')->paginate(10);
        return view('admin.wxbroadcast.select',compact('title','list','key','type'));
    }
}
