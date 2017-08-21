<?php

namespace App\Http\Controllers\Admin\Wx;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Wx\WxMenuRequest;
use App\Models\Wx\WxMenu;
use Illuminate\Http\Request;

class MenuController extends BaseController
{
	// 取所有微信自定义菜单
    public function getIndex(Request $req)
    {
    	$title = '自定义菜单';
    	// 更新微信服务器
    	$res = $this->updateWx();
        $list = WxMenu::where('pid',0)->orderBy('sort','asc')->orderBy('id','asc')->get();
        foreach ($list as $k => $v) {
        	$list[$k]['sub'] = WxMenu::where('pid',$v->id)->orderBy('sort','asc')->orderBy('id','asc')->get();
        }
        return view('admin.wxmenu.index',compact('title','list'));
    }
    
    /**
     * 添加自定义菜单模板
     * @param  Request $request [description]
     * @param  integer $pid     [父栏目id，默认为0，即为一级菜单]
     * @return [type]           [description]
     */
    public function getAdd(Request $req,$pid = 0)
    {
        $title = '添加自定义菜单';
    	return view('admin.wxmenu.add',compact('pid','title'));
    }
    /**
     * 添加菜单提交数据
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function postAdd(WxMenuRequest $req)
    {
    	try {
	    	$data = $req->input('data');
	    	$data['setting'] = json_encode($req->input('type'));
	    	WxMenu::create($data);
	    	// 更新微信服务器
	    	$res = $this->updateWx();
	        return $this->ajaxReturn(1,'添加菜单成功',url('/console/wxmenu/index'));
    	} catch (\Exception $e) {
	        return $this->ajaxReturn(0,$e->getLine().' - '.$e->getMessage());
    	}
    }
    /**
     * 修改菜单
     * @param  integer $id [要修改的菜单ID]
     * @return [type]      [description]
     */
    public function getEdit($id = 0)
    {
        $title = '修改菜单';
        $info = WxMenu::findOrFail($id);
        $type = json_decode($info->setting,true);
        return view('admin.wxmenu.edit',compact('title','info','type'));
    }
    public function postEdit(WxMenuRequest $req,$id)
    {
    	try {
	        $data = $req->input('data');
	        $data['setting'] = json_encode($req->input('type'));
	        WxMenu::where('id',$id)->update($data);
	        // 更新微信服务器
	    	$this->updateWx();
	        return $this->ajaxReturn(1,'修改菜单成功',url('/console/wxmenu/index'));
    	} catch (\Exception $e) {
	    	return $this->ajaxReturn(0,$e->getLine().' - '.$e->getMessage());
    	}
    }
    /**
     * 删除菜单及下属子菜单，取出当前菜单ID下边所有的子菜单ID（添加修改的时候会进行更新，包含最小是自身），然后转换成数组格式，指进行删除，然后更新菜单
     * @param  [type] $id [要删除的菜单ID]
     * @return [type]     [description]
     */
    public function getDel($id)
    {
    	try {
	        WxMenu::where('id',$id)->where('pid',$id)->delete();
	        // 更新微信服务器
	    	$this->updateWx();
	        return back()->with('message', '删除菜单成功！');
    	} catch (\Exception $e) {
    		return $this->ajaxReturn(0,$e->getLine().' - '.$e->getMessage());
    	}
    }
    // 更新微信服务器
    private function updateWx()
    {
    	$pmenu = WxMenu::where('pid',0)->orderBy('sort','asc')->orderBy('id','asc')->limit(3)->get();
    	$newmenu = [];
    	foreach ($pmenu as $k => $v) {
    		$cmenu = WxMenu::where('pid',$v->id)->orderBy('sort','asc')->orderBy('id','asc')->limit(5)->get();
    		if ($cmenu->count() == 0) {
    			$key = $this->getKey($v->setting,$v->type);
    			$tmp_newmenu = ['type'=>$v->type,'name'=>$v->name];
    			$newmenu[] = array_merge($tmp_newmenu,$key);
    		}
    		else
    		{
    			$sub_button = [];
    			foreach ($cmenu as $kk => $vv) {
    				$ckey = $this->getKey($vv->setting,$vv->type);
    				$tmp_menu = ['type'=>$vv->type,'name'=>$vv->name];
    				$sub_button[] = array_merge($tmp_menu,$ckey);
    			}
    			$newmenu[] = ['name'=>$v->name,'sub_button'=>$sub_button];
    		}
    	}
    	// 清除旧的，添加新的
    	$menu = app('wechat')->menu;
    	$menu->destroy();
    	$res = $menu->add($newmenu);
    	return $res;
    }
    // 判断类型，取key值
    private function getKey($setting = '',$type = 'click')
    {
    	$setting = json_decode($setting,true);
		switch ($type) {
            case 'miniprogram':
                $key = ['pagepath'=>$setting['key'],'url'=>$setting['url'],'appid'=>config('wechat.mini_program.app_id')];
                break;
            
            case 'view_limited':
            case 'media_id':
                $key = ['media_id'=>$setting['key']];
                break;

            case 'location_select':
            case 'pic_weixin':
            case 'pic_photo_or_album':
            case 'pic_sysphoto':
            case 'scancode_waitmsg':
            case 'scancode_push':
                $key = ['key'=>$setting['key']];
                break;
            
			case 'view':
				$key = ['url'=>$setting['url']];
				break;
			
			default:
				$key = ['key'=>$setting['key']];
				break;
		}
		return $key;
    }
}
