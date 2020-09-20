<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2019-01-03 20:14:16
 * @Description: 管理中心首页
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-20 19:48:37
 * @FilePath: /CoinCMF/app/Http/Controllers/Console/IndexController.php
 */

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * 后台首页
     */
    public function getIndex()
    {
        return redirect('/console.html#/');
    }
}
