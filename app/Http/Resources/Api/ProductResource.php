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
            'id' => $this->id,
            'name' => $this->name,
            'desc' => $this->desc,
            'country_id' => $this->country_id,
            'country' => $this->country->country,
            'thumbnail' => $this->thumbnail?  url('storage/'.$this->thumbnail) : null,
            'is_favourite' => $this->favoritedbyusers->contains(auth()->user()),
            'price' => round($this->price),
            'price_after_sale' => round($this->price_after_sale),
            'discount' => $this->discount,
            'product_type' => $this->product_type,
            'variants' => VariantResource::collection($this->variants),
            'images' => ImageResource::collection($this->images),
            'return_order_desc' => getReturnOrderInformation(),
            'ship_information_desc' => getShipInformation(),
        ];
        if( $this->product_type == 'clothes' ){
            $data['fit_size_desc'] = $this->fit_size_desc; //clothes
        }
        return $data;
    }
}
