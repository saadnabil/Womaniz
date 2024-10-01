<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class SkuResource extends JsonResource
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
            'sku' => $this->sku,
            'stock' => $this->stock,
            'price' => $this->stock,
            'price_after_sale' => $this->price_after_sale,
            'discount' => $this->discount,
            'colors' => ColorResource::collection($this->colors),
            'sizes' => SizeResource::collection($this->variants),
        ];
        return $data;
    }
}
