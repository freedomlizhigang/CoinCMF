<?php
/*
 * @package [App\Http\Requests\Common]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 社区请求验证
 *
 */
namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;

class CommunityRequest extends FormRequest
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
            'data.name' => 'required|max:100',
            'data.areaid1' => 'sometimes|required|integer',
            'data.areaid2' => 'sometimes|required|integer',
            'data.areaid3' => 'sometimes|required|integer',
            'data.lon' => 'required|numeric',
            'data.lat' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'data.name' => '名称',
            'data.areaid1' => '省',
            'data.areaid2' => '市',
            'data.areaid3' => '县',
            'data.lon' => '经度',
            'data.lat' => '纬度',
        ];
    }
}
