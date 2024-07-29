<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\Dashboard\OrderDetailsResource;
use App\Models\OrderDetails;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderTableResource extends JsonResource
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
            'date' => $this->created_at->format('Y-m-d'),
            'id' => $this->id,
            'customer' => $this->user->name,
            'numberOfItems' => count($this->orderDetails),
            'total' => $this->total,
            'totalsub' => $this->totalsub,
            'discount' => $this->discount,
            'vat' => $this->vat,
            'status' => $this->status,
        ];
    }
}
