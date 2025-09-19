<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
         'trx_id'=> $this->trx_id,
         'ref_no'=> $this->ref_no,
         'amount'=> number_format($this->amount, 2) . 'MMK',
         'type'=> $this->type,
         'date_time'=> Carbon::parse($this->created_at)->format('Y-m-d H:i:s A'),
         'source'=> $this->source? $this->source->name : '',
        ];
    }
}
