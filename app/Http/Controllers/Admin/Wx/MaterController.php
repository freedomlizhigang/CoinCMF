<?php

namespace App\Http\Controllers\Admin\Wx;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Wx\WxMaterRequest;
use App\Models\Wx\WxMater;
use Illuminate\Http\Request;

class MaterController extends BaseController
{
    // 素材管理
    public function getIndex(Request $req)
    {
    	$title = '素材管理';
    	$type = $req->input('type','image');
    	$list = WxMater::where('type',$type)->orderBy('id','desc')->paginate(15);
    	return view('admin.wxmater.index_'.$type,compact('title','list','type'));
    }
    // 添加素材
    public function getAdd()
    {
    	$title = '添加素材';
    	return view('admin.wxmater.add',compact('title'));
    }
    public function postAdd(WxMaterRequest $req)
	{
		try {
	    	$data = $req->input('data');
	    	// 微信的上传
	    	$wxRes = $this->wxupload($data['file'],$data['type'],$data['name'],$data['describe']);
	    	unset($data['file']);unset($data['describe']);
	    	$data['media_id'] = $wxRes->media_id;
	    	$data['content'] = json_encode($wxRes);
	    	WxMater::create($data);
	    	// 更新微信服务器
	        return $this->ajaxReturn(1,'添加成功',url('/console/mater/index').'?type='.$data['type']);
		} catch (\Exception $e) {
	        return $this->ajaxReturn(0,$e->getLine().' - '.$e->getMessage());
		}
	}
	// 删除功能
	public function getDel($id = '')
	{
		try {
			$mediaId = WxMater::where('id',$id)->value('media_id');
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
	// 微信的上传
	private function wxupload($file,$type,$title = '',$describe = '')
	{
		$material = app('wechat')->material;
		switch ($type) {
			// 缩略图
			case 'thumb':
				$wxRes = $material->uploadThumb(public_path().$file);
				$wxRes->localpath = $file;
				break;

			// 视频
			case 'video':
				$wxRes = $material->uploadVideo(public_path().$file,$title,$describe);
				$wxRes->localpath = $file;
				$wxRes->describe = $describe;
				break;

			// 声音
			case 'voice':
				$wxRes = $material->uploadVoice(public_path().$file);
				$wxRes->localpath = $file;
				break;
			
			// 图片
			default:
		    	$wxRes = $material->uploadImage(public_path().$file);
    			$wxRes->localpath = $file;
				break;
		}
		return $wxRes;
	}
	// 选择素材
	public function getSelect(Request $res)
    {
        $title = '选择素材';
        // 搜索关键字
        $key = trim($res->input('q',''));
        $list = WxMater::where(function($q) use($key){
                if ($key != '') {
                    $q->where('name','like','%'.$key.'%');
                }
            })->orderBy('id','desc')->paginate(10);
        return view('admin.wxmater.select',compact('title','list','key'));
    }
}
