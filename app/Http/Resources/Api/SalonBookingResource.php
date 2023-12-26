<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class SalonBookingResource extends JsonResource
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
            'salon' => $this->salon->name,
            'branch' => $this->branch->name,
            'day' => $this->day,
            'details' => SalonBookingDetailsResource::collection($this->details),
        ];
    }
}
