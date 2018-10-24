<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModelRequest extends FormRequest
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
            'data.title' => 'sometimes|required|max:255',
            'data.tablename'  => 'sometimes|required|max:255|unique:models,tablename,'.$this->segment('4'),
            'data.describe'  => 'sometimes|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'data.title' => '名称',
            'data.tablename' => '数据表名',
            'data.describe' => '描述',
        ];
    }
}
