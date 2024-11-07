<?php

namespace App\Http\Resources\Api;

use App\Models\Salon;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return[
            'brands' => BrandResource::collection($this->brands),
            'childs' => MainCategoryResource::collection($this->children),
        ];


        return $data;
    }
}
