<?php

namespace App\Http\Controllers\Admin\Wx;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Wx\ReplyRequest;
use App\Models\Common\Article;
use App\Models\Wx\Reply;
use App\Models\Wx\WxMater;
use Illuminate\Http\Request;

class ReplyController extends BaseController
{
    // 回复管理
    public function getIndex(Request $req)
    {
    	$title = '回复管理';
    	$type = $req->input('type','keyword');
    	$list = Reply::where('msgtype',$type)->orderBy('id','desc')->paginate(15);
    	// 记录上次请求的url path，返回时用
        session()->put('backurl',$req->fullUrl());
    	return view('admin.wxreply.index',compact('title','list','type'));
    }
    // 添加回复
    public function getAdd()
    {
    	$title = '添加回复';
    	return view('admin.wxreply.add',compact('title'));
    }
    public function postAdd(ReplyRequest $req)
	{
		try {
	    	$data = $req->input('data');
	    	$data['keyword'] = app('com')->getKeyword($data['keyword']);
	    	// 如果上传了文件，处理微信的上传
	    	if(!is_null($data['files']))
	    	{
	    		$wxRes = $this->wxupload($data['files'],$data['replytype'],$data['title']);
	    		$data['media_id'] = $wxRes->media_id;
	    		$data['mid'] = $wxRes->mid;
	    	}
	    	$data['media_id'] = is_null($data['media_id']) ? '' : $data['media_id'];
	    	$data['files'] = is_null($data['files']) ? '' : $data['files'];
	    	$data['mid'] = is_null($data['mid']) ? 0 : $data['mid'];
	    	$data['aids'] = implode(',', $req->input('art_id',[]));
	    	Reply::create($data);
	    	// 更新微信服务器
	        return $this->ajaxReturn(1,'添加成功',url('/console/reply/index').'?type='.$data['msgtype']);
		} catch (\Exception $e) {
	        return $this->ajaxReturn(0,$e->getLine().' - '.$e->getMessage());
		}
	}
	// 修改回复
    public function getEdit(Request $req,$id = '')
    {
    	$title = '修改回复';
    	$info = Reply::with('mater')->findOrFail($id);
    	// 找出文章列表
    	$arts = Article::whereIn('id',explode(',',$info->aids))->select('id','title')->orderBy('sort','desc')->orderBy('id','desc')->get();
    	$ref = session('backurl');
    	return view('admin.wxreply.edit',compact('title','info','ref','arts'));
    }
    public function postEdit(ReplyRequest $req,$id = '')
	{
		try {
	    	$data = $req->input('data');
	    	$data['keyword'] = app('com')->getKeyword($data['keyword']);
	    	$old_files = Reply::where('id',$id)->value('files');
	    	// 如果上传了文件,且跟以前的不同，处理微信的上传
	    	if(!is_null($data['files']) && $old_files != $data['files'])
	    	{
	    		$wxRes = $this->wxupload($data['files'],$data['replytype'],$data['title']);
	    		$data['media_id'] = $wxRes->media_id;
	    		$data['mid'] = $wxRes->mid;
	    	}
	    	$data['media_id'] = is_null($data['media_id']) ? '' : $data['media_id'];
	    	$data['files'] = is_null($data['files']) ? '' : $data['files'];
	    	$data['mid'] = is_null($data['mid']) ? 0 : $data['mid'];
	    	$data['aids'] = implode(',', $req->input('art_id',[]));
	    	Reply::where('id',$id)->update($data);
	    	// 更新微信服务器
	        return $this->ajaxReturn(1,'修改成功',$req->ref);
		} catch (\Exception $e) {
	        return $this->ajaxReturn(0,$e->getLine().' - '.$e->getMessage());
		}
	}
	// 微信的上传
	private function wxupload($file,$type,$title = '')
	{
		$material = app('wechat')->material;
		switch ($type) {
			// 缩略图
			case 'thumb':
				$wxRes = $material->uploadThumb(public_path().$file);
				break;

			// 视频
			case 'video':
				$wxRes = $material->uploadVideo(public_path().$file,$title,$describe);
				break;

			// 声音
			case 'voice':
				$wxRes = $material->uploadVoice(public_path().$file);
				break;
			
			// 图片
			default:
		    	$wxRes = $material->uploadImage(public_path().$file);
				break;
		}
		$wxRes->localpath = $file;
		$data = ['name'=>$title,'media_id'=>$wxRes->media_id,'type'=>$type,'content'=>json_encode($wxRes)];
		$mater = WxMater::create($data);
		$wxRes->mid = $mater->id;
		return $wxRes;
	}
}
