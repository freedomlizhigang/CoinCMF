<?php
/*
 * @package [App\Http\Requests]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 管理员表请求验证
 *
 */
namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data.role_id' => 'sometimes|required',
            'data.name' => 'sometimes|required|min:5|unique:admins,name,'.$this->segment('4'),
            'data.email' => 'sometimes|required|email|unique:admins,email,'.$this->segment('4'),
            'data.password' => 'sometimes|required|confirmed|min:6|max:15|alpha_dash',
            'data.phone' => ['sometimes','required','regex:/^1[345789]\d{9}$/'],
            'data.realname' => 'sometimes|min:2|alpha_num',
            'datas.section_id' => 'sometimes|required',
        ];
    }

    public function attributes()
    {
        return [
            'data.role_id' => '角色',
            'data.name' => '用户名',
            'data.email' => '邮箱',
            'data.password' => '密码',
            'data.phone' => '手机号',
            'data.realname' => '真实姓名',
            'data.section_id' => '部门',
        ];
    }
}
