<?php
/*
 * @package [App\Http\Requests\Common]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 文章请求验证
 *
 */
namespace App\Http\Requests\Common;

use App\Http\Requests\Request;

class ArtRequest extends Request
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
            'data.title' => 'required|max:255',
            'data.cate_id' => 'required|integer|not_in:0',
            'data.content' => 'required',
            'data.sort'  => 'required|integer',
            'data.publish_at'  => 'required|date',
        ];
    }
    public function attributes()
    {
        return [
            'data.cate_id' => '栏目ID',
            'data.title' => '标题',
            'data.content' => '内容',
            'data.sort' => '排序',
            'data.publish_at' => '发布日期',
        ];
    }
}
