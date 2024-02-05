<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\MakeOrderValidation;
use App\Http\Resources\Api\CategoryResource;
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

    public function getOrders(){
        $user = auth()->user()->load('orders.orderDetails');
        return response()->json($user);
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
            return $this->sendResponse(['error' => __('messages.Applied coupon is expired')], 'fail', 400);
        }

        if ($user->appliedcoupon->status == 'used') {
            return $this->sendResponse(['error' => __('messages.Applied coupon is used')], 'fail', 400);
        }

        $cartData = $user->cartData();

        // Create the order
        $order = Order::create([
            'user_id' => $user->id,
            'coupon_id' => $user->coupon_id,
            'country_id' => $user->country_id,
            'total' => $cartData['total'],
            'totalsub' => $cartData['totalSub'],
            'payment_card_id' => $data['payment_card_id'],
            'address_id' => $data['address_id'],
            'discount' => $cartData['discount'],
            'vat' => $cartData['vat'],
            'shipping' => $cartData['shipping'],
        ]);

        // Create order details
        foreach ($cartData['details'] as $item) {
            OrderDetails::create([
                'order_id' => $order->id,
                'produc_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'price_after_sale' => $item->product->price_after_sale,
            ]);
        }

        // Empty the cart
        $user->carts()->delete();

        // Update coupon status to 'used'
        $user->appliedcoupon->update(['status' => 'used']);

        // Reset user's coupon_id
        $user->update(['coupon_id' => null]);

        return $this->sendResponse([]);
    }
}
