<?php

namespace App\Http\Requests\Wx;

use Illuminate\Foundation\Http\FormRequest;

class WxMaterRequest extends FormRequest
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
            'data.name' => 'required|min:2|max:255',
            'data.type' => 'sometimes|required|max:255',
            'data.file' => 'sometimes|required|max:255',
        ];
    }
    
    public function attributes()
    {
        return [
            'data.name' => '名称',
            'data.type' => '类型',
            'data.file' => '文件',
        ];
    }
}
