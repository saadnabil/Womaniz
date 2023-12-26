<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\ProductResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $products = Product::where([
                        'category_id' => request('category'),
                        'country_id' => auth()->user()->country_id
                    ])->with('images','variants.size')
                      ->latest()
                      ->simplepaginate();
        return $this->sendResponse(resource_collection(ProductResource::collection($products)));
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
}
