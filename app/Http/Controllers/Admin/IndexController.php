<?php
/*
 * @package [App\Http\Controllers\Admin]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水山木枝技术服务有限公司]
 * @version [2.0.0]
 * @directions 首页
 *
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common\Cate;
use App\Models\Common\Type;
use App\Models\Console\Config;
use App\Models\Console\Menu;
use Cache;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * 后台首页
     */
    public function getIndex()
    {
        return redirect('/console.html#/');
    }

    // 更新缓存
    public function getCache()
    {
        try {
            $config = Config::select('sitename','title','keyword','describe','theme','person','phone','email','address','content')->findOrFail(1)->toArray();
            Cache::forever('config',$config);
            echo "<p><small>更新系统缓存成功...</small></p>";
            app('com')->updateCache(new Cate,'cateCache',1);
            echo "<p><small>更新栏目缓存成功...</small></p>";
            app('com')->updateCache(new Menu,'menuCache',1);
            echo "<p><small>更新后台菜单缓存成功...</small></p>";
            app('com')->updateCache(new Type,'typeCache',1);
            echo "<p><small>更新分类缓存成功...</small></p>";
            echo "<p><small>更新缓存完成...</small></p>";
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
}
