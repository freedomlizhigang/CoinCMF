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
            $all = Menu::select('id','parentid','name','url')->where('display','=','1')->orderBy('sort','asc')->orderBy('id','asc')->get();
            $leftmenu = array();
            // 判断权限
            $left = $all->where('parentid',0)->all();
            $leftmenu = $left;
            // 二级菜单
            foreach ($leftmenu as $k => $v) {
                // 取所有下级菜单
                $submenu = $all->where('parentid','=',$v['id'])->all();
                $leftmenu[$k]['submenu'] = $submenu;
            }
            return $this->resData(200,'获取成功！',$leftmenu);
        } catch (\Throwable $e) {
            return $this->resData(400,'获取失败，请稍后再试！');
        }
    }
}
