<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::guard('admin_custom')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:3',
            'slug' => 'nullable|string',
            'parent_id' => 'required|integer|exists:categories,parent_id',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле :attribute должно быть заполненно',
            'string' => 'Поле :attribute должно быть строкой',
            'min' => 'Поле :attribute должно содержать более :min символов',
            'integer' => 'Поле :attribute должно быть числом',
            'exists' => 'Данной категории не существует'
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'название',
            'slug' => 'алиас',
            'parent_id' => 'родительский id',
        ];
    }
}
