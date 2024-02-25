<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            'admin' => [
                'name' => $this->name,
                'email' => $this->email,
                'image' => $this->image ? url('storage/'. $this->image) : null,
            ]
        ];
        if($this->token){
            $data['token'] = $this->token;
        };
        return $data;
    }
}
