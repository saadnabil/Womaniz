<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'price' => $this->price,
            'price_after_sale' => $this->price_after_sale,
            'quantity' => $this->quantity,
            'product' => new ProductResource($this->product),
        ];
        return $data;
    }
}
