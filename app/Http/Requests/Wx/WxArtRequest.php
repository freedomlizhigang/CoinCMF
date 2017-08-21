<?php

namespace App\Http\Requests\Wx;

use Illuminate\Foundation\Http\FormRequest;

class WxArtRequest extends FormRequest
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
            'data.title' => 'required|min:2|max:255',
            'data.author' => 'max:255',
            'data.digest' => 'max:255',
            'data.show_cover_pic' => 'required|in:0,1',
            'data.thumb' => 'required|max:255',
            'data.content' => 'required|min:5',
            'data.content_source_url' => 'required|url|max:255',
        ];
    }
    
    public function attributes()
    {
        return [
            'data.title' => '标题',
            'data.author' => '作者',
            'data.digest' => '描述',
            'data.show_cover_pic' => '是否封面',
            'data.thumb' => '封面',
            'data.content' => '内容',
            'data.content_source_url' => '来源',
        ];
    }
}
