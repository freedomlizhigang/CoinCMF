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
use Illuminate\Http\Request;

class ArtController extends Controller
{
    /**
     * 文章列表
     * @return [type] [description]
     */
    public function getIndex(Request $req)
    {
    	try {
            $title = '文章列表';
            // 超级管理员可以看所有的
            $cats = Cate::get();
        	$tree = app('com')->toTree($cats,'0');
        	$cate = app('com')->toTreeSelect($tree);
            // 记录上次请求的url path，返回时用
            session()->put('backurl',url()->full());
        	return view('admin.console.art.index',compact('title','cate'));
        } catch (\Throwable $e) {
            // dd($e);
            return view('errors.500');
        }
    }

    /**
     * 文章列表
     * @return [type] [description]
     */
    public function getTable(Request $req)
    {
        try {
            $catid = $req->input('catid');
            // 搜索关键字
            $key = $req->input('q','');
            $push_flag = $req->input('push_flag');
            $starttime = $req->input('starttime');
            $endtime = $req->input('endtime');
            // 超级管理员可以看所有的
            $cats = Cate::get();
            $tree = app('com')->toTree($cats,'0');
            $cate = app('com')->toTreeSelect($tree);
            $list = Article::with(['cate'=>function($q){
                    $q->select('id','name');
                }])->where(function($q) use($catid){
                    if ($catid != '') {
                        $q->where('cate_id',$catid);
                    }
                })->where(function($q) use($key){
                    if ($key != '') {
                        $q->where('title','like','%'.$key.'%');
                    }
                })->where(function($q) use($push_flag){
                    if ($push_flag != '') {
                        $q->where('push_flag',$push_flag);
                    }
                })->where(function($q) use($starttime){
                    if ($starttime != '') {
                        $q->where('created_at','>',$starttime);
                    }
                })->where(function($q) use($endtime){
                    if ($endtime != '') {
                        $q->where('created_at','<',$endtime);
                    }
                })->select('id','title','cate_id','hits','publish_at')->where('del_flag',0)->orderBy('id','desc')->get();
            $reslist = [];
            foreach ($list as $v) {
                $reslist[] = ['id'=>$v->id,'title'=>$v->title,'hits'=>$v->hits,'publish_at'=>$v->publish_at,'catename'=>$v->cate->name];
            }
            $res = ['code'=>0,'msg'=>'0','count'=>$list->count(),'data'=>$reslist];
            return $res;
        } catch (\Throwable $e) {
            // dd($e);
            return view('errors.500');
        }
    }

    /**
     * 添加文章
     * @param  string $catid [栏目ID]
     * @return [type]        [description]
     */
    public function getAdd($catid = '0')
    {
        try {
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
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postAdd(ArtRequest $req)
    {
        // 开启事务
        try {
            $data = $req->input('data');
            $data['url'] = Func::createUuid();
            $data['tpl'] = Cate::where('id',$data['cate_id'])->value('art_tpl');
            $art = Article::create($data);
            // 跳转回添加的栏目列表
            return $this->adminJson(1,'添加文章成功！',url('/console/art/index?catid='.$req->input('data.cate_id')));
        } catch (\Throwable $e) {
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
        try {
            $title = '修改文章';
            // 拼接返回用的url参数
            $ref = session('backurl');
            $info = Article::where('del_flag',0)->findOrFail($id);
            $cats = Cate::get();
            $tree = app('com')->toTree($cats,'0');
            $cate = app('com')->toTreeSelect($tree);
            return view('admin.console.art.edit',compact('title','cate','info','ref'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postEdit(ArtRequest $req,$id = '')
    {
        try {
            $data = $req->input('data');
            $data['tpl'] = Cate::where('id',$data['cate_id'])->value('art_tpl');
            $art = Article::where('id',$id)->update($data);
            // 全文搜索
            Article::where('id',$id)->searchable();
            // 取得编辑前url参数，并跳转回去
            return $this->adminJson(1,'修改文章成功！',$req->input('ref'));
        } catch (\Throwable $e) {
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
        try {
            Article::destroy($id);
            // 全文搜索
            Article::where('id',$id)->unsearchable();
            return back()->with('message', '删除文章成功！');
        } catch (\Throwable $e) {
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
        try {
            $title = '查看文章详情';
            // 拼接返回用的url参数
            $ref = session('backurl');
            $info = Article::where('del_flag',0)->findOrFail($id);
            return view('admin.console.art.show',compact('title','info','ref'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    // 批量删除
    public function postAlldel(Request $req)
    {
        $ids = $req->input('sids');
        // 是数组更新数据，不是返回
        if(is_array($ids))
        {
            try {
                Article::whereIn('id',$ids)->update(['del_flag'=>1]);
                // 全文搜索
                Article::whereIn('id',$ids)->unsearchable();
                return back()->with('message', '批量删除完成！');
            } catch (\Throwable $e) {
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
        try {
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
        } catch (\Throwable $e) {
            return back()->with('message', '排序失败！');
        }
    }
}
