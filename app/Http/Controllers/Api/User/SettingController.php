<?php
namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ForgetPasswordUserValidation;
use App\Http\Requests\Api\User\LoginUserValidation;
use App\Http\Requests\Api\User\RegisterUserValidation;
use App\Http\Resources\Api\CountryResource;
use App\Http\Resources\Api\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Country;
use App\Models\Otp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SettingController extends Controller
{
    use ApiResponseTrait;
    public function countries(){
        $countries = Country::get();
        return $this->sendResponse(CountryResource::collection($countries));
    }
}



