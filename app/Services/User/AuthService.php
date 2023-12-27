<?php
namespace App\Services\User;

use App\Http\Resources\Api\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService{
    use ApiResponseTrait;

    public function register(array $data)
    {
        if(!isset($data['otp'])){
            $code = generate_otp_function();
            create_new_otp($data['email'], $code);
            return $this->sendResponse(['code' => $code]);
        }
        $otp = Otp::where(['email' => $data['email'], 'code' => $data['otp']])->first();
        if(!$otp){
            return $this->sendResponse(['error' => __('messages.Verification code is not correct')],'fail','404');
        }
        $data['password'] = Hash::make($data['password']);
        unset($data['otp']);
        unset($data['confirmpassword']);
        $user = User::create($data);
        $user['token'] = Auth::login($user);
        $otp->delete();
        return $this->sendResponse(new UserResource($user));
    }



    public function forgetPasswordStepOne($data){
        $user = User::where('email', $data['email'])->first();
        if(!$user){
            return $this->sendResponse(['error' => __('messages.Invalid credentials. Please make sure you are registered.'), 'fail' ,404]);
        }
        $code = generate_otp_function();
        create_new_otp($data['email'], $code);
        return $this->sendResponse(['code' => $code]);
    }

    public function forgetPasswordStepTwo($data){
        $user = User::where('email', $data['email'])->first();
        if(!$user){
            return $this->sendResponse(['error' => __('messages.Invalid credentials. Please make sure you are registered.'), 'fail' ,404]);
        }
        $otp = Otp::where(['email' => $data['email'], 'code' => $data['otp']])->first();
        if(!$otp){
            return $this->sendResponse(['error' => __('messages.Verification code is not correct')],'fail','404');
        }
        return $this->sendResponse([]);
    }

    public function forgetPasswordStepThree($data){
        $user = User::where('email', $data['email'])->first();
        if(!$user){
            return $this->sendResponse(['error' => __('messages.Invalid credentials. Please make sure you are registered.'), 'fail' ,404]);
        }
        if(!isset($data['otp'])){
            $code = generate_otp_function();
            create_new_otp($data['email'], $code);
            return $this->sendResponse(['code' => $code]);
        }
        $otp = Otp::where(['email' => $data['email'], 'code' => $data['otp']])->first();
        if(!$otp){
            return $this->sendResponse(['error' => __('messages.Verification code is not correct')],'fail','404');
        }
        $user->update(['password' => Hash::make($data['password'])]);
        return $this->sendResponse([]);
    }

    public function login(array $data){
        $token = Auth::attempt(['email' => $data['email'], 'password' => $data['password']]);
        if (!$token) {
            return $this->sendResponse(['error' => __('messages.Invalid credentials. Please make sure you are registered.')] , 'fail' , 404);
        }
        $user = Auth::user();
        $user['token'] = $token;
        return $this->sendResponse(new UserResource($user));
    }

}

