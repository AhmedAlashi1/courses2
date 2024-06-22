<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
            'roles' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => __('messages.This field is required'),
            'string' => __('messages.This field must be a string.'),
            'name.max' => __('messages.The name may not be greater than 50 characters.'),
            'email.email' => __('messages.Invalid email format'),
            'email.unique' => __('messages.Email already exists'),
            'password.required' => __('messages.Password is required'),
            'password.min' => __('messages.Password must be at least 6 characters'),
            'password.confirmed' => __('messages.Password confirmation does not match'),
        ];
    }
}
