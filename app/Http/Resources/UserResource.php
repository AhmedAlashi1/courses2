<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'name' => $this->name,
            'image' => $this->image ? url($this->image) : null,
            'phone' => $this->phone,
            'is_verify' => $this->is_verify,
            'status' => $this->status,
            'device_token' => $this->device_token,
            'device_type' => $this->device_type,
        ];
    }
}
