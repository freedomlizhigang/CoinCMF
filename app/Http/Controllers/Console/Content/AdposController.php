<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2018-07-25 11:39:58
 * @Description: 广告位管理
 * @LastEditors: 李志刚
 * @LastEditTime: 2021-02-27 15:59:23
 * @FilePath: /CoinCMF/app/Http/Controllers/Console/Content/AdposController.php
 */

namespace App\Http\Controllers\Console\Content;

use App\Models\Content\Ad;
use Illuminate\Http\Request;
use App\Models\Content\Adpos;
use Validator;
use App\Http\Controllers\Console\ResponseController;

class AdposController extends ResponseController
{
    /**
     * 广告位列表
     * @return [type] [description]
     */
    public function getList(Request $request)
    {
        try {
            $key = $request->input('key','');
            $page = $request->input('page', 1);
            $size = $request->input('size', 10);
            $list = AdPos::where(function ($q) use ($key) {
                if ($key != '') {
                    $q->where('name', 'like', '%' . $key . '%');
                }
            })->where('is_del', 0)->limit($size)->offset(($page - 1) * $size)->orderBy('id', 'desc')->get();
            $count = AdPos::where(function ($q) use ($key) {
                if ($key != '') {
                    $q->where('name', 'like', '%$key%');
                }
            })->where('is_del', 0)->count();
            $res = ['list' => $list, 'count' => $count];
            return $this->resData(200, '获取数据成功...', $res);
        } catch (\Throwable $e) {
            return $this->resData(500, '获取数据失败，请稍后再试...');
        }
    }
    /**
     * 添加广告位
     */
    public function postCreate(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'name' => 'required|max:100',
                'is_mobile' => 'required|in:0,1,true,false',
            ]);
            $attrs = array(
                'name' => '名称',
                'is_mobile' => '是否手机版',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $data = $request->all();
            $create = ['name' => $data['name'], 'is_mobile' => $data['is_mobile'] == 'true' ? 1 : 0];
            Adpos::create($create);
            return $this->resData(200, '添加成功！');
        } catch (\Throwable $e) {
            return $this->resData(500, '添加失败，请稍后再试！');
        }
    }
    public function postDetail(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'adpos_id' => 'required|integer'
            ]);
            $attrs = array(
                'adpos_id' => '广告位 ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $id = $request->input('adpos_id');
            $adpos = AdPos::findOrFail($id);
            return $this->resData(200, '查询成功', $adpos);
        } catch (\Throwable $e) {
            return $this->resData(500, '查询失败，请稍后再试！');
        }
    }
    public function postEdit(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'adpos_id' => 'sometimes|required|integer',
                'name' => 'required|max:100',
                'is_mobile' => 'required|in:0,1,true,false',
            ]);
            $attrs = array(
                'adpos_id' => '广告位 ID',
                'name' => '名称',
                'is_mobile' => '是否手机版',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $data = $request->all();
            $id = $data['adpos_id'];
            $update = ['name' => $data['name'], 'is_mobile' => $data['is_mobile'] == 'true' ? 1 : 0];
            Adpos::where('id',$id)->update($update);
            return $this->resData(200, '修改成功！');
        } catch (\Throwable $e) {
            return $this->resData(500, '修改失败，请稍后再试！');
        }
    }
    public function postRemove(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'adpos_id' => 'required|array'
            ]);
            $attrs = array(
                'adpos_id' => '广告位 ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $id = $request->input('adpos_id',[]);
        	// 先查广告位下有没有广告，没有直接删除
            if (is_null(Ad::whereIn('pos_id',$id)->first())) {
                Adpos::whereIn('id',$id)->delete();
                return $this->resData(200, '删除完成！');
            }
            else
            {
                return $this->resData(400, '广告位下有广告，请先移除广告！');
            }
        } catch (\Throwable $e) {
            return $this->resData(500, '获取数据失败，请稍后再试...');
        }
    }
}
