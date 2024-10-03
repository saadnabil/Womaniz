<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AddProductCartValidation;
use App\Http\Requests\Api\User\ApplyCouponValidation;
use App\Http\Resources\Api\CartResource;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\ProductResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Cart;
use App\Models\CartSku;
use App\Models\Coupon;
use App\Models\Product;
use Carbon\Carbon;

class CartController extends Controller
{
    use ApiResponseTrait;

    public function cartDetails(){
        $user = auth()->user();
        $data = $user->cartData();
        return $this->sendResponse($data);
    }

    public function minusQuantity($cartId){
        $user = auth()->user();
        $cart = Cart::find($cartId);
        if(!$cart){
            return $this->sendResponse(['error' => __('messages.Cart item is not found')],'fail' , 404);
        }
        if($cart->quantity == 1){
            return $this->sendResponse(['error' => __('messages.Quantity cant be less than one')], 'fail' , 400);
        }
        $cart->update([
            'quantity' => $cart->quantity - 1,
        ]);
        $data = $user->cartData();
        return $this->sendResponse($data);
    }

    public function plusQuantity($cartId){
        $user = auth()->user();
        $cart = Cart::find($cartId);
        if(!$cart){
            return $this->sendResponse(['error' => __('messages.Cart item is not found')],'fail' , 404);
        }
        $cart->update([
            'quantity' => $cart->quantity + 1,
        ]);
        $data = $user->cartData();
        return $this->sendResponse($data);
    }

    public function remove($cartId){
        $user = auth()->user();
        $cart = Cart::find($cartId);
        if(!$cart){
            return $this->sendResponse(['error' => __('messages.Cart item is not found')],'fail' , 404);
        }
        $cart->delete();
        $data = $user->cartData();
        return $this->sendResponse($data);
    }

    public function add(AddProductCartValidation $request){
        $data = $request->validated();
        $user  =  auth()->user();

        /***trying fetch the product with sku variant or not has*/
        if(!isset($data['sku_id'])){
            $product = Product::with(['carts' => function($q) use($data){
                $q->where('product_id', $data['product_id'] )
                  ->where('user_id', auth()->user()->id );
            }])->where('id', $data['product_id'])->first();
        }else{
            $product = Product::with(['skus' => function($q) use($data){
                $q->where('id', $data['sku_id']);
            }, 'skus.color' => function($q) use ($data){
                $q->where('sku_id', $data['sku_id']);
            },'skus.variant' => function($q) use ($data) {
                $q->where('sku_id', $data['sku_id']);
            },'carts' => function($q) use ($data){
                $q->with(['skus' => function($query) use($data){
                    $query->where('sku_id', $data['sku_id'])
                        ->where('user_id', auth()->user()->id );
                }])->where('product_id',$data['product_id'])
                  ->where('user_id' ,auth()->user()->id);
            }])->where([
                'id' => $data['product_id'],
            ])->first();
        }

        if(!$product){
            return $this->sendResponse(['error' => __('messages.Product is not found')],'fail',404);
        }


        $cartExisted = $product->carts->first();
        if(!$product->carts->first()){

            /***item is not found and will be created */
            $cart = Cart::create([
                'product_id' =>  $data['product_id'] ,
                'user_id' => auth()->user()->id ,
                'quantity' => $data['quantity'],

            ]);

            if(isset($data['sku_id'])){
                CartSku::create([
                    'user_id' => auth()->user()->id,
                    'sku_id' => $data['sku_id'],
                    'product_id' =>  $data['product_id'] ,
                    'cart_id' => $cart->id
                ]);
            }

        }else{

            /***item is found and will be updated the quantity */
            $cartExisted->update([
                'quantity' =>  $cartExisted->quantity + $data['quantity']
            ]);
        }
        $data = $user->cartData();
        return $this->sendResponse($data);
    }

    public function applycoupn(ApplyCouponValidation $request){
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
        $user->update([
            'coupon_id' => $coupon->id,
        ]);
        $data = $user->cartData();
        return $this->sendResponse($data);
    }

    public function removecoupon(){
        $user = auth()->user();
        $user->update(['coupon_id' => null]);
        $data = $user->cartData();
        return $this->sendResponse($data);

    }

}
