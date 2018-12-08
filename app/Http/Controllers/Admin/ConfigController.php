<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Console\Config;
use Illuminate\Http\Request;
use Cache;
use Validator;

class ConfigController extends ResponseController
{
    // 取信息
    public function getDetail()
    {
        try {
            $detail = Config::findOrFail(1);
            return $this->resData(200,'获取成功...',$detail);
        } catch (\Throwable $e) {
            return $this->resData(400,'获取失败，请稍后再试...');
        }
    }
    // 修改配置信息
    public function postEdit(Request $req)
    {
        try {
            $validator = Validator::make($req->input(), [
                'sitename' => 'required|max:200',
                'describe' => 'nullable|max:500',
                'person' => 'nullable|max:100',
                'phone' => 'nullable|regex:/^1[3456789]\d{9}$/|max:200',
                'email' => 'nullable|email|max:200',
                'address' => 'nullable|max:500',
            ]);
             $attrs = array(
                'sitename' => '项目名称',
                'describe' => '项目介绍',
                'person' => '联系人',
                'phone' => '电话',
                'email' => '邮箱',
                'address' => '地址',
            );
            $validator->setAttributeNames($attrs);
            if ($validator->fails()) {
                // 如果有错误，提示第一条
                return $this->resData(402,$validator->errors()->all()[0].'...');
            }
            $data = ['sitename'=>$req->input('sitename'),'describe'=>$req->input('describe'),'person'=>$req->input('person'),'phone'=>$req->input('phone'),'email'=>$req->input('email'),'address'=>$req->input('address')];
            Config::where('id',1)->update($data);
            return $this->resData(200,'更新成功...');
        } catch (\Throwable $e) {
            return $this->resData(400,'更新失败，请稍后再试...');
        }
    }
}
