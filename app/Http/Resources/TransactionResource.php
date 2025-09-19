<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->type == 1){
            $title = "From" . $this->source->name;
        }elseif($this->type==2){
             $title = "To" . $this->source->name;
        }
        return [
         'trx_id'=> $this->trx_id,
         'amount'=> number_format($this->amount, 2),
         'type'=> $this->type, //1 income,2 expense
         'title'=> $title,
         'date'=> Carbon::parse($this->created_at)->format('Y-m-d H:i:s A')
        ];
    }
}
