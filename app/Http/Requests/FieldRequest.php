<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FieldRequest extends FormRequest
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
            'data.type'  => 'sometimes|required|max:255',
            'data.title' => 'sometimes|required|max:255',
            'data.field_name'  => 'sometimes|required|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'data.type' => '类型',
            'data.title' => '名称',
            'data.field_name' => '字段名',
        ];
    }
}
