<?php
/*
 * @package [App\Http\Controllers\Admin]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水山木枝技术服务有限公司]
 * @version [1.0.0]
 * @directions 统一返回
 *
 */
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResponseController extends Controller
{
    // 给layTable的接口返回
    public function resLayTable($code = 200,$msg = '',$count = 0,$data = [])
    {
        return ['code'=>$code,'msg'=>$msg,'count'=>$count,'data'=>$data];
    }
    // 正常的接口返回
    public function resData($code = 200,$msg = '',$data = [])
    {
        return ['code'=>$code,'msg'=>$msg,'data'=>$data];
    }
    // 所有错误的返回
    public function anyErrors()
    {
        return response()->json(['code'=>500,'msg'=>'请求地址有误！','data'=>[]]);
    }
}
