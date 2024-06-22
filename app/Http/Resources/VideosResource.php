<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $name = $request->header('lang') == 'ar' ? 'title_ar' : 'title_en';
        $description = $request->header('lang') == 'ar' ? 'description_ar' : 'description_en';
        return [
            'id' => $this->id,
            'title' => $this->$name,
            'description' => $this->$description,
            'image' => $this->image ? url($this->image) : null,
            'video' => $this->path ? $this->path : null,
            'duration' => $this->duration,
            'watching_user' => $this->watching,
        ];
    }
}
