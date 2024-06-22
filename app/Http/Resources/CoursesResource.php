<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $name = $request->header('lang') == 'ar' ? 'title_ar' : 'title_en';
//        $description = $request->header('lang') == 'ar' ? 'title_ar' : 'title_en';
        return [
            'id' => $this->id,
            'title' => $this->$name,
            'image' => $this->image ? url($this->image) : null,
            'is_paid' => $this->is_paid == 1 ? true : false,
            'is_paid_user' => $this->is_paid_user,
            'section' => SectionsResource::collection($this->section),
//            'video' =>  VideosResource::collection($this->videos),
        ];
    }
}
