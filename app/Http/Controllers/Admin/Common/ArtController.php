<?php
/*
 * @package [App\Http\Controllers\Admin\Common]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 文章管理
 *
 */
namespace App\Http\Controllers\Admin\Common;

use App\Customize\Func;
use App\Http\Controllers\Controller;
use App\Http\Requests\Common\ArtRequest;
use App\Models\Common\Article;
use App\Models\Common\Cate;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ArtController extends Controller
{
    /**
     * 文章列表
     * @return [type] [description]
     */
    public function getIndex(Request $req)
    {
        $title = '文章列表';
        $catid = $req->input('cate_id');
        // 搜索关键字
        $key = $req->input('q','');
        $starttime = $req->input('starttime');
        $endtime = $req->input('endtime');
        // 超级管理员可以看所有的
        $cats = Cate::get();
        $tree = app('com')->toTree($cats,'0');
        $cate = app('com')->toTreeSelect($tree);
        $list = Article::with('cate')->where(function($q) use($catid){
                if ($catid != '') {
                    $q->where('cate_id',$catid);
                }
            })->where(function($q) use($key){
                if ($key != '') {
                    $q->where('title','like','%'.$key.'%');
                }
            })->where(function($q) use($starttime){
                if ($starttime != '') {
                    $q->where('created_at','>',$starttime);
                }
            })->where(function($q) use($endtime){
                if ($endtime != '') {
                    $q->where('created_at','<',$endtime);
                }
            })->orderBy('id','desc')->paginate(10);
        // 记录上次请求的url path，返回时用
        session()->put('backurl',$req->fullUrl());
        return view('admin.console.art.index',compact('title','list','cate','catid','key','starttime','endtime'));
    }

    /**
     * 添加文章
     * @param  string $catid [栏目ID]
     * @return [type]        [description]
     */
    public function getAdd($catid = '0')
    {
        $title = '添加文章';
        // 如果catid=0，查出所有栏目，并转成select
        $cate = '';
        if($catid == '0')
        {
            $cats = Cate::get();
            $tree = app('com')->toTree($cats,'0');
            $cate = app('com')->toTreeSelect($tree);
        }
        return view('admin.console.art.add',compact('title','catid','cate'));
    }
    public function postAdd(ArtRequest $req)
    {
        $data = $req->input('data');
        // 开启事务
        DB::beginTransaction();
        try {
            $data['url'] = Func::createUuid();
            $art = Article::create($data);
            // 没出错，提交事务
            DB::commit();
            // 跳转回添加的栏目列表
            return $this->adminJson(1,'添加文章成功！',url('/console/art/index?cate_id='.$req->input('data.cate_id')));
        } catch (\Throwable $e) {
            // 出错回滚
            DB::rollBack();
            return $this->adminJson(0,'添加失败，请稍后再试！');
        }
    }
    /**
     * 修改文章
     * @param  string $id [文章ID]
     * @return [type]     [description]
     */
    public function getEdit($id = '')
    {
        $title = '修改文章';
        // 拼接返回用的url参数
        $ref = session('backurl');
        $info = Article::findOrFail($id);
        $cats = Cate::get();
        $tree = app('com')->toTree($cats,'0');
        $cate = app('com')->toTreeSelect($tree);
        return view('admin.console.art.edit',compact('title','cate','info','ref'));
    }
    public function postEdit(ArtRequest $req,$id = '')
    {
        $data = $req->input('data');
        // 开启事务
        DB::beginTransaction();
        try {
            $art = Article::where('id',$id)->update($data);
            // 没出错，提交事务
            DB::commit();
            // 取得编辑前url参数，并跳转回去
            return $this->adminJson(1,'修改文章成功！',$req->input('ref'));
        } catch (\Throwable $e) {
            // 出错回滚
            DB::rollBack();
            return $this->adminJson(0,'修改失败，请稍后再试！');
        }
    }
    /**
     * 删除文章
     * @param  string $id [文章ID]
     * @return [type]     [description]
     */
    public function getDel($id = '')
    {
        // 开启事务
        DB::beginTransaction();
        try {
            Article::destroy($id);
            // 没出错，提交事务
            DB::commit();
            return back()->with('message', '删除文章成功！');
        } catch (\Throwable $e) {
            // 出错回滚
            DB::rollBack();
            return back()->with('message','删除失败，请稍后再试！');
        }
    }
    /**
     * 查看文章
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public function getShow($id = '')
    {
        $title = '查看文章详情';
        // 拼接返回用的url参数
        $ref = session('backurl');
        $info = Article::findOrFail($id);
        return view('admin.console.art.show',compact('title','info','ref'));
    }
    // 批量删除
    public function postAlldel(Request $req)
    {
        $ids = $req->input('sids');
        // 是数组更新数据，不是返回
        if(is_array($ids))
        {
            // 开启事务
            DB::beginTransaction();
            try {
                Article::whereIn('id',$ids)->delete();
                // 没出错，提交事务
                DB::commit();
                return back()->with('message', '批量删除完成！');
            } catch (\Throwable $e) {
                // 出错回滚
                DB::rollBack();
                return back()->with('message','删除失败，请稍后再试！');
            }
        }
        else
        {
            return back()->with('message','请选择文章！');
        }
    }
    // 批量排序
    public function postsort(Request $req)
    {
        $ids = $req->input('sids');
        $sort = $req->input('sort');
        if (is_array($ids))
        {
            foreach ($ids as $v) {
                Article::where('id',$v)->update(['sort'=>(int) $sort[$v]]);
            }
            return back()->with('message', '排序成功！');
        }
        else
        {
            return back()->with('message', '请先选择文章！');
        }
    }
}
