<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\Dashboard\ImageResource;
use App\Http\Resources\Dashboard\VariantResource;
use Carbon\Carbon;
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
            'id' => $this->id,
            'hexa' => $this->hexa,
            'color' => $this->color,
        ];

        return $data;
    }
}
