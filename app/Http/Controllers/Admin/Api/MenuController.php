<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Console\Menu;
use Illuminate\Http\Request;

class MenuController extends ResponseController
{
    // 取下拉框菜单
    public function getList()
    {
        try {
            // 一级菜单
            $left = Menu::where('parentid','=',0)->where('display','=','1')->orderBy('sort','asc')->orderBy('id','asc')->get()->toArray();
            $leftmenu = array();
            // 判断权限
            $leftmenu = $left;
            // 二级菜单
            foreach ($leftmenu as $k => $v) {
                // 取所有下级菜单
                $res = Menu::where('parentid','=',$v['id'])->where('display','=','1')->orderBy('sort','asc')->orderBy('id','asc')->get()->toArray();
                $leftmenu[$k]['submenu'] = $res;
            }
            return $this->resData(200,'获取成功！',$leftmenu);
        } catch (\Throwable $e) {
            return $this->resData(400,'获取失败，请稍后再试！');
        }
    }
}
