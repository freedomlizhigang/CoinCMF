<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Common\Cate;
use Illuminate\Http\Request;

class CateController extends ResponseController
{
    // 取下拉框菜单
    public function getSelect()
    {
        try {
            $cats = Cate::get();
            $tree = app('com')->toTree($cats,'0');
            $tree = app('com')->toTreeSelect($tree);
            return $this->resData(200,'获取成功！',$tree);
        } catch (\Throwable $e) {
            return $this->resData(400,'获取失败，请稍后再试！');
        }
    }
}
