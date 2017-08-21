<?php

namespace App\Http\Controllers\Admin\Wx;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Wx\WxArtRequest;
use App\Http\Requests\Wx\WxMaterRequest;
use App\Models\Wx\WxArt;
use App\Models\Wx\WxMater;
use EasyWeChat\Message\Article;
use Illuminate\Http\Request;
use DB;

class ArtController extends BaseController
{
    // 素材管理
    public function getIndex(Request $req)
    {
    	$title = '素材管理';
    	$type = 'news';
    	$list = WxMater::where('type',$type)->orderBy('id','desc')->paginate(15);
    	// 记录上次请求的url path，返回时用
        session()->put('backurl',$req->fullUrl());
    	return view('admin.wxart.index',compact('title','list'));
    }
    // 图文列表
    public function getArtlist(Request $req,$mid = '')
    {
    	$title = WxMater::where('id',$mid)->value('name');
    	$list = WxArt::where('mid',$mid)->orderBy('sort','asc')->paginate(15);
    	// 记录上次请求的url path，返回时用
        session()->put('backurl',$req->fullUrl());
    	return view('admin.wxart.list',compact('title','list','mid'));
    }
    // 添加素材文章
    public function getAddart($mid = '')
    {
    	$title = '添加素材文章';
    	$ref = session('backurl');
    	return view('admin.wxart.addart',compact('title','mid','ref'));
    }
    public function postAddart(WxArtRequest $req,$mid)
	{
		try {
	    	$data = $req->input('data');
	    	$data['sort'] = WxArt::where('mid',$mid)->count();
	    	// 取得此素材的mediaid
			$media_id = WxMater::where('id',$mid)->value('media_id');
			$material = app('wechat')->material;
			// 如果是新的，传一个缩略图上去
			$thumbRes = $material->uploadThumb(public_path().$data['thumb']);
			$thumbMediaId = $thumbRes->media_id;
			$new_arts = new Article([
					'title'=>$data['title'],
					'thumb_media_id'=>$thumbMediaId,
					'author'=>$data['author'],
					'digest'=>$data['digest'],
					'show_cover_pic'=>$data['show_cover_pic'],
					'content'=>$data['content'],
					'content_source_url'=>$data['content_source_url'],
				]);
			// 旧的数据
			$list = WxArt::where('mid',$mid)->orderBy('sort','asc')->get();
			// 把对应的老素材删除
			$material->delete($media_id);
			// 创建新的并更新
			$arts = [];
			foreach ($list as $k => $v) {
				$arts[] = new Article([
					'title'=>$v->title,
					'thumb_media_id'=>$v->media_id,
					'author'=>$v->author,
					'digest'=>$v->digest,
					'show_cover_pic'=>$v->show_cover_pic,
					'content'=>$v->content,
					'content_source_url'=>$v->content_source_url,
				]);
			}
			$arts[] = $new_arts;
			$wxRes = $material->uploadArticle($arts);
			WxMater::where('id',$mid)->update(['media_id'=>$wxRes->media_id]);
	    	$data['media_id'] = $thumbMediaId;
	    	WxArt::create($data);
	    	// 更新微信服务器
	        return $this->ajaxReturn(1,'添加成功',$req->ref);
		} catch (\Exception $e) {
	        return $this->ajaxReturn(0,$e->getLine().' - '.$e->getMessage());
		}
	}
	// 修改素材文章
	public function getEditart($id = '')
    {
    	$title = '添加素材文章';
    	$info = WxArt::where('id',$id)->first();
    	$ref = session('backurl');
    	return view('admin.wxart.editart',compact('title','mid','ref','info'));
    }
    public function postEditart(WxArtRequest $req,$id)
	{
		try {
	    	$data = $req->input('data');
	    	$mid = $data['mid'];
	    	$thumb = WxArt::where('id',$id)->value('thumb');
    		$isnew = $thumb == $data['thumb'] ? 0 : 1;
	    	// 微信的上传
	    	$wxRes = $this->art_edit($data,$mid,$isnew);
	    	$data['media_id'] = $wxRes->media_id;
	    	WxArt::where('id',$id)->update($data);
	    	// 更新微信服务器
	        return $this->ajaxReturn(1,'修改成功',$req->ref);
		} catch (\Exception $e) {
	        return $this->ajaxReturn(0,$e->getLine().' - '.$e->getMessage());
		}
	}
	
