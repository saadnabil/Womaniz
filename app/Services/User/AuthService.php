<?php
namespace App\Services\User;
use App\Http\Resources\Api\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Otp;
use App\Models\RestoreAccountRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService{
    use ApiResponseTrait;
    public function register(array $data)
    {
        if(!isset($data['otp'])){
            try{
                $request_id = sendOtp($data['phone']);
                create_new_otp($data['email'],  $request_id);

            }catch(Exception $x){
                return $this->sendResponse(['error' => 'Error occured. '. $x->getMessage() ], 'fail' ,400);
            }
        }
        $otp = Otp::where(['email' => $data['email']])->first();
        if(!$otp){
            return $this->sendResponse(['error' => __('messages.Verification code is not found')],'fail','404');
        }

        $verified = verifyOtp( $otp->request_id, $data['otp']);
        if($verified == false){
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
            return $this->sendResponse(['error' => __('messages.Invalid credentials. Please make sure you are registered.')],'fail' ,422);
        }
        $code = generate_otp_function();
        create_new_otp($data['email'], $code);
        return $this->sendResponse(['code' => $code]);
    }

    public function forgetPasswordStepTwo($data){
        $user = User::where('email', $data['email'])->first();
        if(!$user){
            return $this->sendResponse(['error' => __('messages.Invalid credentials. Please make sure you are registered.'), 'fail' ,422]);
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
            return $this->sendResponse(['error' => __('messages.Invalid credentials. Please make sure you are registered.'), 'fail' ,422]);
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
        $user = User::withTrashed()->where('email', $data['email'])->first();
        if ($user->trashed()) {
            $restoreRequest = RestoreAccountRequest::where(['email' => $data['email']])->first();
            if($restoreRequest){
                return $this->sendResponse(['error' => __('messages.Your account is deactivated. A request to restore your account has been made. Please wait for the admin to respond.')], 'fail', 422);
            }
            return $this->sendResponse(['error' => __('messages.This account has been deleted. If you want to restore it, kindly submit a request.')] , 'fail' , 403);
        }
        $token = Auth::attempt(['email' => $data['email'], 'password' => $data['password']]);
        if (!$token) {
            return $this->sendResponse(['error' => __('messages.Invalid credentials. Please make sure you are registered.')] , 'fail' , 422);
        }
        $user = Auth::user();
        $user['token'] = $token;
        return $this->sendResponse(new UserResource($user));
    }

    public function restoreAccountRequest($data){
        $user = User::withTrashed()->where('email', $data['email'])->first();
        if (!$user->trashed()) {
            return ['error' => __('messages.This account has not been deleted.')];
        }
        RestoreAccountRequest::firstOrCreate([
            'email' => $data['email'],
            'status' => 'pending',
            'user_id' => $user->id,
        ]);
        return;
    }

}

