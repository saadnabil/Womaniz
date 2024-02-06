<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentCardsResource extends JsonResource
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
            'card_number' => $this->card_number,
            'cardholder_name' => $this->cardholder_name,
            'expiration_month' => $this->expiration_month,
            'expiration_year' => $this->expiration_year,
            'is_default' => $this->is_default,
       ];
    }
}
