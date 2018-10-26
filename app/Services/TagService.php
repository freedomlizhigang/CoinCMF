<?php
/*
 * @package [App\Services]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 模板取数据用的一些标签方法
 *
 */
namespace App\Services;

use App\Models\Common\Ad;
use App\Models\Common\Article;
use App\Models\Common\Cate;
use App\Models\Common\Link;
use App\Models\Common\Type;

class TagService
{
    /*
    * 取友情链接
     */
    public function link($link_type_id = 0,$num = 5)
    {
        try {
            $link = Link::where(function($q) use($link_type_id){
                if ($link_type_id != 0) {
                    $q->where('link_type_id',$link_type_id);
                }
            })->limit($num)->orderBy('sort','desc')->orderBy('id','desc')->get();
            return $link;
        } catch (\Throwable $e) {
            return [];
        }
    }
    /*
    * 取广告
     */
    public function ads($pos_id = 0,$num = 5)
    {
        try {
            $ads = Ad::where('pos_id',$pos_id)->where('status',1)->where('starttime','<=',date('Y-m-d H:i:s'))->where('endtime','>=',date('Y-m-d H:i:s'))->limit($num)->orderBy('sort','desc')->orderBy('id','desc')->get();
            return $ads;
        } catch (\Throwable $e) {
            return [];
        }
    }
    /*
    * 取单个栏目
     */
    public function category($cid = 0,$field = '')
    {
        try {
            $value = cache('cateCache')[$cid][$field];
            return $value;
        } catch (\Throwable $e) {
            return '';
        }
    }
    /*
    * 取栏目列表
     */
    public function categorys($pid = 0,$nums = 10,$all = 0)
    {
        try {
            $cates = Cate::select('id','name','thumb','title','keyword','describe','url')->where('parentid',$pid)->where(function($q) use($all) {
                if ($all == 0) {
                    $q->where('display',1);
                }
            })->limit($nums)->orderBy('sort','asc')->orderBy('id','asc')->get();
            return $cates;
        } catch (\Throwable $e) {
            return [];
        }
    }
    /*
    * 取推荐文章，不带分页
     */
    public function push($cid = 0,$num = 5)
    {
        try {
            $cid = explode(',', $cid);
            $push = Article::select('id','cate_id','title','keywords','describe','url','thumb','source','hits','publish_at','push_flag')->whereIn('cate_id',$cid)->where('del_flag',0)->where('push_flag',1)->where('publish_at','<=',date('Y-m-d H:i:s'))->limit($num)->orderBy('sort','desc')->orderBy('id','desc')->get();
            return $push;
        } catch (\Throwable $e) {
            return [];
        }
    }

    /*
    * 取文章，不带分页
     */
    public function list($cid = 0,$num = 5)
    {
        try {
            $cid = explode(',', $cid);
            $list = Article::select('id','cate_id','title','keywords','describe','url','thumb','source','hits','publish_at','push_flag')->whereIn('cate_id',$cid)->where('del_flag',0)->where('publish_at','<=',date('Y-m-d H:i:s'))->limit($num)->orderBy('push_flag','desc')->orderBy('sort','desc')->orderBy('id','desc')->get();
            return $list;
        } catch (\Throwable $e) {
            return [];
        }
    }
    // 面包屑导航
    public function catpos($cid)
    {
        try {
            $self = Cate::where('id',$cid)->select('id','arrparentid','name','title','url')->first();
            $cateids = explode(',',$self->arrparentid);
            unset($cateids[0]);
            // 取所有父栏目出来
            $all = Cate::whereIn('id',$cateids)->select('id','url')->get();
            $str = "<li><a href='/'>首页</a></li>";
            foreach ($cateids as $v) {
                $str .= "<li><a href='/cate/".$cate->url."'>".$cate->name."</a></li>";
            }
            $str .= "<li class='active'><a href='/cate/".$self->url."'>".$self->name."</a></li>";
            echo $str;
        } catch (\Throwable $e) {
            echo '';
        }
    }
    // 取分类下的内容
    public function type($id = 0)
    {
        try {
            $list = Type::select('id','name','sort')->where('parentid',$id)->orderBy('sort','asc')->orderBy('id','asc')->get();
            return $list;
        } catch (\Throwable $e) {
            return [];
        }
    }
}