<?php

namespace App\Http\Requests\Wx;

use Illuminate\Foundation\Http\FormRequest;

class WxBroadcastRequest extends FormRequest
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
            'data.type' => 'required|max:255',
            'data.m_id' => 'integer',
            'data.media_id' => 'max:255',
        ];
    }
    
    public function attributes()
    {
        return [
            'data.title' => '标题',
            'data.type' => '类型',
            'data.m_id' => '素材',
            'data.media_id' => '素材',
        ];
    }
}
