<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class SalonBranchServicesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data =  [
            'id' => $this->id,
            'name' => $this->name,
        ];
        if($this->parent_id != null){
            $data['price'] = $this->price;
            $data['price_after_sale'] = $this->price_after_sale;
            $data['discount'] = $this->discount;
        }
        if($this->parent_id == null){
            $data['children'] = SalonBranchServicesResource::collection($this->children);
        }
        return $data;
    }
}
