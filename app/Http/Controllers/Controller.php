<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	// json返回数据
	public function resJson($code = 200, $msg = '', $result = '') {
		return ['code' => $code, 'msg' => $msg, 'result' => $result];
	}
	// 后台json返回格式
	public function adminJson($status = 1, $msg = '', $url = '') {
		return ['status' => $status, 'msg' => $msg, 'url' => $url];
	}

}
