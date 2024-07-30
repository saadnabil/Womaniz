<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\Dashboard\OrderDetailsResource;
use App\Models\OrderDetails;
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
            'date' => $this->created_at->format('Y-m-d'),
            'paymentMethod' => $this->payment_method,
            'numberofItems' => count($this->orderDetails),
            'user' => new UserResource($this->user),
            'orderDetails' => OrderDetailsResource::collection($this->orderDetails),
        ];
    }
}
