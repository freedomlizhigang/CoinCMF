<?php
/*
 * @package [App\Http\Controllers\Admin]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 首页
 *
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common\Area;
use App\Models\Common\Cate;
use App\Models\Common\Type;
use App\Models\Console\Config;
use App\Models\Console\Menu;
use App\Models\Console\Priv;
use Cache;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * 后台首页
     */
    public function getIndex()
    {
        try {
            $allUrl = $this->allPriv();
            $main = Menu::where('parentid','=','0')->where('display','=','1')->orderBy('sort','asc')->orderBy('id','asc')->get()->toArray();
            if (in_array(1, session('console')->allRole))
            {
                $mainmenu = $main;
            }
            else
            {
                $mainmenu = array();
                foreach ($main as $k => $v) {
                    foreach ($allUrl as $url) {
                        if ($v['url'] == $url) {
                            $mainmenu[$k] = $v;
                        }
                    }
                }
            }
            return view('admin.index',compact('mainmenu'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }

    /**
     * 主要信息展示
     */
    public function getMain(Request $req)
    {
        try {
            $title = '系统信息';
            return view('admin.console.index.main',compact('title'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function getLeft($pid)
    {
        try {
            // 权限url
            $allUrl = $this->allPriv();
            // 二级菜单
            $left = Menu::where('parentid','=',$pid)->where('display','=','1')->orderBy('sort','asc')->orderBy('id','asc')->get()->toArray();
            $leftmenu = array();
            // 判断权限
            if (!in_array(1, session('console')->allRole))
            {
                foreach ($left as $k => $v) {
                    foreach ($allUrl as $url) {
                        if ($v['url'] == $url) {
                            $leftmenu[$k] = $v;
                        }
                    }
                }
            }
            else
            {
                $leftmenu = $left;
            }
            // 三级菜单
            foreach ($leftmenu as $k => $v) {
                // 取所有下级菜单
                $res = Menu::where('parentid','=',$v['id'])->where('display','=','1')->orderBy('sort','asc')->orderBy('id','asc')->get()->toArray();
                // 进行权限判断
                if (!in_array(1, session('console')->allRole))
                {
                    foreach ($res as $s => $v) {
                        foreach ($allUrl as $url) {
                            if ($v['url'] == $url) {
                                $leftmenu[$k]['submenu'][$s] = $v;
                            }
                        }
                    }
                }
                else
                {
                    $leftmenu[$k]['submenu'] = $res;
                }
            }
            // dd($leftm enu);
            return view('admin.left',compact('leftmenu'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    // 查出所有有权限的url
    private function allPriv()
    {
        $rid = session('console')->allRole;
        // 查url
        $priv = Priv::whereIn('role_id',$rid)->pluck('url')->toArray();
        return $priv;
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
