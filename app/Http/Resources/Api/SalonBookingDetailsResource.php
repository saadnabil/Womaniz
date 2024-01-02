<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class SalonBookingDetailsResource extends JsonResource
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
            'day' => $this['day'],
            'time' => $this['time'],
            'service' => $this['service'],
            'price' => $this['price'],
            'price_after_sale' => $this['price_after_sale'],
            'discount' => $this['discount'],

        ];
    }
}
