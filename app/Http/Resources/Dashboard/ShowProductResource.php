<?php

namespace App\Http\Resources\Dashboard;
use App\Http\Resources\Dashboard\ImageResource;
use App\Http\Resources\Dashboard\VariantResource;
use Illuminate\Http\Resources\Json\JsonResource;
class ShowProductResource extends JsonResource
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
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'desc_en' => $this->desc_en,
            'desc_ar' => $this->desc_ar,
            'country_id' => $this->country_id,
            'country' => $this->country->country,
            'thumbnail' => $this->thumbnail?  url('storage/'.$this->thumbnail) : null,
            'price' => round($this->price),
            'price_after_sale' => round($this->price_after_sale),
            'discount' => $this->discount,
            'status' => $this->status,
            'model_id' => $this->model_id,
            'variants' => VariantResource::collection($this->variants),
            'images' => ImageResource::collection($this->images),
            'fit_size_desc_en' => $this->fit_size_desc_en,
            'fit_size_desc_ar' => $this->fit_size_desc_ar,
            'ingredients_desc_en' => $this->ingredients_desc_en,
            'about_product_desc_ar' =>  $this->about_product_desc_ar,
            'dimension' => $this->dimension,
            'material_en' => $this->material_en,
            'material_ar' => $this->material_ar,
            'chain_length' => $this->chain_length,
            'brand' => new BrandResource($this->brand),
            'categories' => CategoryResource::collection($this->categories),
            'return_order_desc' => $this->return_order_desc,
            'ship_information_desc' => getShipInformation(),
            'color' => new ColorResource($this->color),
        ];
    }
}
