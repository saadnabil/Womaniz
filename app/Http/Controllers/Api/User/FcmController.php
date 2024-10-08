<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AddCardValidation;
use App\Http\Requests\Api\User\AddFcmValidation;
use App\Http\Resources\Api\PaymentCardsResource;
use App\Http\Resources\Api\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Fcm;
use App\Models\PaymentCard;
use Illuminate\Http\Request;

class FcmController extends Controller
{
    use ApiResponseTrait;
    public function store(AddFcmValidation $request){
        $data = $request->validated();
        Fcm::create($data);
        return $this->sendResponse([]);
    }
}
