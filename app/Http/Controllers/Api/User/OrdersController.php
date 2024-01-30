<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Expert;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    use ApiResponseTrait;
    public function makeOrder(){
        $user = auth()->user()->load(['carts.product','appliedcoupon']);
        $cartData = $user->cartData();
        return response()->json($cartData);
        $order = Order::create([
            'user_id' => $user->id,
            'coupon_id' => $user->coupon_id,
            'country_id' => $user->country_id,
            'total' => $cartData['total'],
            'totalsub' => $cartData['totalSub'],
        ]);
        dd('success');
    }
}
