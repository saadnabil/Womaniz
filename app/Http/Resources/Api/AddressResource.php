<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'label' => $this->label,
            'long' => $this->long,
            'lat' => $this->lat ,
            'apt_floor' => $this->apt_floor,
            'street_address' => $this->street_address,
            'map_address' => $this->map_address,
        ];
        return $data;
    }
}
