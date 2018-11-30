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
            // 一级菜单
            $left = Menu::where('parentid','=',0)->where('display','=','1')->orderBy('sort','asc')->orderBy('id','asc')->get()->toArray();
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
            // 二级菜单
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
            return view('admin.index',compact('leftmenu'));
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
            return view('admin.index.main',compact('title'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    // 所有路由页面放这里
    public function getAll(Request $req)
    {
        try {
            // 拼接权限名字，url的第二个跟第三个参数
            $toArr = explode('/',$req->path());
            if ($toArr[0] != 'console') {
                return back()->with('message','请求地址错误！');
            }
            // 如果不写方法名，默认为index
            $toArr[2] = count($toArr) == 2 ? 'index' : $toArr[2];
            $path = 'admin.'.$toArr[1].'.'.$toArr[2];
            // 面包屑导航
            $title = $this->catpos($toArr[1].'/'.$toArr[2]);
            // 请求的参数
            $data = $req->input();
            if (view()->exists($path)) {
                return view($path,compact('title','data'));
            }
            return view('errors.500');
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    // 面包屑导航
    public function catpos($path = '')
    {
        try {
            $self = Menu::where('url',$path)->select('id','arrparentid','name','url')->first();
            $menuids = explode(',',$self->arrparentid);
            unset($menuids[0]);
            // 取所有父栏目出来
            $all = Menu::whereIn('id',$menuids)->select('id','parentid','url','name')->get();
            $str = "";
            foreach ($all as $v) {
                if ($v->parentid == 0) {
                    $str .= "<a href='javascript:;'>".$v->name."</a>";
                }
                else
                {
                    $str .= "<a href='/console/".$v->url."'>".$v->name."</a>";
                }
            }
            $str .= "<a href='/console/".$self->url."'>".$self->name."</a>";
            return $str;
        } catch (\Throwable $e) {
            return '';
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
