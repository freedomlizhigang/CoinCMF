<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common\Article;
use Illuminate\Http\Request;

class ArticleController extends ResponseController
{
    /**
     * 文章列表
     * @return [type] [description]
     */
    public function getList(Request $req)
    {
        try {
            $catid = $req->input('cateid');
            // 搜索关键字
            $key = $req->input('key','');
            $push_flag = $req->input('push_flag');
            $starttime = $req->input('starttime');
            $endtime = $req->input('endtime');
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
                        $q->where('created_at','>',date('Y-m-d H:i:s',$starttime/1000));
                    }
                })->where(function($q) use($endtime){
                    if ($endtime != '') {
                        $q->where('created_at','<',date('Y-m-d H:i:s',$endtime/1000));
                    }
                })->select('id','title','cate_id','hits','publish_at','sort')->where('del_flag',0)->orderBy('id','desc')->get();
            $reslist = [];
            foreach ($list as $v) {
                $reslist[] = ['id'=>$v->id,'sort'=>$v->sort,'title'=>$v->title,'hits'=>$v->hits,'publish_at'=>$v->publish_at,'catename'=>$v->cate->name];
            }
            return $this->resLayTable(200,'',$list->count(),$reslist);
        } catch (\Throwable $e) {
            return $this->resLayTable(400,'获取数据失败，请稍后再试！');
        }
    }
    /**
     * 删除文章
     * @param  string $id [文章ID]
     * @return [type]     [description]
     */
    public function postDelete(Request $req)
    {
        try {
            $id = $req->input('id');
            // Article::destroy($id);
            // // 全文搜索
            // Article::where('id',$id)->unsearchable();
            return $this->resData(200,'删除成功！');
        } catch (\Throwable $e) {
            return $this->resData(400,'删除失败，请稍后再试！');
        }
    }
    /**
     * 删除文章
     * @param  string $id [文章ID]
     * @return [type]     [description]
     */
    public function postDeleteAll(Request $req)
    {
        try {
            $ids = $req->input('ids');
            // Article::whereIn('id',$ids)->delete();
            // // 全文搜索
            // Article::whereIn('id',$ids)->unsearchable();
            return $this->resData(200,'删除成功！');
        } catch (\Throwable $e) {
            return $this->resData(400,'删除失败，请稍后再试！');
        }
    }
    /**
     * 单条排序
     * @param  string $id [文章ID]
     * @return [type]     [description]
     */
    public function postSort(Request $req)
    {
        try {
            $id = $req->input('id');
            $sort = $req->input('sort');
            Article::where('id',$id)->update(['sort'=>$sort]);
            return $this->resData(200,'排序成功！');
        } catch (\Throwable $e) {
            return $this->resData(400,'排序失败，请稍后再试！');
        }
    }
}
