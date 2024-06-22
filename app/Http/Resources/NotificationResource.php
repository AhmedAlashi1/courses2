<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        Carbon::setLocale('ar');

        $currentTime = Carbon::now();

        $sendTime = Carbon::parse($this->send_at ? $this->send_at : $this->created_at);

        $formattedTime = $sendTime->diffForHumans($currentTime, [
        'syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW,
        ]);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'message' => $this->message,
            'send_at' => $formattedTime,
            'status' => $this->status,
        ];
    }
}
