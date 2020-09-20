<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2018-07-25 11:39:58
 * @Description: 广告位管理
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-20 20:09:34
 * @FilePath: /CoinCMF/app/Http/Controllers/Console/Content/AdposController.php
 */

namespace App\Http\Controllers\Console\Content;

use App\Models\Common\Ad;
use App\Models\Common\Adpos;
use Illuminate\Http\Request;
use App\Http\Controllers\Console\ResponseController;

class AdposController extends ResponseController
{
    /**
     * 广告位列表
     * @return [type] [description]
     */
    public function getIndex(Request $req)
    {
        try {
        	$title = '广告位管理';
            $q = $req->input('q','');
            $list = Adpos::where(function($r)use($q){
                if ($q != '') {
                    $r->where('name','like','%$q%');
                }
            })->orderBy('id','desc')->paginate(10);
        	return view('admin.console.adpos.index',compact('title','list','q'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    /**
     * 添加广告位
     */
    public function getAdd()
    {
        try {
        	$title = '添加广告位';
        	return view('admin.console.adpos.add',compact('title'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postAdd(AdposRequest $res)
    {
        try {
            $data = $res->input('data');
            $resId = Adpos::create($data);
            return $this->adminJson(1, '添加成功！',url('console/adpos/index'));
        } catch (\Throwable $e) {
            return $this->adminJson(0, '添加失败，请稍后再试！');
        }
    }
    /**
     * 修改广告位
     */
    public function getEdit($id = '')
    {
        try {
            $title = '修改广告位';
            $info = Adpos::findOrFail($id);
            return view('admin.console.adpos.edit',compact('title','info'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postEdit(AdposRequest $res,$id = '')
    {
        try {
            $data = $res->input('data');
            Adpos::where('id',$id)->update($data);
            return $this->adminJson(1, '修改成功！');
        } catch (\Throwable $e) {
            return $this->adminJson(1, '修改失败，请稍后再试！');
        }
    }
    public function getDel($id)
    {
        try {
        	// 先查广告位下有没有广告，没有直接删除
            if (is_null(Ad::where('pos_id',$id)->first())) {
                Adpos::where('id',$id)->delete();
                return back()->with('message', '删除完成！');
            }
            else
            {
                return back()->with('message', '有广告，请先移除广告！');
            }
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
}
