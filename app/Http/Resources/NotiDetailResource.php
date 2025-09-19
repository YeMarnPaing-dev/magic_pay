<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotiDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'title'=> $this->data['title'],
        'message'=> $this->data['message'],
        'date_time'=>Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        'deep_link'=> $this->data['deep_link'],
        ];
    }
}
