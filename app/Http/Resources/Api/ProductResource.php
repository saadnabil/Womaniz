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

        $colorsData = [];

        // Group colors with sizes
        foreach ($this->skus as $sku) {
            $color = $sku->color->color->hexa;
            $size = $sku->variant->size->name_en;

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
             //'skus' => SkuResource::collection($this->skus),
            // 'colors' => ColorResource::collection($this->colors),
            // 'sizes' => SizeResource::collection($this->variants),
            // 'colors' => ColorResource::collection($this->skus),  // Call the ColorResource for handling colors and sizes
            'colors' => $colorsArray,  // Call the ColorResource for handling colors and sizes
            'images' => ImageResource::collection($this->images),
            'specifications' => SpecificationResource::collection($this->specifications),
        ];
        return $data;
    }
}
