<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\GetProductsValidation;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\ProductResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Category;
use App\Models\Product;
use App\Models\UserProduct;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    use ApiResponseTrait;
    public function index(GetProductsValidation $request){
        $data = $request->validated();
        $category = Category::with('products.images','products.variants.size','products.country')->where('id', $data['category'])->first();
        return $this->sendResponse(resource_collection(ProductResource::collection($category->products()->where('country_id' , auth()->user()->country_id)->latest()->simplepaginate())));
    }
    public function show($id){
        $product = Product::with('images','variants.size')->find($id);
        if(!$product){
            return $this->sendResponse(['error' => __('messages.Product is not found')] , 'fail' , 404);
        }
        return $this->sendResponse(new ProductResource($product));
    }
    public function favourites(){
        $user = auth()->user()->load('favouriteproducts');
        $favouriteproducts = $user->favouriteproducts()->where('country_id', auth()->user()->country_id)->simplepaginate();
        return $this->sendResponse(resource_collection(ProductResource::collection($favouriteproducts)));
    }
    public function togglefavourites($id){
        $product = Product::with('images','variants.size')->where([
                'id' => $id,
                'country_id' => auth()->user()->country_id
        ])->first();
        if(!$product){
            return $this->sendResponse(['error' => __('messages.Product is not found')] , 'fail' , 404);
        }
        $fav = UserProduct::where([
            'user_id' => auth()->user()->id,
            'product_id' => $id,
        ])->first();
        if($fav){
            $fav->delete();
        }else{
            UserProduct::create([
                'user_id' => auth()->user()->id,
                'product_id' => $id,
            ]);
        }
        return $this->sendResponse(new ProductResource($product));
    }
}
