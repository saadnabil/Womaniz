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
    use ApiResponseTrait;
    public function validcoupons(){
        $user = auth()->user()->load('coupons');
        $validCoupons = $user->coupons()->where('expiration_date', '>=', Carbon::now($user->country->timezone)->toDateString())->where(['status' => 'pending'])->get();
        return $this->sendResponse(CouponResource::collection($validCoupons));
    }
}
