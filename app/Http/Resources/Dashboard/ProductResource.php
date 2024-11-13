<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\Dashboard\ImageResource;
use App\Http\Resources\Dashboard\VariantResource;
use Carbon\Carbon;
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'desc' => $this->desc,
            'country_id' => $this->country_id,
            'country' => $this->country->country,
            'thumbnail' => $this->image,
            'price' => round($this->price),
            'price_after_sale' => round($this->price_after_sale),
            'discount' => $this->discount,
            'status' => $this->status,
            'model_id' => $this->model_id,
            'variants' => VariantResource::collection($this->variants),
            'images' => ImageResource::collection($this->images),
            'fit_size_desc' => $this->fit_size_desc,
            'ingredients_desc' => $this->ingredients_desc,
            'about_product_desc' =>  $this->about_product_desc,
            'dimension' => $this->dimension,
            'material' => $this->material,
            'chain_length' => $this->chain_length,
            'brand' => new BrandResource($this->brand),
            'categories' => CategoryResource::collection($this->categories),
            'vendor' => new VendorResource($this->vendor),
            'return_order_desc' => $this->return_order_desc,
            'ship_information_desc' => getShipInformation(),
        ];
    }
}
