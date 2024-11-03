<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\Dashboard\ImageResource;
use App\Http\Resources\Dashboard\VariantResource;
use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

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
        $colorsData = [];
        $categoriesData = [];
        foreach ($this->categories as $category) {
            if (!isset($categoriesData[$category->parent->id])) {
                $categoriesData[$category->parent->id] = [
                    'id' => $category->parent->id,
                    'name' => $category->parent->name,
                    'image' => $category->parent->image,
                    'childs' => [],
                    'brand' => new stdClass(),
                ];
            }
            if(!$category->brand){
                $categoriesData[$category->parent->id]['childs'][] = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'image' => $category->image,

                ];
            }else{
                if(!isset( $categoriesData[$category->parent->id]['brand'])){
                    $categoriesData[$category->parent->id]['brand']->id =  $category->brand->id ;
                    $categoriesData[$category->parent->id]['brand']->name =  $category->brand->name;
                    $categoriesData[$category->parent->id]['brand']->childs = [];
                }
                $categoriesData[$category->parent->id]['brand']['childs'][] = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'image' => $category->image,
                ];
            }
        }

        // Group colors with sizes
        foreach ($this->skus as $sku) {
            $color = $sku->color->color->hexa;
            $size = $sku->variant->size->name;
            if (!isset($colorsData[$color])) {
                $colorsData[$color] = [
                    'color' => $color,
                    'has_quantity' => false,
                    'quantities' => 0,
                    'sizes' => []
                ];
            }
            // Add sizes for the color
            $colorsData[$color]['sizes'][] = [
                'size' => $size,
                'sku_id' => $sku->id,
                'quantity' => $sku->stock,
                'price' => $sku->price,
                'price_after_sale' => $sku->price_after_sale,
                'discount' => $this->discount,
            ];

            // Accumulate quantities and check if there are any available items
            $colorsData[$color]['quantities'] += $sku->stock;
            if ($sku->stock > 0) {
                $colorsData[$color]['has_quantity'] = true;
            }
        }

        // Prepare final color data array
        $colorsArray = array_values($colorsData);
        $categoriesArray = array_values($categoriesData);
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
            'specifications' => SpecificationResource::collection($this->specifications),
            'colors' => $colorsArray,  // Call the ColorResource for handling colors and sizes
            'images' => ImageResource::collection($this->images),
            'brand' => new BrandResource($this->brand),
            'categories' => $categoriesArray,
        ];
    }
}
