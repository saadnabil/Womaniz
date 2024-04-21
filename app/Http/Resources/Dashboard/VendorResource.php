<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
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
            'contact_name' => $this->contact_name,
            'email' => $this->email,
            'image' => $this->image ? url('storage/'. $this->image) : url('avatar.png'),
            'phone' => $this->phone,
            'hq_address' => $this->hq_address,
            'shipping_address' => $this->shipping_address,
            'commission' => $this->commission,
            'transfer_method' => $this->transfer_method,
            'bank_account_name' => $this->bank_account_name,
            'account_number' => $this->account_number,
            'swift_number' => $this->swift_number,
            'iban_number' => $this->iban_number	,
            'status' => $this->status,

        ];
        if($this->categories){
            $data['categories'] = VendorCategoryResource::collection($this->categories);
        }
        return $data;
    }
}
