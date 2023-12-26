<?php

namespace App\Http\Resources\Api;

use App\Models\SalonBranchService;
use Illuminate\Http\Resources\Json\JsonResource;

class SalonBranchResource extends JsonResource
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
            'long' => $this->long,
            'lat' => $this->lat,
            'services' => SalonBranchServicesResource::collection($this->services->where('parent_id',null)),
            'experts' => ExpertResource::collection($this->experts),
        ];
    }
}
