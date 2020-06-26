<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'password' => 'nullable|min:3|alpha_dash|regex:#[A-ZА-Я]+#u',
            'email' => 'required|email',
            'role' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле :attribute должно быть заполненно',
            'string' => 'Поле :attribute должно быть строкой',
            'min' => 'Поле :attribute должно содержать более :min символов',
            'email' => 'Введен не корректный адрес электронной почты',
            'regex' => 'Поле должно содержать хотя бы одну заглавную букву'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'имя',
            'email' => 'эл. почта',
            'password' => 'пароль',
            'role' => 'роль'
        ];
    }
}
