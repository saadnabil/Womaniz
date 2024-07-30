<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\MakeOrderValidation;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\OrderResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Expert;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    use ApiResponseTrait;

    public function pastorders(){
        $user = auth()->user()->load('orders.orderDetails.product','orders.coupon');
        return $this->sendResponse(resource_collection(OrderResource::collection($user->orders()->where('status','delivered')->simplepaginate())));
    }

    public function currentorders(){
        $user = auth()->user()->load('orders.orderDetails.product','orders.coupon');
        return $this->sendResponse(resource_collection(OrderResource::collection($user->orders()->where('status','!=','delivered')->simplepaginate())));
    }

    public function makeOrder(MakeOrderValidation $request)
    {
        $user = auth()->user()->load(['carts.product', 'appliedcoupon', 'country']);

        // Validate request data
        $data = $request->validated();

        // Check if the cart is empty
        if ($user->carts->isEmpty()) {
            return $this->sendResponse(['error' => __('messages.Your cart is empty')], 'fail', 400);
        }

        // Check the validity of the applied coupon
        $isCouponValid = checkValidAppliedCouponBeforeSubmitOrder($user->appliedcoupon, $user->country->timezone);

        if (!$isCouponValid) {
            return $this->sendResponse(['error' => __('messages.Coupon is not valid')], 'fail', 400);
        }

        $cartData = $user->cartData();

        // Create the order
        $order = Order::create([
            'user_id' => $user->id,
            'coupon_id' => $user->coupon_id,
            'country_id' => $user->country_id,
            'total' => $cartData['total'],
            'totalsub' => $cartData['totalSub'],
            'payment_card_id' => $data['payment_card_id'] ?? null,
            'address_id' => $data['address_id'],
            'discount' => $cartData['discount'],
            'vat' => $cartData['vat'],
            'shipping' => $cartData['shipping'],
        ]);

        // Create order details
        foreach ($cartData['details'] as $item) {
            OrderDetails::create([
                'order_id' => $order->id,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'price_after_sale' => $item->product->price_after_sale,
                'product_variant_id' => $item->product_variant_id,
            ]);
        }

        // Empty the cart
        $user->carts()->delete();

        // Update coupon status to 'used'
        if($user->appliedcoupon != null){
            $user->appliedcoupon->update(['status' => 'used']);
        }

        // Reset user's coupon_id
        $user->update(['coupon_id' => null]);

        return $this->sendResponse([]);
    }
}
