<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\LocationValidation;
use App\Http\Resources\Api\AddressResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Address;

class AddressesController extends Controller
{

    use ApiResponseTrait;

    public function fetch(){
        $user = auth()->user()->load('addresses');
        return $this->sendResponse(AddressResource::collection($user->addresses));
    }

    public function add(LocationValidation $request){
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        Address::create($data);
        return $this->sendResponse([]);
    }

    public function update(LocationValidation $request, $id){
        $data = $request->validated();
        $user = auth()->user()->load('addresses');
        $address = $user->addresses()->where('id',$id)->first();
        if(!$address){
            return $this->sendResponse(['error' => __('messages.Address is not found or not belongs to this user') ], 'fail' ,422 );
        }
       $address->update($data);
        return $this->sendResponse([]);
    }

}
