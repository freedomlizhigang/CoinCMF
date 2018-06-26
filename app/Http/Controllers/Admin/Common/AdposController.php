<?php
/*
 * @package [App\Http\Controllers\Admin\Common]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 广告位管理
 *
 */
namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\AdposRequest;
use App\Models\Common\Adpos;
use Illuminate\Http\Request;

class AdposController extends Controller
{
    /**
     * 广告位列表
     * @return [type] [description]
     */
    public function getIndex(Request $req)
    {
    	$title = '广告位管理';
        $q = $req->input('q','');
        $list = Adpos::where(function($r)use($q){
            if ($q != '') {
                $r->where('name','like','%$q%');
            }
        })->orderBy('id','desc')->paginate(10);
    	return view('admin.console.adpos.index',compact('title','list','q'));
    }
    /**
     * 添加广告位
     */
    public function getAdd()
    {
    	$title = '添加广告位';
    	return view('admin.console.adpos.add',compact('title'));
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
        $title = '修改广告位';
        $info = Adpos::findOrFail($id);
        return view('admin.console.adpos.edit',compact('title','info'));
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
    	// 先查广告位下有没有商品，没有直接删除
        Adpos::where('id',$id)->delete();
        return back()->with('message', '删除完成！');
    }
}
