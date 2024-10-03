<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\GetProductsValidation;
use App\Http\Resources\Api\ProductResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Category;
use App\Models\Product;
use App\Models\UserProduct;
use App\Services\User\ProductService;

class ProductsController extends Controller
{
    use ApiResponseTrait;
    protected $productService;

    public function __construct(ProductService $productServcie)
    {
        $this->productService = $productServcie;
    }
    public function index(GetProductsValidation $request){
        $data = $request->validated();
        $category = Category::with('products.images','products.skus.variants.size','products.country','products.skus.colors.color')->where('id', $data['category'])->first();
        // $category = Category::with('products.images','products.variants.size','products.country','products.colors.color')->where('id', $data['category'])->first();
        return $this->sendResponse(resource_collection(ProductResource::collection($category->products()->where('country_id' , auth()->user()->country_id)->latest()->simplepaginate())));
    }

    // public function show($id){
    //     $product = Product::with('colors.color','colors.sku','variants.size','variants.sku')->find($id);
    //     if(!$product){
    //         return $this->sendResponse(['error' => __('messages.Product is not found')] , 'fail' , 404);
    //     }
    //     return $this->sendResponse(new ProductResource($product));
    // }

    public function show($id){
        $product = Product::with(['skus.color.color', 'skus.variant.size','specifications'])->find($id);
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

    public function search(){
        $search = request('search');
        $products = $this->productService->search($search);
        return $this->sendResponse(resource_collection(ProductResource::collection($products)));
    }

}
