<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
	public $theme = 'home';
    public function __construct()
    {
        $this->theme = isset(cache('config')['theme']) && cache('config')['theme'] != null ? cache('config')['theme'] : 'home';
    }
    // ajax返回
    public function ajaxReturn($code = '1',$msg = '')
    {
        exit(json_encode(['code'=>$code,'msg'=>$msg]));
        return;
    }
}
