<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $name = $request->header('lang') == 'ar' ? 'title_ar' : 'title_en';
        return [
            'id' => $this->id,
            'title' => $this->$name,
            'is_paid' => $this->is_paid == 1 ? true : false,
            'video' =>  VideosResource::collection($this->videos),
        ];
    }
}
