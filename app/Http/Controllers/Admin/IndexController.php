<?php

namespace App\Http\Controllers\Admin;

use App;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Area;
use App\Models\Config;
use App\Models\Consume;
use App\Models\Good;
use App\Models\GoodAttr;
use App\Models\GoodFormat;
use App\Models\Group;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderGood;
use App\Models\Priv;
use Cache;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 主页里关闭调试
        \Debugbar::disable();
        $this->menu = new Menu;
    }

    /**
     * 后台首页
     */
    public function getIndex()
    {
        $allUrl = $this->allPriv();
        $main = $this->menu->where('parentid','=','0')->where('display','=','1')->orderBy('sort','asc')->orderBy('id','asc')->get()->toArray();
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
    }

    /**
     * 主要信息展示
     */
    public function getMain(Request $req)
    {
        $title = '系统信息';
        return view('admin.index.main',compact('title'));
    }
    public function getLeft($pid)
    {
        // 权限url
        $allUrl = $this->allPriv();
        // 二级菜单
        $left = $this->menu->where('parentid','=',$pid)->where('display','=','1')->orderBy('sort','asc')->orderBy('id','asc')->get()->toArray();
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
            $res = $this->menu->where('parentid','=',$v['id'])->where('display','=','1')->orderBy('sort','asc')->orderBy('id','asc')->get()->toArray();
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
        $config = Config::select('sitename','title','keyword','describe','theme','person','phone','email','address','content')->findOrFail(1)->toArray();
        Cache::forever('config',$config);
        echo "<p><small>更新系统缓存成功...</small></p>";
        App::make('com')->updateCache(new App\Models\Cate,'cateCache');
        echo "<p><small>更新栏目缓存成功...</small></p>";
        App::make('com')->updateCache(new App\Models\Menu,'menuCache');
        echo "<p><small>更新后台菜单缓存成功...</small></p>";
        App::make('com')->updateCache(new App\Models\Type,'typeCache');
        echo "<p><small>更新分类缓存成功...</small></p>";
        $data = Group::where('status',1)->select('id','name','points','discount')->get()->keyBy('id')->toArray();
        Cache::forever('group',$data);
        echo "<p><small>更新会员组缓存成功...</small></p>";
        $area = Area::select('id','areaname')->get()->keyBy('id')->toArray();
        Cache::forever('area',$area);
        echo "<p><small>更新地区缓存成功...</small></p>";
        echo "<p><small>更新缓存完成...</small></p>";
    }
}
