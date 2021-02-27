<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-29 08:53:47
 * @Description: 友情链接管理
 * @LastEditors: 李志刚
 * @LastEditTime: 2021-02-27 16:16:43
 * @FilePath: /CoinCMF/app/Http/Controllers/Console/Content/LinkController.php
 */

declare(strict_types=1);

namespace App\Http\Controllers\Console\Content;

use Validator;
use App\Models\Content\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Console\ResponseController;


class LinkController extends ResponseController
{
    public function getList(Request $request)
    {
        try {
            $key = $request->input('key', '');
            $page = $request->input('page', 1);
            $size = $request->input('size', 10);
            $list = Link::where(function ($q) use ($key) {
                        if ($key != '') {
                            $q->where('title', 'like', '%'.$key.'%');
                        }
                    })->where('is_del',0)->limit($size)->offset(($page - 1) * $size)->orderBy('sort', 'desc')->orderBy('id', 'desc')->get();
            $count = Link::where(function ($q) use ($key) {
                        if ($key != '') {
                            $q->where('title', 'like', '%$key%');
                        }
                    })->where('is_del', 0)->count();
            $res = ['list' => $list, 'count' => $count];
            return $this->resData(200, '获取数据成功...', $res);
        } catch (\Throwable $e) {
            return $this->resData(500, '获取数据失败，请稍后再试...');
        }
    }
    public function postCreate(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'title' => 'required|max:255',
                'thumb' => 'nullable|string|max:255',
                'url' => 'required|url|max:255',
                'sort' => 'required|integer|min:0',
                'status' => 'required|in:0,1,true,false',
            ]);
            $attrs = array(
                'title' => ' 标题',
                'thumb' => '图片',
                'url' => '链接地址',
                'sort' => '排序',
                'status' => '状态',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $data = $request->all();
            $create = ['title' => $data['title'], 'thumb' => $data['thumb'], 'url' => $data['url'], 'sort' => $data['sort'], 'status' => $data['status'] == 'true' ? 1 : 0];
            Link::create($create);
            return $this->resData(200, '添加成功！');
        } catch (\Throwable $e) {
            return $this->resData(500, '添加失败，请稍后再试！',$e->getMessage());
        }
    }
    public function postDetail(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'link_id' => 'required|integer'
            ]);
            $attrs = array(
                'link_id' => '链接 ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $id = $request->input('link_id');
            $link = Link::findOrFail($id);
            return $this->resData(200, '查询成功', $link);
        } catch (\Throwable $e) {
            return $this->resData(500, '查询失败，请稍后再试！');
        }
    }
    public function postEdit(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'link_id' => 'sometimes|required|integer',
                'title' => 'required|max:255',
                'thumb' => 'nullable|string|max:255',
                'url' => 'required|url|max:255',
                'sort' => 'required|integer|min:0',
                'status' => 'required|in:0,1,true,false',
            ]);
            $attrs = array(
                'link_id' => '链接 ID',
                'title' => ' 标题',
                'thumb' => '图片',
                'url' => '链接地址',
                'sort' => '排序',
                'status' => '状态',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $id = $request->input('link_id');
            $all = $request->all();
            $update = ['title' => $all['title'], 'thumb' => $all['thumb'], 'url' => $all['url'], 'sort' => $all['sort'], 'status' => $all['status'] == 'true' ? 1 : 0];
            Link::where('id', $id)->update($update);
            return $this->resData(200, '修改成功！');
        } catch (\Throwable $e) {
            return $this->resData(500, '修改失败，请稍后再试！');
        }
    }
    public function postRemove(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'link_id' => 'required|array'
            ]);
            $attrs = array(
                'link_id' => '链接 ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $id = $request->input('link_id',[]);
            Link::whereIn('id', $id)->update(['is_del'=>1]);
            return $this->resData(200, '删除完成！');
        } catch (\Throwable $e) {
            return $this->resData(500, '删除失败，请稍后再试');
        }
    }
    public function postSort(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'link_id' => 'required|integer'
            ]);
            $attrs = array(
                'link_id' => '链接 ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $id = $request->input('link_id');
            Link::where('id', $id)->update(['sort'=>$request->input('sort',0)]);
            return $this->resData(200, '排序成功！');
        } catch (\Throwable $e) {
            return $this->resData(500, '排序失败，请稍后再试！');
        }
    }
}
