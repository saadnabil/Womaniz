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

}
