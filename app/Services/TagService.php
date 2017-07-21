<?php
namespace App\Services;
use App\Models\Ad;
use App\Models\Article;
use App\Models\Cate;
use App\Models\Good;
use App\Models\GoodCate;
use App\Models\Huodong;
use App\Models\Tuan;

class TagService
{
    /*
    * 取栏目
     */
    public function cate($pid = 0,$nums = 10)
    {
        $cate = Cate::where('parentid',$pid)->limit(4)->orderBy('sort','desc')->get();
        return $cate;
    }

    /*
    * 取文章，不带分页
     */
    public function arts($cid = 0,$num = 5)
    {
        $cid = explode(',', $cid);
        $art = Article::whereIn('catid',$cid)->limit($num)->orderBy('id','desc')->get();
        return $art;
    }

    // 面包屑导航
    public function catpos($cid)
    {
        try {
            $cate = Cate::where('id',$cid)->first();
            if ($cate->parentid == 0) {
                echo "<li class='active'><a href='/cate/".$cate->url."'>".$cate->name."</a></li>";
            }
            else
            {
                $parentcate = Cate::where('id',$cate->parentid)->first();
                echo "<li><a href='/cate/".$parentcate->url."'>".$parentcate->name."</a></li><li class='active'><a href='/cate/".$cate->url."'>".$cate->name."</a></li>";
            }
        } catch (\Exception $e) {
            echo '';
        }
    }

}
