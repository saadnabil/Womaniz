<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AddCardValidation;
use App\Http\Resources\Api\PaymentCardsResource;
use App\Http\Resources\Api\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\PaymentCard;

class PaymentCardsController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $user = auth()->user()->load('paymentcards');
        return $this->sendResponse(PaymentCardsResource::collection($user->paymentcards));
    }

    public function delete($id){
        $user = auth()->user()->load('paymentcards');
        $paymentcard = $user->paymentcards()->where('id',$id)->first();
        if(!$paymentcard){
            return $this->sendResponse(['error' => __('messages.Card is not found or not belongs to this user') ], 'fail' ,422 );
        }
        $paymentcard->delete();
        return $this->sendResponse([]);
    }

    public function add(AddCardValidation $request){
        $user = auth()->user()->load('paymentcards');
        $data = $request->validated();

        //change cards is default in case user set this card to be default card
        if($data['is_default'] == 1){
            $user->paymentcards()->update([
                'is_default' => 0,
            ]);
        }

        PaymentCard::create([
            'user_id' => auth()->user()->id,
            'card_number' => $data['card_number'],
            'expiration_month' => $data['expiration_month'],
            'expiration_year' => $data['expiration_year'],
            'is_default' => $data['is_default'],
            'cardholder_name' => $data['cardholder_name'],
        ]);

        return $this->sendResponse([]);
    }
}
