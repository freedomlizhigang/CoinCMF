<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2018-07-25 11:39:58
 * @Description: 广告管理
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-20 20:08:59
 * @FilePath: /CoinCMF/app/Http/Controllers/Console/Content/AdController.php
 */

namespace App\Http\Controllers\Console\Content;

use App\Models\Common\Ad;
use App\Models\Common\Adpos;
use Illuminate\Http\Request;
use App\Http\Requests\Common\AdRequest;
use App\Http\Controllers\Console\ResponseController;

class AdController extends ResponseController
{
    /**
     * 广告管理
     * @return [type] [description]
     */
    public function getIndex(Request $req)
    {
        try {
            $title = '广告管理';
            // 搜索关键字
            $key = trim($req->input('q',''));
            $starttime = $req->input('starttime');
            $endtime = $req->input('endtime');
            $status = $req->input('status');
            $list = Ad::where(function($q) use($key){
                    if ($key != '') {
                        $q->where('title','like','%'.$key.'%');
                    }
                })->where(function($q) use($starttime,$endtime){
                    if ($starttime != '' && $endtime != '') {
                        $q->where('created_at','>=',$starttime)->where('created_at','<=',$endtime);
                    }
                })->where(function($q) use($status){
                    if ($status != '') {
                        $q->where('status',$status);
                    }
                })->orderBy('id','desc')->paginate(10);
            return view('admin.console.ad.index',compact('title','list','key','starttime','endtime','status'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    // 添加广告
    public function getAdd($id = '')
    {
        try {
            $title = '添加广告';
            $pos = Adpos::orderBy('id','asc')->get();
            return view('admin.console.ad.add',compact('title','id','pos'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postAdd(AdRequest $req,$id = '')
    {
        try {
            $data = $req->input('data');
            Ad::create($data);
            return $this->adminJson(1,'添加成功！',url('/console/ad/index'));
        } catch (\Throwable $e) {
            return $this->adminJson(0,'添加失败！');
        }
    }
    // 修改广告
    public function getEdit($id = '')
    {
        try {
            $title = '修改广告';
            $pos = Adpos::orderBy('id','asc')->get();
            $info = Ad::findOrFail($id);
            return view('admin.console.ad.edit',compact('title','info','pos'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postEdit(AdRequest $req,$id = '')
    {
        try {
        	$data = $req->input('data');
        	Ad::where('id',$id)->update($data);
            return $this->adminJson(1,'修改成功！');
        } catch (\Throwable $e) {
            return $this->adminJson(0,'修改失败！');
        }
    }
    // 删除
    public function getDel($id = '')
    {
        try {
        	Ad::where('id',$id)->delete();
            return back()->with('message','删除成功！');
        } catch (\Throwable $e) {
        	return back()->with('message','删除失败！');
        }
    }
    // 排序
    public function postSort(Request $req)
    {
        try {
            $ids = $req->input('sids');
            $sort = $req->input('sort');
            if (is_array($ids))
            {
                foreach ($ids as $v) {
                    Ad::where('id',$v)->update(['sort'=>(int) $sort[$v]]);
                }
                return back()->with('message', '排序成功！');
            }
            else
            {
                return back()->with('message', '请先选择广告！');
            }
        } catch (\Throwable $e) {
            return back()->with('message','排序失败！');
        }
    }
    // 批量删除
    public function postAlldel(Request $req)
    {
        try {
            $ids = $req->input('sids');
            // 是数组更新数据，不是返回
            if(is_array($ids))
            {
                Ad::whereIn('id',$ids)->delete();
                return back()->with('message', '批量删除完成！');
            }
            else
            {
                return back()->with('message','请选择广告！');
            }
        } catch (\Throwable $e) {
            return back()->with('message','批量删除失败！');
        }
    }
}
