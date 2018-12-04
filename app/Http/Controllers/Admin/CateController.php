<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common\Cate;
use Illuminate\Http\Request;

class CateController extends ResponseController
{
    // 取下拉框菜单
    public function getSelect()
    {
        try {
            $cates = Cate::select('id','parentid','name','sort','url')->get();
            $res = [];
            $f_cates = $cates->where('parentid',0)->all();
            // 只查三级
            foreach ($f_cates as $v) {
                // 一级
                $res[] = ['label'=>$v->name,'value'=>$v->id];
                // 二级
                $s_cates = $cates->where('parentid',$v->id)->all();
                foreach ($s_cates as $s) {
                    $res[] = ['label'=>'|- '.$s->name,'value'=>$s->id];
                    // 三级的
                    $t_cates = $cates->where('parentid',$s->id)->all();
                    foreach ($t_cates as $t) {
                        $res[] = ['label'=>'||- '.$t->name,'value'=>$t->id];
                    }
                }
            }
            return $this->resData(200,'获取成功！',$res);
        } catch (\Throwable $e) {
            return $this->resData(400,'获取失败，请稍后再试！');
        }
    }
}
