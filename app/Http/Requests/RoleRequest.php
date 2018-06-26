<?php
/*
 * @package [App\Http\Requests]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 角色表请求验证
 *
 */
namespace App\Http\Requests;

use App\Http\Requests\Request;


class RoleRequest extends Request
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
            'data.name' => 'required|unique:roles,name,'.$this->segment('4'),
        ];
    }

    public function attributes()
    {
        return [
            'data.name' => '角色名',
        ];
    }
}
