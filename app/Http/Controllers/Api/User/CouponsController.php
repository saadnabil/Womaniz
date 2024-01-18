<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ApplyCouponValidation;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\CouponResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Category;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    //
    use ApiResponseTrait;
    public function index(){
        $user = auth()->user()->load('validcoupons');
        return $this->sendResponse(CouponResource::collection($user->validcoupons));
    }
    public function apply(ApplyCouponValidation  $request){
        $data = $request->validated();
        $user = auth()->user()->load('country');
        $country = $user->country;
        $coupon = Coupon::where('country_id', $country->id)
                        ->where('expiration_date', '>=', Carbon::today($country->timezone))
                        ->where([
                            'user_id' =>  $user->id,
                            'code' => $data['code'],
                        ])
                        ->first();
        if(!$coupon){
            return $this->sendResponse(['error' => __('messages.Coupon not found or expired')] , 'fail', '404');
        }
        dd($coupon);
    }
}
