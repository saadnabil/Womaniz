<?php

namespace App\Http\Controllers\Api\VendorDashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorDashboard\LoginRequestValidation;
use App\Http\Resources\VendorDashboard\VendorResource;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    use ApiResponseTrait;

    public function login(LoginRequestValidation $request){
        $data = $request->validated();
        $token = auth()->guard('vendor')->attempt(['email' => $data['email'], 'password' => $data['password']]);
        if (!$token) {
            return $this->sendResponse(['error' => __('dashboard.Invalid Credintials')] , 'fail' , 404);
        }
        $vendor = Auth::guard('vendor')->user();
        $vendor = $vendor->load('categories');
        $vendor['token'] = $token;
        return $this->sendResponse(new VendorResource($vendor));
    }

    public function logout(){
        auth()->guard('vendor')->logout();
        return $this->sendResponse([]);
    }
}
