<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CoursesRequest extends FormRequest
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
            'photo' => 'mimes:jpg,jpeg,png',
            'name_ar' => 'required|min:3|max:191|arabic',
//            'name_en' => 'required|min:3|max:191|english',
//            'status' => 'required|in:active,nonActive'
//            Rule::unique('courses', 'title_ar')->ignore($this->id),
//            Rule::unique('courses', 'title_en')->ignore($this->id)
        ];
    }

    public function messages(){
        return [
            'required' => __('messages.This field is required'),
            'photo.mimes' => __('messages.The type of file chosen must be an image'),
            'name_ar.min' => __('messages.The name length should be at least 3 characters'),
            'title_ar.max' => __('messages.The name length should not exceed 40 characters'),
//            'name_en.min' => __('messages.The name length should be at least 3 characters'),
//            'name_en.max' => __('messages.The name length should not exceed 40 characters'),
            'title_ar.unique' => __('messages.The Arabic name already exists. Please choose a different name.'),
//            'name_en.unique' => __('messages.The English name already exists. Please choose a different name.'),
//            'regex' => __('messages.Please enter the name in the required language'),
//            'status.in' => __('messages.the status field can only have the values "active" or "nonActive"'),
        ];
    }
}
