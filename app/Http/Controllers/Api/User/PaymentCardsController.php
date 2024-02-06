<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PaymentCardsResource;
use App\Http\Resources\Api\UserResource;
use App\Http\Traits\ApiResponseTrait;


class PaymentCardsController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $user = auth()->user()->load('paymentcards');
        return $this->sendResponse(PaymentCardsResource::collection($user->paymentcards));
    }
}
