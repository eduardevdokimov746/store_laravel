<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
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
            'category_id' => 'required|integer|exists:categories,id',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'little_specifications' => 'required|string',
            'big_specifications' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле :attribute должно быть заполненно',
            'string' => 'Поле :attribute должно быть строкой',
            'min' => 'Поле :attribute должно содержать более :min символов',
            'integer' => 'Поле :attribute должно быть числом',
            'exists' => 'Данной категории не существует',
            'numeric' => 'Поле :attribute должно быть числом'
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'название',
            'slug' => 'алиас',
            'category_id' => 'id категории',
            'price' => 'цена',
            'old_price' => 'старая цена',
            'little_specifications' => 'короткие характеристики',
            'big_specifications' => 'полная характеристика'
        ];
    }
}
