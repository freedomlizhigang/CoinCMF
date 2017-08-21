<?php

namespace App\Http\Requests\Wx;

use Illuminate\Foundation\Http\FormRequest;

class ReplyRequest extends FormRequest
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
            'data.msgtype' => 'required|max:255',
            'data.keyword' => 'required|max:255',
        ];
    }
    
    public function attributes()
    {
        return [
            'data.title' => '名称',
            'data.msgtype' => '消息类型',
            'data.keyword' => '关键字',
        ];
    }
}
