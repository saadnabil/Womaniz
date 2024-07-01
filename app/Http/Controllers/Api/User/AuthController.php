<?php
namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ForgetPasswordUserValidationStepOne;
use App\Http\Requests\Api\User\ForgetPasswordUserValidationStepThree;
use App\Http\Requests\Api\User\ForgetPasswordUserValidationStepTwo;
use App\Http\Requests\Api\User\LoginUserValidation;
use App\Http\Requests\Api\User\RegisterUserValidation;
use App\Http\Requests\Api\User\RestoreAccountValidation;
use App\Http\Resources\Api\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Otp;
use App\Models\RestoreAccountRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\User\AuthService;
use Carbon\Carbon;

class AuthController extends Controller
{
    use ApiResponseTrait;
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function login(LoginUserValidation $request)
    {
        $data = $request->validated();
        return $this->authService->login($data);
    }

    public function register(RegisterUserValidation $request){
        $data = $request->validated();
        return $this->authService->register($data);
    }

    public function logout()
    {
        Auth::logout();
        return $this->sendResponse([]);

    }

    public function forgetPasswordStepOne(ForgetPasswordUserValidationStepOne $request){
        $data = $request->validated();
        return $this->authService->forgetPasswordStepOne($data);
    }

    public function forgetPasswordStepTwo(ForgetPasswordUserValidationStepTwo $request){
        $data = $request->validated();
        return $this->authService->forgetPasswordStepTwo($data);
    }
    public function forgetPasswordStepThree(ForgetPasswordUserValidationStepThree $request){
        $data = $request->validated();
        return $this->authService->forgetPasswordStepThree($data);
    }

    public function restoreAccountRequest(RestoreAccountValidation $request ){
        $data = $request->validated();
        $result = $this->authService->restoreAccountRequest($data);
        if(isset($result['error'])){
            return $this->sendResponse(['error' => $result['error']], 'fail' ,422);
        }
        return $this->sendResponse([]);
    }
}



