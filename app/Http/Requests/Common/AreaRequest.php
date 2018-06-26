<?php
/*
 * @package [App\Http\Requests\Common]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 区域表请求验证
 *
 */
namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
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
            'data.areaname' => 'required|max:100',
            'data.lon' => 'required|numeric',
            'data.lat' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'data.areaname' => '名称',
            'data.lon' => '经度',
            'data.lat' => '纬度',
        ];
    }
}
