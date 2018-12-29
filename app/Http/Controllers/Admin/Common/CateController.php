<?php
/*
 * @package [App\Http\Controllers\Admin\Common]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 栏目管理
 *
 */
namespace App\Http\Controllers\Admin\Common;

use App\Customize\Func;
use App\Http\Controllers\Controller;
use App\Http\Requests\Common\CateRequest;
use App\Models\Coin\Workflow;
use App\Models\Common\Article;
use App\Models\Common\Cate;
use DB;
use Illuminate\Http\Request;

class CateController extends Controller
{
    /**
     * 栏目列表
     * @return [type] [description]
     */
    public function getIndex()
    {
        try {
        	$title = '栏目管理';
            // 超级管理员可查看所有部门下栏目
            $all = Cate::orderBy('sort','asc')->get();
            $tree = app('com')->toTree($all,'0');
        	$treeHtml = $this->toTreeHtml($tree);
        	return view('admin.console.cate.index',compact('title','treeHtml'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    // 树形菜单 html
    private function toTreeHtml($tree)
    {
        try {
            $html = '';
            if (is_array($tree)) {
                foreach ($tree as $v) {
                    // 用level判断层级，最好不要超过四层，样式中只写了四级
                    $cj = count(explode(',', $v['arrparentid']));
                    $level = $cj > 4 ? 4 : $cj;
                    $typename = $v['type'] ? "<span class='text-success'>栏目</span>" : "<span class='text-primary'>单页</span>";
                    $display = $v['display'] ? "<span class='text-success'>显示</span>" : "<span class='text-warning'>隐藏</span>";
                    $html .= "<tr>
                        <td>".$v['sort']."</td>
                        <td>".$v['id']."</td>
                        <td><span class='level-".$level."'></span>".$v['name']."</td>
                        <td>".$typename."</td>
                        <td>".$display."</td>
                        <td><a href='/console/cate/add/".$v['id']."' class='btn btn-xs btn-primary glyphicon glyphicon-plus'></a> <a href='/console/cate/edit/".$v['id']."' class='btn btn-xs btn-info glyphicon glyphicon-edit'></a> <a href='/console/cate/del/".$v['id']."' class='btn btn-xs btn-danger glyphicon glyphicon-trash confirm'></a></td>
                        </tr>";
                    if ($v['parentid'] != '')
                    {
                        $html .= $this->toTreeHtml($v['parentid']);
                    }
                }
            }
            return $html;
        } catch (\Throwable $e) {
            return '';
        }
    }
    // 更新缓存
    public function getCache()
    {
        try {
            app('com')->updateCache(new Cate(),'cateCache',1);
            return back()->with('message', '更新栏目缓存成功！');
        } catch (\Throwable $e) {
            return back()->with('message', '更新栏目缓存失败！');
        }
    }
    /**
     * 添加栏目
     * @param  integer $pid [父栏目ID]
     * @return [type]       [description]
     */
    public function getAdd($pid = '0')
    {
        try {
        	$title = '添加栏目';
            $workflow = Workflow::get();
        	return view('admin.console.cate.add',compact('title','pid','workflow'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postAdd(CateRequest $res,$pid = '0')
    {
        // 开启事务
        DB::beginTransaction();
        try {
            $data = $res->input('data');
            $data['url'] = Func::createUuid();
            $resId = Cate::create($data);
            // 后台用户组权限
            app('com')->updateCache(new Cate(),'cateCache',1);
            // 没出错，提交事务
            DB::commit();
            return $this->adminJson(1,'添加成功',url('/console/cate/index'));
        } catch (\Throwable $e) {
            // 出错回滚
            DB::rollBack();
            return $this->adminJson(0,'添加失败，请稍后再试！');
        }
    }
    /**
     * 修改栏目
     * @param  string $id [要修改的栏目ID]
     * @return [type]     [description]
     */
    public function getEdit($id = '')
    {
        try {
            $title = '修改栏目';
            $info = Cate::findOrFail($id);
            // 超级管理员可查看所有部门下栏目
            $all = Cate::orderBy('sort','asc')->get();
            $tree = app('com')->toTree($all,'0');
            $treeHtml = app('com')->toTreeSelect($tree,$info->parentid);
            $workflow = Workflow::get();
            return view('admin.console.cate.edit',compact('title','info','treeHtml','workflow'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postEdit(CateRequest $res,$id = '')
    {
        // 开启事务
        DB::beginTransaction();
        try {
            $data = $res->input('data');
            Cate::where('id',$id)->update($data);
            $update = ['tpl'=>$data['art_tpl']];
            if ($data['workflow_id'] == 0) {
                $update['status'] = 99;
                Article::where('cate_id',$id)->update($update);
            }
            else
            {
                // 重新审批，从第一个开始
                $update['status'] = 1;
                Article::where('cate_id',$id)->whereIn('status',[2,3,4])->update($update);
            }
            // 更新缓存
            app('com')->updateCache(new Cate(),'cateCache',1);
            // 没出错，提交事务
            DB::commit();
            return $this->adminJson(1,'修改成功！',url('/console/cate/index'));
        } catch (\Throwable $e) {
            // 出错回滚
            DB::rollBack();
            return $this->adminJson(0,'修改失败，请稍后再试！');
        }
    }
    public function getDel($id)
    {
        try {
            // 先找出所有子栏目，再判断子栏目中是否有文章，如果有文章，返回错误
            $allChild = Cate::where('id',$id)->value('arrchildid');
            // 所有子栏目ID转换为集合，查看是否含有文章或者专题
            $childs = collect(explode(',',$allChild));
            $child = Article::whereIn('catid',$childs)->get()->count();
            if($child != 0)
            {
                $message = '请检查栏目及子栏目下是否有文章或文章！';
            }
            else
            {
                // 开启事务
                DB::beginTransaction();
                try {
                    Cate::destroy($childs);
                    $message = '删除成功！';
                    // 更新缓存
                    app('com')->updateCache(new Cate(),'cateCache',1);
                    // 没出错，提交事务
                    DB::commit();
                } catch (\Throwable $e) {
                    // 出错回滚
                    DB::rollBack();
                    return back()->with('message','删除失败，请稍后再试！');
                }
            }
            return back()->with('message', $message);
        } catch (\Throwable $e) {
            return back()->with('message', '删除失败，请稍后再试！');
        }
    }
}
