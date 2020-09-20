<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2019-01-03 20:14:16
 * @Description: 统一返回
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-20 20:50:02
 * @FilePath: /CoinCMF/app/Http/Controllers/Console/ResponseController.php
 */

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;

class ResponseController extends Controller
{
    // 正常的接口返回
    public function resData($code = 200,$msg = '',$data = [])
    {
        return ['code'=>$code,'message'=>$msg,'result'=>$data];
    }
}
