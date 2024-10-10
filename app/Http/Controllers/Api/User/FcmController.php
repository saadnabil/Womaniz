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
use Kreait\Laravel\Firebase\Facades\Firebase;


class FcmController extends Controller
{
    use ApiResponseTrait;
    public function store(AddFcmValidation $request){
        $data = $request->validated();
        Fcm::create($data);
        return $this->sendResponse([]);
    }



    public function testnotification(){
        $device_token = 'cprQhILiTIehG2Zu7699Rb:APA91bGdXTPe0Z3ykRnMM9FQuLsS0nml84DFfko9c3F8y4RYoKmffS_ptg9HXYeq8TDcqwF6fZg_Pki0OTjc8sVfQ35vNA_c8NQbo3pWODBcpdLL5aqZqNLA1N4Rp-4LEutASdDHrIly';
        $title = 'Test Notication';
        $body = 'Body';
        $result = sendFCM($device_token,$title,$body);
        return ($result);
    }
}
