<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AddProductCartValidation;
use App\Http\Resources\Api\CartResource;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\ProductResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponseTrait;

    public function index(){
        $user = auth()->user()->load(['carts.product']);
        $total = 0;
        $totalSub = 0;
        $user->carts->each(function ($cart) use (&$total , &$totalSub) {
            $cart->total = $cart->quantity * $cart->product->price_after_sale; // Assuming there's a 'price' column in your 'products' table
            $cart->totalSub = $cart->quantity * ( $cart->product->price -  $cart->product->price_after_sale);
            //sum cart final
            $total += $cart->total;
            $totalSub += $cart->totalSub;
            //sum cart final
        });
        $data = [
            'total' => $total,
            'totalSub' => $totalSub,
            'details' => CartResource::collection($user->carts),
        ];
        return $this->sendResponse($data);
    }

    public function minusQuantity($cartId){
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
        return $this->index();
    }

    public function plusQuantity($cartId){
        $cart = Cart::find($cartId);
        if(!$cart){
            return $this->sendResponse(['error' => __('messages.Cart item is not found')],'fail' , 404);
        }
        $cart->update([
            'quantity' => $cart->quantity + 1,
        ]);
        return $this->index();
    }

    public function remove($cartId){
        $cart = Cart::find($cartId);
        if(!$cart){
            return $this->sendResponse(['error' => __('messages.Cart item is not found')],'fail' , 404);
        }
        $cart->delete();
        return $this->index();
    }

    public function add(AddProductCartValidation $request){
        $data = $request->validated();
        $user  =  auth()->user();
        $product = Product::where([
            'id' => $data['product_id'],
        ]);
        if(!$product){
            return $this->sendResponse(['error' => __('messages.Product is not found')],'fail',404);
        }
        Cart::firstorcreate([
            'product_id' =>  $data['product_id'] ,
            'user_id' => auth()->user()->id ,
        ]);
        return $this->index();
    }

}
