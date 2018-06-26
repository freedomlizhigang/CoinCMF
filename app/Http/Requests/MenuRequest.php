<?php
/*
 * @package [App\Http\Requests]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 菜单表请求验证
 *
 */
namespace App\Http\Requests;

use App\Http\Requests\Request;

class MenuRequest extends Request
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
            'data.name' => 'required|max:200',
            'data.url'  => 'required|unique:menus,url,'.$this->segment('4'),
            'data.sort'  => 'required|integer',
            'data.child' => 'sometimes|boolean'
        ];
    }

    public function attributes()
    {
        return [
            'data.name' => '名称',
            'data.url' => 'URL',
            'data.sort' => '排序',
        ];
    }
}
