<?php
/*
 * @package [App\Http\Requests\User]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 会员组请求验证
 *
 */
namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
            'data.name' => 'required|unique:groups,name,'.$this->segment('4'),
            'data.points' => 'required|integer',
            'data.discount' => 'required|integer',
        ];
    }

    public function attributes()
    {
        return [
            'data.name' => '会员组',
            'data.points' => '所需积分',
            'data.discount' => '折扣',
        ];
    }
}
