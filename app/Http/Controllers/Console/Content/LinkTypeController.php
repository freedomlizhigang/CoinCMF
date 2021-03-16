<?php

namespace App\Http\Controllers\Console\Content;

use App\Http\Controllers\Console\ResponseController;
use App\Models\Content\Link;
use App\Models\Content\LinkType;
use Illuminate\Http\Request;
use Validator;

class LinkTypeController extends ResponseController
{
    /**
     * 友情链接分类列表
     * @return [type] [description]
     */
    public function getList(Request $request)
    {
        try {
            $key = $request->input('key', '');
            $page = $request->input('page', 1);
            $size = $request->input('size', 10);
            $list = LinkType::where(function ($q) use ($key) {
                if ($key != '') {
                    $q->where('name', 'like', '%' . $key . '%');
                }
            })->where('del_flag', 0)->limit($size)->offset(($page - 1) * $size)->orderBy('id', 'desc')->get();
            $count = LinkType::where(function ($q) use ($key) {
                if ($key != '') {
                    $q->where('name', 'like', '%$key%');
                }
            })->where('del_flag', 0)->count();
            $res = ['list' => $list, 'count' => $count];
            return $this->resData(200, '获取数据成功...', $res);
        } catch (\Throwable $e) {
            return $this->resData(500, '获取数据失败，请稍后再试...');
        }
    }
    /**
     * 添加友情链接分类
     */
    public function postCreate(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'name' => 'required|max:100',
            ]);
            $attrs = array(
                'name' => '名称',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $data = $request->all();
            $create = ['name' => $data['name']];
            LinkType::create($create);
            return $this->resData(200, '添加成功！');
        } catch (\Throwable $e) {
            return $this->resData(500, '添加失败，请稍后再试！');
        }
    }
    public function postDetail(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'linktype_id' => 'required|integer'
            ]);
            $attrs = array(
                'linktype_id' => '友情链接分类 ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $id = $request->input('linktype_id');
            $adpos = LinkType::findOrFail($id);
            return $this->resData(200, '查询成功', $adpos);
        } catch (\Throwable $e) {
            return $this->resData(500, '查询失败，请稍后再试！');
        }
    }
    public function postEdit(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'linktype_id' => 'sometimes|required|integer',
                'name' => 'required|max:100',
            ]);
            $attrs = array(
                'linktype_id' => '友情链接分类 ID',
                'name' => '名称',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $data = $request->all();
            $id = $data['linktype_id'];
            LinkType::where('id', $id)->update(['name' => $data['name']]);
            return $this->resData(200, '修改成功！');
        } catch (\Throwable $e) {
            return $this->resData(500, '修改失败，请稍后再试！');
        }
    }
    public function postRemove(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'linktype_id' => 'required|array'
            ]);
            $attrs = array(
                'linktype_id' => '友情链接分类 ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $id = $request->input('linktype_id', []);
            // 先查友情链接分类下有没有内容，没有直接删除
            if (is_null(Link::whereIn('linktype_id', $id)->first())) {
                LinkType::whereIn('id', $id)->update(['del_flag' => 1]);
                return $this->resData(200, '删除完成！');
            } else {
                return $this->resData(400, '友情链接分类下有内容，请先移除内容！');
            }
        } catch (\Throwable $e) {
            return $this->resData(500, '获取数据失败，请稍后再试...');
        }
    }
}
