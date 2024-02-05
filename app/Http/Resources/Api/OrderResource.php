<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'total' => $this->total,
            'totalsub' => $this->totalsub,
            'discount' => $this->discount,
            'vat' => $this->vat,
            'shipping' => $this->shipping,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
        ];
    }
}
