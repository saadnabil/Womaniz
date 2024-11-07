<?php

namespace App\Http\Resources\Dashboard;

use App\Models\Salon;
use Illuminate\Http\Resources\Json\JsonResource;

class DataTableCategoryResource extends JsonResource
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
            'isLastLevel' => $this->children->count() > 0 ? false : true,
            'isParent' => $this->children->count() > 0 ? true : false,
            'isChild' =>  $this->parent_id ? true : false,
            'hasProducts' => $this->products->count() > 0 ? true : false,
        ];

        return $data;
    }
}
