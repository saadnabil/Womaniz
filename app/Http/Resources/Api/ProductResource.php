<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'desc' => $this->desc,
            'country_id' => $this->country_id,
            'thumbnail' => $this->thumbnail?  url('storage/'.$this->thumbnail) : null,
            'is_favourite' => $this->favoritedbyusers->contains(auth()->user()),
            'price' => $this->price,
            'price_after_sale' => $this->price_after_sale,
            'discount' => $this->discount,
            'variants' => VariantResource::collection($this->variants),
            'images' => ImageResource::collection($this->images),
        ];
        return $data;
    }
}