	// 微信的文章修改
	private function art_edit($data,$mid,$isnew = 1)
	{
		// 取得此素材的mediaid
		$media_id = WxMater::where('id',$mid)->value('media_id');
		$material = app('wechat')->material;
		// 如果是新的，传一个缩略图上去
		if ($isnew) {
			$thumbRes = $material->uploadThumb(public_path().$data['thumb']);
			$thumbMediaId = $thumbRes->media_id;
		}
		else
		{
			$thumbMediaId = $data['media_id'];
		}
		$arts = new Article([
				'title'=>$data['title'],
				'thumb_media_id'=>$thumbMediaId,
				'author'=>$data['author'],
				'digest'=>$data['digest'],
				'show_cover_pic'=>$data['show_cover_pic'],
				'content'=>$data['content'],
				'content_source_url'=>$data['content_source_url'],
			]);
		$wxRes = $material->updateArticle($media_id,$arts);
		$wxRes->media_id = $thumbMediaId;
		return $wxRes;
	}
	// 素材文章排序
	public function postSort(Request $req)
	{
		// 开启事务
        DB::beginTransaction();
    	try {
			$ids = $req->input('sids');
	        $sort = $req->input('sort');
	        if (is_array($ids))
	        {
	        	$mid = 0;
	            foreach ($ids as $v) {
	                WxArt::where('id',$v)->update(['sort'=>(int) $sort[$v]]);
	                if ($mid == 0) {
	                	$mid = WxArt::where('id',$v)->value('mid');
	                }
	            }
	            // 排序完成要更新微信素材
	            // 取得此素材的mediaid
	            $media_id = WxMater::where('id',$mid)->value('media_id');
	            $material = app('wechat')->material;
	            // 旧的数据
	            $list = WxArt::where('mid',$mid)->orderBy('sort','asc')->get();
	            // 把对应的老素材删除
	            $material->delete($media_id);
	            // 创建新的并更新
	            $arts = [];
	            foreach ($list as $k => $v) {
	            	$arts[] = new Article([
	            		'title'=>$v->title,
	            		'thumb_media_id'=>$v->media_id,
	            		'author'=>$v->author,
	            		'digest'=>$v->digest,
	            		'show_cover_pic'=>$v->show_cover_pic,
	            		'content'=>$v->content,
	            		'content_source_url'=>$v->content_source_url,
	            	]);
	            }
	            $wxRes = $material->uploadArticle($arts);
	            WxMater::where('id',$mid)->update(['media_id'=>$wxRes->media_id]);
	        }
	        else
	        {
	            return back()->with('message', '请先选择文章！');
	        }
	       	// 没出错，提交事务
            DB::commit();
    		return back()->with('message','删除成功');
    	} catch (\Exception $e) {
    		// 出错回滚
            DB::rollBack();
            dd($e);
    		return back()->with('message','删除失败，请确认这不是以前的遗留数据！');
    	}
	}
	// 修改素材文章
	public function getDelart($id = '')
    {
    	// 开启事务
        DB::beginTransaction();
    	try {
    		$material = app('wechat')->material;
	    	$mid = WxArt::where('id',$id)->value('mid');
	    	$media_id = WxMater::where('id',$mid)->value('media_id');
	    	WxArt::destroy($id);
	    	$list = WxArt::where('mid',$mid)->orderBy('sort','asc')->get();
	    	// 如果删除没了，把对应的素材也掉
    		$res = $material->delete($media_id);
	    	if ($list->count() == 0 && $res->errcode == 0) {
    			WxMater::where('id',$id)->delete();
	    	}
	    	else
	    	{
	    		// 创建新的并更新
	    		$arts = [];
	    		foreach ($list as $k => $v) {
	    			$arts[] = new Article([
						'title'=>$v->title,
						'thumb_media_id'=>$v->media_id,
						'author'=>$v->author,
						'digest'=>$v->digest,
						'show_cover_pic'=>$v->show_cover_pic,
						'content'=>$v->content,
						'content_source_url'=>$v->content_source_url,
					]);
	    		}
				$wxRes = $material->uploadArticle($arts);
				WxMater::where('id',$mid)->update(['media_id'=>$wxRes->media_id]);
	    	}
	    	// 没出错，提交事务
            DB::commit();
    		return back()->with('message','删除成功');
    	} catch (\Exception $e) {
    		// 出错回滚
            DB::rollBack();
            dd($e);
    		return back()->with('message','删除失败，请确认这不是以前的遗留数据！');
    	}
    }
    // 添加素材
    public function getAdd()
    {
    	$title = '添加素材';
    	return view('admin.wxart.add',compact('title'));
    }
    public function postAdd(WxMaterRequest $req)
	{
		try {
	    	$data = $req->input('data');
	    	$data['type'] = 'news';
	    	// 微信的上传
	    	$wxRes = $this->wxupload([]);
	    	$data['media_id'] = $wxRes->media_id;
	    	$data['content'] = '';
	    	WxMater::create($data);
	    	// 更新微信服务器
	        return $this->ajaxReturn(1,'添加成功',url('/console/wxart/index'));
		} catch (\Exception $e) {
	        return $this->ajaxReturn(0,$e->getLine().' - '.$e->getMessage());
		}
	}
	// 修改素材
    public function getEdit($id = '')
    {
    	$title = '修改素材';
    	$name = WxMater::where('id',$id)->value('name');
    	$ref = session('backurl');
    	return view('admin.wxart.edit',compact('title','name','id','ref'));
    }
    public function postEdit(WxMaterRequest $req,$id = '')
	{
		try {
	    	WxMater::where('id',$id)->update(['name'=>$req->input('data.name')]);
	    	// 更新微信服务器
	        return $this->ajaxReturn(1,'修改成功',$req->ref);
		} catch (\Exception $e) {
	        return $this->ajaxReturn(0,$e->getLine().' - '.$e->getMessage());
		}
	}
	// 删除功能
	public function getDel($id = '')
	{
		try {
			$mediaId = WxMater::where('id',$id)->value('media_id');
			WxArt::where('mid',$id)->delete();
			$material = app('wechat')->material;
			$res = $material->delete($mediaId);
			if ($res->errcode == 0) {
				WxMater::where('id',$id)->delete();
			}
			return back()->with('message','删除成功');
		} catch (\Exception $e) {
			return back()->with('message','删除失败，请确认这不是以前的遗留数据！');
		}
	}
	// 微信的上传，先造一个假数据
	private function wxupload($file)
	{
		$material = app('wechat')->material;
		// 传一个缩略图上去
		// $thumbRes = $material->uploadThumb(public_path().$file);
		// $thumbMediaId = $thumbRes->media_id;
		$arts = new Article([
				'title'=>'ss',
				'thumb_media_id'=>'wMFN2qbtS8y3MmqcIGRHV5SmVKRNCTw5IqDvRE5RhW8',
				'author'=>'',
				'digest'=>'',
				'show_cover_pic'=>0,
				'content'=>'dsa',
				'content_source_url'=>'',
			]);
		$wxRes = $material->uploadArticle($arts);
		// $wxRes->arts = $file;
		return $wxRes;
	}
}
