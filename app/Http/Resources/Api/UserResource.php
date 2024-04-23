<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'user' => [
                'name' => $this->name,
                'email' => $this->email,
                'birthdate' => $this->birthdate,
                'phone' => $this->phone,
                'gender' => __('messages.'.$this->gender),
                'country' => $this->country->country,
                'image' => $this->image ?  url('storage/'.$this->image) : null,
                'country_id' => $this->country_id,
                'spins' => $this->spins,
            ]
        ];
        if($this->token){
            $data['token'] = $this->token;
        };
        return $data;
    }
}
