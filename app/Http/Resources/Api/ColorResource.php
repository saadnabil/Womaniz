<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ColorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    // public function toArray($request)
    // {
    //     $data = [
    //         'sku_id' => $this->sku_id,
    //         'id' => $this->id,
    //         'color_id' => $this->color_id,
    //         'color' => $this->color->hexa,
    //         'sku' => new SkuResource($this->sku)
    //     ];
    //     return $data;
    // }

    public function toArray($request)
    {
        $colorData = [];

        $color = $this->color->name;
        $size = $this->variant->name;

        if (!isset($colorData[$color])) {
            $colorData[$color] = [
                'color' => $color,
                'has_quantity' => false,
                'quantities' => 0,
                'sizes' => []
            ];
        }

        $colorData[$color]['sizes'][] = [
            'size' => $size,
            'sku_id' => $this->id,
            'quantity' => $this->quantity,
            'price' => $this->price
        ];

        $colorData[$color]['quantities'] += $this->quantity;

        if ($this->quantity > 0) {
            $colorData[$color]['has_quantity'] = true;
        }

        return $colorData[$color];
    }
}
