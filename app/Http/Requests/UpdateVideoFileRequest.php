<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVideoFileRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:191',
            'name_ar' => 'required|string|max:191',
            'place' => 'required|array',
            'age' => 'required|array',
            'gender' => 'required|array',
            'muscles_id' => 'required|numeric',
            'repetitions' => 'required|array',
            'repetitions.level_1' => 'required|numeric',
            'repetitions.level_2' => 'required|numeric',
            'repetitions.level_3' => 'required|numeric',
            'rounds' => 'required|array',
            'rounds.level_1' => 'required|numeric',
            'rounds.level_2' => 'required|numeric',
            'rounds.level_3' => 'required|numeric',
            'weights' => 'required|array',
            'weights.level_1' => 'required|numeric',
            'weights.level_2' => 'required|numeric',
            'weights.level_3' => 'required|numeric',
            'rest_periods' => 'required|array',
            'rest_periods.level_1' => 'required|numeric',
            'rest_periods.level_2' => 'required|numeric',
            'rest_periods.level_3' => 'required|numeric',
            'estimated_calories_burn' => 'required|array',
            'estimated_calories_burn.level_1' => 'required|numeric',
            'estimated_calories_burn.level_2' => 'required|numeric',
            'estimated_calories_burn.level_3' => 'required|numeric',
        ];
    }
}
