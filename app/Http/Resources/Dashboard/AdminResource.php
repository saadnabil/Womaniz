<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
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
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'image' => $this->image ? url('storage/'. $this->image) : url('avatar.png'),
                'phone' => $this->phone,
                'age' => Carbon::parse($this->birthdate)->diffInYears(Carbon::now()) ,
                'birthdate' => $this->birthdate,
                'countryId' => $this->country_id,
                'address' => $this->address,
                'status' => $this->status,
                'country' => $this->country->country,
                'role' => $this->roles->first() != null ? $this->roles->first()->name : '',
                'permissions' => $this->roles->first() != null ? $this->roles->first()->permissions->pluck('name') : [],
                'category' => 'Accounts’ management',
        ];
        if($this->token){
            $data['token'] = $this->token;
        };
        return $data;
    }
}
