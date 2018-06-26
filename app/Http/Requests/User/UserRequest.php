<?php
/*
 * @package [App\Http\Requests\User]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 会员请求验证
 *
 */
namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'data.username' => 'sometimes|required|min:2|max:30',
            'data.password' => 'sometimes|required|min:6|max:30',
            'data.passwords' => 'sometimes|required|min:6|max:30|confirmed',
            'data.passwords_confirmation' => 'sometimes|required',
            'data.email' => 'sometimes|required|email',
        ];
    }

    public function attributes()
    {
        return [
            'data.username' => '用户名',
            'data.password' => '密码',
            'data.passwords' => '密码',
            'data.passwords_confirmation' => '重复密码',
            'data.email' => '邮箱',
        ];
    }
}
