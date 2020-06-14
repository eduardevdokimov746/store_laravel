<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCommentRequest extends FormRequest
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
            'rating' => 'nullable|digits_between:0,5',
            'good_comment' => 'nullable|string|min:3',
            'bad_comment' => 'nullable|string|min:3',
            'comment' => 'required|string|min:3',
            'name' => 'required|string|regex:#^\S+\s\S+$#',
            'email' => 'required|email',
            'is_notifiable' => 'boolean'
        ];
    }
}
