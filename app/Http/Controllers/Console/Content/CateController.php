<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2019-01-03 20:14:16
 * @Description: 栏目管理
 * @LastEditors: 李志刚
 * @LastEditTime: 2021-02-26 17:21:49
 * @FilePath: /CoinCMF/app/Http/Controllers/Console/Content/CateController.php
 */

namespace App\Http\Controllers\Console\Content;

use App\Http\Controllers\Console\ResponseController;
use App\Models\Content\Article;
use App\Models\Content\Cate;
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
            return $this->resData(500,'获取失败，请稍后再试！');
        }
    }
    public function getList(Request $request){
        try {
            $all = Cate::select('id','parentid','arrparentid','name','sort','type','link_flag')->orderBy('sort','asc')->orderBy('id','asc')->get();
            $tree = $this->toTree($all,'0');
            return $this->resData(200,'获取成功...', $tree);
        } catch (\Throwable $e) {
            return $this->resData(500,'获取失败，请稍后再试！');
        }
    }
    // 转成树形菜单数组
    private function toTree($data, $pid)
    {
        $tree = [];
        if (
            $data->count() > 0
        ) {
            foreach ($data as $v) {
                if (
                    $v->parentid == $pid
                ) {
                    $v = ['cate_id' => $v->id, 'name' => $v->name,'type' => $v->type,'link_flag' => $v->link_flag, 'sort' => $v->sort, '_showChildren' => true];
                    $v['children'] = $this->toTree($data, $v['cate_id']);
                    $tree[] = $v;
                }
            }
        }
        return $tree;
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
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $all = $request->all();
            $data = ['name' => $all['name'], 'parentid' => $all['parentid'], 'thumb' => $all['thumb'], 'title' => $all['title'], 'keyword' => $all['keyword'], 'describe' => $all['describe'], 'content' => $all['content'], 'link_flag' => $all['link_flag'] == 'true' ? 1 : 0, 'cate_tpl' => $all['cate_tpl'], 'art_tpl' => $all['art_tpl'], 'display' => $all['display'] == 'true' ? 1 : 0, 'type' => $all['type'] == 'true' ? 1 : 0, 'sort' => $all['sort']];
            if ($all['link_flag'] == 'true') $data['url'] = $all['url'];
            Cate::create($data);
            app('com')->updateCache(new Cate(),'cateCache',1);
            return $this->resData(200,'添加成功...');
        }catch (\Throwable $e){
            return $this->resData(500,'添加失败，请重新操作...');
        }
    }
    //详情
    public function getDetail(Request $request){
        try{
            $validator = Validator::make($request->input(),[
                'category_id'       => 'required|integer',
            ]);
            $attrs = array(
                'category_id'       => '栏目ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $id = $request->input('category_id');
            $info = Cate::find($id);
            return $this->resData(200,'获取信息成功...',$info);
        }catch (\Throwable $e){
            return $this->resData(500,'获取信息失败，请重新操作...');
        }
    }
    //编辑栏目
    public function postEdit(Request $request){
        try{
            $validator = Validator::make($request->input(), [
                'category_id'       => 'required|integer',
                'name'          => 'required|max:255',
                'keyword'       => 'max:255',
                'sort'          => 'required|integer',
            ]);
            $attrs = array(
                'category_id'       => '栏目ID',
                'name'          => '名称',
                'keyword'       => '关键字',
                'sort'          => '排序',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $id                 = $request->input('category_id');
            $all = $request->all();
            $update = ['name' => $all['name'], 'parentid' => $all['parentid'], 'thumb' => $all['thumb'], 'title' => $all['title'], 'keyword' => $all['keyword'], 'describe' => $all['describe'], 'content' => $all['content'], 'link_flag' => $all['link_flag'] == 'true' ? 1 : 0, 'cate_tpl' => $all['cate_tpl'], 'art_tpl' => $all['art_tpl'], 'display' => $all['display'] == 'true' ? 1 : 0, 'type' => $all['type'] == 'true' ? 1 : 0, 'sort' => $all['sort']];
            if ($all['link_flag'] == 'true') $update['url'] = $all['url'];
            Cate::where('id',$id)->update($update);
            app('com')->updateCache(new Cate(),'cateCache',1);
            return $this->resData(200,'编辑成功...');
        }catch (\Throwable $e){
            return $this->resData(500,'编辑失败，请重新操作...');
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
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            $id = $request->input('cate_id');
            // 先找出所有子栏目，再判断子栏目中是否有文章，如果有文章，返回错误
            $allChild = Cate::where('id',$id)->value('arrchildid');
            // 所有子栏目ID转换为集合，查看是否含有文章或者专题
            $childs = collect(explode(',',$allChild));
            $child = Article::whereIn('cate_id',$childs)->get()->count();
            if($child != 0) {
                return $this->resData(403,'请检查栏目及子栏目下是否有文章或文章...');$message = '';
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
                    return $this->resData(500,'删除失败，请重新操作...');
                }
            }
            return $this->resData(200,'删除成功，请重新操作...');
        }catch (\Throwable $e){
            return $this->resData(500,'删除失败，请重新操作...');
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
                return $this->resData(400,$validator->errors()->all()[0].'...');
            }
            Cate::where('id',$req->input('cate_id'))->update(['sort'=>$req->input('sort')]);
            return $this->resData(200,'更新排序成功...');
        } catch (\Throwable $e) {
            return $this->resData(500,'更新排序失败，请稍后再试...');
        }
    }
}
