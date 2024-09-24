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
                'contactName' => $this->contact_name,
                'email' => $this->email,
                'image' => $this->image ? url('storage/'. $this->image) : url('avatar.png'),
                'phone' => $this->phone,
                'hqAddress' => $this->hq_address ,
                'shippingAddress' => $this->shipping_address,
                'commission' => $this->commission,
                'bankAccountName' => $this->bank_account_name,
                'bankName' => $this->bank_name,
                'accountNumber' => $this->account_number,
                'swiftNumber' => $this->swift_number,
                'ibanNumber' => $this->iban_number,
                'status' => $this->status,
                'legalDocs' => url('storage/'. $this->legal_docs),
                'commercialRegistration' => url('storage/'.$this->commercial_registration) ,
                'birthdate' => $this->birthdate,
<<<<<<< HEAD
                'vatCertificate' => url('storage/'.$this->vat_certificate) ,
                /***dsds */
<<<<<<< HEAD

=======
>>>>>>> c49885901106f076e15a7a0f6f78c6ff26503c07
=======
                'vatCertificate' => url('storage/'.$this->vat_certificate),
>>>>>>> 9fb2650f566518aea2715c53965930d508c4d339
        ];

        if($this->categories){
            $data['categories'] = VendorCategoryResource::collection($this->categories);
        }
        return $data;
    }
}
