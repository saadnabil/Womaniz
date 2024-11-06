<?php

namespace App\Http\Resources\Api;

use App\Models\Salon;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryCustomDataResource extends JsonResource
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
            'nameEn' => $this->name_en,
            'nameAr' => $this->name_ar,
            'image' => $this->image,
            'isLastLevel' => $this->children->count() > 0 ? 0 : 1,
            'isParent' => !$this->parent_id ? true : false,
            'isChild' =>  $this->parent_id ? true : false,
            'childs' => CategoryCustomDataResource::collection($this->children),
        ];
        return $data;
    }
}
