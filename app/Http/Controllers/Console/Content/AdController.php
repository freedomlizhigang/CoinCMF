<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2018-07-25 11:39:58
 * @Description: 广告管理
 * @LastEditors: 李志刚
 * @LastEditTime: 2021-02-27 15:54:45
 * @FilePath: /CoinCMF/app/Http/Controllers/Console/Content/AdController.php
 */

namespace App\Http\Controllers\Console\Content;

use App\Models\Content\Ad;
use App\Models\Content\Adpos;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Console\ResponseController;

class AdController extends ResponseController
{
    /**
     * 广告管理
     * @return [type] [description]
     */
    public function getList(Request $request)
    {
        try {
            $key = $request->input('key', '');
            $starttime = $request->input('starttime', '');
            $endtime = $request->input('endtime', '');
            $status = $request->input('status', '');
            $page = $request->input('page', 1);
            $size = $request->input('size', 10);
            $list = Ad::with('ad_pos')->where(function ($q) use ($key) {
                if ($key != '') {
                    $q->where('title', 'like', '%' . $key . '%');
                }
            })->where(function ($q) use ($starttime, $endtime) {
                if ($starttime != '' && $endtime != '') {
                    $q->where('created_at', '>=', $starttime)->where('created_at', '<=', $endtime);
                }
            })->where(function ($q) use ($status) {
                if ($status != '') {
                    $q->where('status', $status);
                }
            })->where('is_del', 0)->limit($size)->offset(($page - 1) * $size)->orderBy('id', 'desc')->get();
            $count = Ad::where(function ($q) use ($key) {
                if ($key != '') {
                    $q->where('title', 'like', '%$key%');
                }
            })->where(function ($q) use ($starttime, $endtime) {
                if ($starttime != '' && $endtime != '') {
                    $q->where('created_at', '>=', $starttime)->where('created_at', '<=', $endtime);
                }
            })->where(function ($q) use ($status) {
                if ($status != '') {
                    $q->where('status', $status);
                }
            })->where('is_del', 0)->count();
            $res = ['list' => $list, 'count' => $count];
            return $this->resData(200, '获取数据成功...', $res);
        } catch (\Throwable $e) {
            return $this->resData(500, '获取数据失败，请稍后再试...');
        }
    }
    // 添加广告
    public function postCreate(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'pos_id' => 'required|integer',
                'title' => 'required|max:255',
                'thumb' => 'required|max:255',
                'url' => 'required|max:255',
                'starttime' => 'required|date',
                'endtime' => 'required|date',
                'sort' => 'required|integer|min:0',
                'status' => 'required|in:0,1,true,false',
            ]);
            $attrs = array(
                'pos_id' => ' 广告位',
                'title' => '标题',
                'thumb' => '图片',
                'url' => '链接地址',
                'starttime' => '开始时间',
                'endtime' => '结束时间',
                'sort' => '排序',
                'status' => '状态',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $data = $request->all();
            $create = ['pos_id' => $data['pos_id'], 'title' => $data['title'], 'thumb' => $data['thumb'], 'url' => $data['url'], 'sort' => $data['sort'], 'status' => $data['status'] == 'true' ? 1 : 0];
            $create['starttime'] = $data['starttime'] == '' ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($data['starttime']));
            $create['endtime'] = $data['endtime'] == '' ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($data['endtime']));
            Ad::create($create);
            return $this->resData(200, '添加成功...');
        } catch (\Throwable $e) {
            return $this->resData(500, '添加失败，请稍后再试...');
        }
    }
    // 广告
    public function postDetail(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'ad_id' => 'required|integer'
            ]);
            $attrs = array(
                'ad_id' => '广告 ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $id = $request->input('ad_id');
            $ad = Ad::findOrFail($id);
            return $this->resData(200, '查询成功', $ad);
        } catch (\Throwable $e) {
            return $this->resData(500, '获取数据失败，请稍后再试...');
        }
    }
    public function postEdit(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'ad_id' => 'required|integer',
                'pos_id' => 'required|integer',
                'title' => 'required|max:255',
                'thumb' => 'required|max:255',
                'url' => 'required|max:255',
                'starttime' => 'required|date',
                'endtime' => 'required|date',
                'sort' => 'required|integer|min:0',
                'status' => 'required|in:0,1,true,false',
            ]);
            $attrs = array(
                'ad_id' => '广告 ID',
                'pos_id' => ' 广告位',
                'title' => '标题',
                'thumb' => '图片',
                'url' => '链接地址',
                'starttime' => '开始时间',
                'endtime' => '结束时间',
                'sort' => '排序',
                'status' => '状态',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $data = $request->all();
            $id = $data['ad_id'];
            $update = ['pos_id' => $data['pos_id'], 'title' => $data['title'], 'thumb' => $data['thumb'], 'url' => $data['url'], 'sort' => $data['sort'], 'status' => $data['status'] == 'true' ? 1 : 0];
            $update['starttime'] = $data['starttime'] == '' ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($data['starttime']));
            $update['endtime'] = $data['endtime'] == '' ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($data['endtime']));
            Ad::where('id', $id)->update($update);
            return $this->resData(200, '修改成功');
        } catch (\Throwable $e) {
            return $this->resData(500, '修改失败，请稍后再试...');
        }
    }
    // 删除
    public function postRemove(Request $request,$id = '')
    {
        try {
            $validator = Validator::make($request->input(), [
                'ad_id' => 'required|array'
            ]);
            $attrs = array(
                'ad_id' => '广告 ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $id = $request->input('ad_id',[]);
            Ad::whereIn('id', $id)->update(['is_del' => 1]);
            return $this->resData(200, '删除成功！');
        } catch (\Throwable $e) {
            return $this->resData(500, '删除失败，请稍后再试...');
        }
    }
    // 排序
    public function postSort(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'ad_id' => 'required|integer'
            ]);
            $attrs = array(
                'ad_id' => '广告 ID',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(400, $validator->errors()->all()[0] . '...');
            }
            $id = $request->input('ad_id');
            Ad::where('id', $id)->update(['sort' => $request->input('sort', 0)]);
            return $this->resData(200, '排序成功！');
        } catch (\Throwable $e) {
            return $this->resData(500, '排序失败，请稍后再试...');
        }
    }
}
