<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AddLocationValidation;
use App\Http\Requests\Api\User\CahngePasswordValidation;
use App\Http\Requests\Api\User\DeleteAccountValidation;
use App\Http\Requests\Api\User\UpdateProfileValidation;
use App\Http\Resources\Api\AccountDeleteResonResource;
use App\Http\Resources\Api\AddressResource;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\AccountDeletedReason;
use App\Models\AccountDeleteHistory;
use App\Models\Address;
use App\Models\Category;
use App\Services\User\ProfileService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    use ApiResponseTrait;

    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index(){
        $user = auth()->user();
        return $this->sendResponse(new UserResource($user));
    }

    public function update(UpdateProfileValidation $request ){
        $data = $request->validated();
        $user = auth()->user();
        $data['birthdate'] = Carbon::parse($data['date'])->format('Y/m/d');
        $user->update($data);
        return $this->sendResponse([]);
    }

    public function addresses(){
        $user = auth()->user()->load('addresses');
        return $this->sendResponse(AddressResource::collection($user->addresses));
    }


    public function policy(){
        $lang = app()->getLocale();
        $policy = json_decode(setting('policy') , true);
        return $this->sendResponse([
            'policy' => $policy[$lang],
        ]);
    }

    public function security(){
        $lang = app()->getLocale();
        $policy = json_decode(setting('security') , true);
        return $this->sendResponse([
            'security' => $policy[$lang],
        ]);
    }


    public function addlocation(AddLocationValidation $request){
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        Address::create($data);
        return $this->sendResponse([]);
    }

    public function changepassword(CahngePasswordValidation $request)
    {
        // Validate the request data using the rules defined in the ChangePasswordValidation class
        $data = $request->validated();
        // Get the currently authenticated user
        $user = auth()->user();
        // Check if the old password matches the user's current password
        if (!Hash::check($data['oldpassword'], $user->password)) {
            // If not, return an error response
           return $this->sendResponse(['error' => __('messages.Invalid password')], 'fail' , 422);
        }
        // Update the user's password with the new password
        $user->update([
            'password' => Hash::make($data['newpassword']),
        ]);
        return $this->sendResponse([]);
    }

    public function deleteAccount(DeleteAccountValidation $request){
        $data = $request->validated();
        $this->profileService->deleteAccount($data);
        return $this->sendResponse([]);
    }

    public function deleteAccountReasons(){
        $reasons = AccountDeletedReason::get();
        return $this->sendResponse(AccountDeleteResonResource::collection($reasons));
    }

}
