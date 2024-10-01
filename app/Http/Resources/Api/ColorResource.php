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
    public function toArray($request)
    {
        $data = [
            'sku_id' => $this->sku_id,
            'id' => $this->id,
            'color_id' => $this->color_id,
            'color' => $this->color->hexa,
        ];
        return $data;
    }
}
