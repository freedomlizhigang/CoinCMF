<?php
/*
 * @package [App\Http\Requests\Common]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 栏目请求验证
 *
 */
namespace App\Http\Requests\Common;

use App\Http\Requests\Request;

class CateRequest extends Request
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
            'data.name' => 'required|max:255',
            'data.title'  => 'required|max:255',
            'data.keyword'  => 'max:255',
            'data.describe'  => 'max:255',
            'data.sort'  => 'required|integer',
        ];
    }

    public function attributes()
    {
        return [
            'data.name' => '名称',
            'data.title' => '标题',
            'data.describe' => '描述',
            'data.keyword' => '关键字',
            'data.sort' => '排序',
        ];
    }
}
