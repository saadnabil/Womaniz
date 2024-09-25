<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\SalonBranchResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SalonResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image?  url('storage/'.$this->image) : null,
            // 'branches' => SalonBranchResource::collection($this->branches),
       ];
    }
}
