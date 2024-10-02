<?php

namespace App\Http\Resources\Api;

use App\Models\ProductVariant;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductChoicesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $sizes = ProductVariant::with('size')->where(['product_id' =>   $this->product_id, 'sku_id' => $this->sku_id ])->get();
        $data = [
            'color_id' => $this->id,
            'sku_id' => $this->sku_id,
            'color' => $this->color->hexa,
            'stock' => $this->sku->stock,
            'price' => $this->sku->price,
            'price_after_sale' => $this->sku->price_after_sale,
            'discount' => $this->sku->discount,
            'sizes' => SizeResource::collection($sizes),
        ];
        return $data;
    }
}
