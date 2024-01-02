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
            'expert' => $this['expert']['name'],
            'image' => url('storage/'. $this['expert']['image']),
            'day' => $this['bookings'][0]['day'],
            'details' => SalonBookingDetailsResource::collection($this['bookings']),
        ];
    }
}
