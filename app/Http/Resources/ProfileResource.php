<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'name'=> $this->name,
        'phone'=>$this->phone,
        'email'=>$this->email,
        'account_number'=> $this->wallet ? $this->wallet->account_number : '',
        'balance'=> $this->wallet ? number_format($this->wallet->amount ) : 0,

        ];
    }
}
