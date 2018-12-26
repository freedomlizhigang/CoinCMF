<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ResponseController;
use App\Http\Controllers\Controller;
use App\Models\Common\Article;
use App\Models\Common\Cate;
use DB;
use Illuminate\Http\Request;
use Validator;

class CateController extends ResponseController
{
    // 取下拉框菜单
    public function getSelect()
    {
        try {
            $cates = Cate::select('id','parentid','name','sort','url')->get();
            $res = [];
            $f_cates = $cates->where('parentid',0)->all();
            // 只查三级
            foreach ($f_cates as $v) {
                // 一级
                $res[] = ['label'=>$v->name,'value'=>$v->id];
                // 二级
                $s_cates = $cates->where('parentid',$v->id)->all();
                foreach ($s_cates as $s) {
                    $res[] = ['label'=>'|- '.$s->name,'value'=>$s->id];
                    // 三级的
                    $t_cates = $cates->where('parentid',$s->id)->all();
                    foreach ($t_cates as $t) {
                        $res[] = ['label'=>'||- '.$t->name,'value'=>$t->id];
                    }
                }
            }
            return $this->resData(200,'获取成功！',$res);
        } catch (\Throwable $e) {
            return $this->resData(400,'获取失败，请稍后再试！');
        }
    }
    public function getList(Request $request){
        try {
            $all = Cate::select('id','parentid','arrparentid','name','sort')->orderBy('sort','asc')->orderBy('id','asc')->get();
            $tree = $this->toTree($all,'0');
            $list = $this->toTableTree($tree,'0');
            return $this->resData(200,'获取成功...',$list);
        } catch (\Throwable $e) {
            return $this->resData(400,'获取失败，请稍后再试！');
        }
    }
    // 转成树形数组
    private function toTree($data,$pid)
    {
        $tree = [];
        if ($data->count() > 0) {
            foreach($data as $v)
            {
                if ($v->parentid == $pid) {
                    $v = $v->toArray();
                    $v['childs'] = $this->toTree($data,$v['id']);
                    $tree[] = $v;
                }
            }
        }
        return $tree;
    }
    // 转成树形表格用的数据，这个有点坑，必须定义一个循环外的变量来返回，循环内变量会被覆盖导致数据出错
    private $res = [];
    private function toTableTree($data,$pid = 0)
    {
        if (is_null($data) || $data == '') {
            return $res;
        }
        foreach ($data as $v) {
            // 计算level
            $left = 0;
            $level = count(explode(',',$v['arrparentid']));
            $str = '';
            if($level > 1)
            {
                $str .= '|—';
                $left = 10 * $level;
            }
            $this->res[] = ['id'=>$v['id'],'name'=>$str.$v['name'],'sort'=>$v['sort'],'left'=>$left];
            if ($v['childs'] != '')
            {
                $this->toTableTree($v['childs'],$pid);
            }
        }
        return $this->res;
    }
    //添加栏目
    public function postCreate(Request $request){
       try{
            $validator = Validator::make($request->input(), [
                'name'          => 'required|max:255',
                'keyword'       => 'max:255',
                'sort'          => 'required|integer',
            ]);
            $attrs = array(
                'name'          => '名称',
                'keyword'       => '关键字',
                'sort'          => '排序',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            $data['name']       = $request->input('name');
            $data['keyword']    = $request->input('keyword');
            $data['sort']       = $request->input('sort');
            $data['parentid']   = $request->input('parentid',0);
            Cate::create($data);
            app('com')->updateCache(new Cate(),'cateCache',1);
            return $this->resData(200,'添加成功...');
        }catch (\Throwable $e){
            return $this->resData(400,'添加失败，请重新操作...');
        }
    }
    //详情
    public function getDetail(Request $request){
        try{
            $validator = Validator::make($request->input(),[
                'cate_id'       => 'required|integer',
            ]);
            $attrs = array(
                'cate_id'       => '栏目ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            $id = $request->input('cate_id');
            $info = Cate::find($id,['id','name','keyword','sort','parentid']);
            return $this->resData(200,'获取信息成功...',$info);
        }catch (\Throwable $e){
            return $this->resData(400,'获取信息失败，请重新操作...');
        }
    }
    //编辑栏目
    public function postEdit(Request $request){
        try{
            $validator = Validator::make($request->input(), [
                'cate_id'       => 'required|integer',
                'name'          => 'required|max:255',
                'keyword'       => 'max:255',
                'sort'          => 'required|integer',
            ]);
            $attrs = array(
                'cate_id'       => '栏目ID',
                'name'          => '名称',
                'keyword'       => '关键字',
                'sort'          => '排序',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            $data['name']       = $request->input('name');
            $data['keyword']    = $request->input('keyword');
            $data['sort']       = $request->input('sort');
            $data['parentid']   = $request->input('parentid',0);
            $id                 = $request->input('cate_id');
            Cate::where('id',$id)->update($data);
            app('com')->updateCache(new Cate(),'cateCache',1);
            return $this->resData(200,'编辑成功...');
        }catch (\Throwable $e){
            return $this->resData(400,'编辑失败，请重新操作...');
        }
    }
    //删除栏目
    public function postRemove(Request $request){
        try{
            $validator = Validator::make($request->input(), [
                'cate_id'       => 'required|integer',
            ]);
            $attrs = array(
                'cate_id'       => '栏目ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            $id = $request->input('cate_id');
            // 先找出所有子栏目，再判断子栏目中是否有文章，如果有文章，返回错误
            $allChild = Cate::where('id',$id)->value('arrchildid');
            // 所有子栏目ID转换为集合，查看是否含有文章或者专题
            $childs = collect(explode(',',$allChild));
            $child = Article::whereIn('cate_id',$childs)->get()->count();
            if($child != 0) {
                return $this->resData(402,'请检查栏目及子栏目下是否有文章或文章...');$message = '';
            }else {
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
                    return $this->resData(400,'删除失败，请重新操作...');
                }
            }
            return $this->resData(200,'删除成功，请重新操作...');
        }catch (\Throwable $e){
            return $this->resData(400,'删除失败，请重新操作...');
        }
    }
    // 排序
    public function postSort(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'cate_id' => 'required|integer',
                'sort' => 'required|integer|min:0',
            ]);
             $attrs = array(
                'cate_id' => '分类ID',
                'sort' => '排序',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            Cate::where('id',$req->input('cate_id'))->update(['sort'=>$req->input('sort')]);
            return $this->resData(200,'更新排序成功...');
        } catch (\Throwable $e) {
            return $this->resData(400,'更新排序失败，请稍后再试...');
        }
    }
}
