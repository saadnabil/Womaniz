<?php
namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ForgetPasswordUserValidation;
use App\Http\Requests\Api\User\LoginUserValidation;
use App\Http\Requests\Api\User\RegisterUserValidation;
use App\Http\Resources\Api\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Otp;
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

    public function forgetpassword(ForgetPasswordUserValidation $request){
        $data = $request->validated();
        return $this->authService->forgetpassword($data);
    }



}



