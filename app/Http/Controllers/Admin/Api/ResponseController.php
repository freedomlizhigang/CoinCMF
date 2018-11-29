<?php

namespace App\Http\Controllers\Admin\Api;

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
}
