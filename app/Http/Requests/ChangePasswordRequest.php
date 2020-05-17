<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'oldPass' => [
                'required',
                'string',
                'bail',
                function ($attribute, $value, $fail) {
                    if (!\Hash::check($value, \Auth::user()->password)) {
                        $fail('Старый пароль введен не верно');
                    }
                },
                ],
            'newPass' => 'required|string|min:6|max:255|regex:#[A-ZА-Я]+#|alpha_dash|bail',
            'newPass2' => 'same:newPass'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле :attribute должно быть заполнено',
            'string' => 'Поле :attribute должно быть строкой',
            'min' => 'Поле :attribute должно быть более :min символов',
            'regex' => 'Поле :attribute должно содержать хотя бы один загланый символ',
            'alpha_dash' => 'Поле :attribute должно содержать цифры',
            'same' => 'Пароли не совпадают'
        ];
    }

    public function attributes()
    {
        return [
            'oldPass' => 'старый пароль',
            'newPass' => 'новый пароль',
            'newPass2' => 'новый пароль еще раз'
        ];
    }
}
