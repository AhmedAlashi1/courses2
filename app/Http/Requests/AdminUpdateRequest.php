<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|email',
            'password' => 'nullable|string|min:6|confirmed',
            'roles' => 'required',
            Rule::unique('admins', 'email')->ignore($this->id),
        ];
    }

    /**
     * Get the validation error messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => __('messages.This field is required'),
            'string' => __('messages.This field must be a string.'),
            'name.max' => __('messages.The name may not be greater than 50 characters.'),
            'email.email' => __('messages.Invalid email format.'),
            'email.max' => __('messages.The name may not be greater than 255 characters.'),
            'email.unique' => __('messages.The email has already been taken.'),
            'password.min' => __('messages.The password must be at least :min characters.', ['min' => 6]),
            'password.confirmed' => __('messages.The password confirmation does not match.'),
        ];
    }
}
