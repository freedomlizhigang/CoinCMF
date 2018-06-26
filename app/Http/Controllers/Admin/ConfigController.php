<?php
/*
 * @package [App\Http\Controllers\Admin]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 系统配置
 *
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Console\Config;
use Cache;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index(Request $req)
    {
    	$title = '系统配置';
    	$config = Config::findOrFail(1);
    	return view('admin.console.config.index',compact('title','config'));
    }
    public function postIndex(Request $req)
    {
    	$data = $req->input('data');
    	Config::where('id',1)->update($data);
    	// 更新缓存
    	Cache::forever('config',$data);
    	return $this->adminJson(1,'更新成功');
    }
}
