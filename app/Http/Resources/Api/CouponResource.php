<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'code' => $this->code,
            'expiration_date' => $this->expiration_date,
            'discount' => (int)$this->discount,
            'country_id' => $this->country_id,
            'type' => $this->type,
            'status' => $this->status,
        ];
    }
}
