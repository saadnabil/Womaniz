<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductInCartResource extends JsonResource
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
            'name' => $this->name,
            'currency' =>  $this->country->currency,
            'classification' => 'Best Seller',
            'thumbnail' => $this->thumbnail,
            'is_favourite' => $this->favoritedbyusers->contains(auth()->user()),
            // 'price' => round($this->price),
            // 'price_after_sale' => round($this->price_after_sale),
            // 'discount' => $this->discount,
        ];
        return $data;
    }
}
