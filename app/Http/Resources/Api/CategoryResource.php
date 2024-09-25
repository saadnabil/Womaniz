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

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image?  url('storage/'.$this->image) : null,
            'isLastLevel' => $this->children->count() > 0 ? 0 : 1,
        ];

        if($this->parent_id == null && $this->is_salon != 1 && $this->type == 'app_category'){
            $data['brands'] = BrandResource::collection($this->brands);
        }

        if($this->children->count() > 0){
            $data['childs'] = CategoryResource::collection($this->children);
        }

        return $data;
    }
}
