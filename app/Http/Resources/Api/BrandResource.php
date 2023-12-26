<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'name_en' => $this->name_en,
            'icon' => $this->icon?  url('storage/'.$this->icon) : null,
            'categories' => CategoryResource::collection($this->categories)
       ];
    }
}
