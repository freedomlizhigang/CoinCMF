<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Console\Menu;
use Illuminate\Http\Request;

class CommonController extends ResponseController
{
    // 面包屑导航
    public function getBreadCrumbList(Request $req)
    {
        try {
            $label = $req->input('label');
            $self = Menu::where('label',$label)->select('id','arrparentid','name','url')->first();
            $res = [];
            $res[] = ['name'=>'首页','to'=>'/console/index/index'];
            if (!is_null($self)) {
                $menuids = explode(',',$self->arrparentid);
                unset($menuids[0]);
                // 取所有父栏目出来
                $all = Menu::whereIn('id',$menuids)->select('id','parentid','url','name')->get();
                foreach ($all as $v) {
                    if ($v->parentid == 0) {
                        $res[] = ['name'=>$v->name,'to'=>''];
                    }
                    else
                    {
                        $res[] = ['name'=>$v->name,'to'=>'/console/'.$v->url];
                    }
                }
                $res[] = ['name'=>$self->name,'to'=>'/console/'.$self->url];
            }
            return $this->resData(200,'获取成功！',$res);
        } catch (\Throwable $e) {
            return $this->resData(400,'获取失败，请稍后再试！');
        }
    }
}
