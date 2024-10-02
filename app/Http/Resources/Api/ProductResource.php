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
            'country' => $this->country ?  $this->country->country : null,
            'currency' =>  $this->country->currency,
            'classification' => 'Best Seller',
            'thumbnail' => $this->thumbnail,
            'is_favourite' => $this->favoritedbyusers->contains(auth()->user()),
            'price' => round($this->price),
            'price_after_sale' => round($this->price_after_sale),
            'discount' => $this->discount,
            // 'skus' => SkuResource::collection($this->skus),
            'colors' => ColorResource::collection($this->colors),
            'sizes' => SizeResource::collection($this->variants),
            'images' => ImageResource::collection($this->images),
            'specifications' => SpecificationResource::collection($this->specifications),
        ];
        if( $this->product_type == 'clothes' ){
            $data['fit_size_desc'] = $this->fit_size_desc; //clothes
        }
        return $data;
    }
}
