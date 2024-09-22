<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BannerResource;
use App\Http\Resources\Api\BrandResource;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\HomeBrandResource;
use App\Http\Resources\Api\MainCategoryResource;
use App\Http\Resources\Api\ProductResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    use ApiResponseTrait;
    public function partOne(){

        $user = auth()->user();

        $banners = Banner::where('country_id',$user->country_id)->latest()->get();

        $categories = Category::whereNull('parent_id')
                                ->where([
                                    'type' => 'app_category',
                                    'country_id' => $user->country_id,
                                    'is_salon' => 0
                                ])
                                ->get();
        $brands = Brand::where([
                            'country_id' => $user->country_id,
                        ])->get();

        $superDealsProducts = Product::with('images','variants.size','country')->inRandomOrder()->take(5)->get();

        $recommendedProducts = Product::with('images','variants.size','country')->inRandomOrder()->take(5)->get();

        $data = [
            'banners' => BannerResource::collection($banners),
            'mainCategories' => MainCategoryResource::collection($categories),
            'brands' => HomeBrandResource::collection($brands),
            'recommendedProducts' => ProductResource::collection($recommendedProducts),
            'superDealsProducts' => ProductResource::collection($superDealsProducts),
        ];
        return $this->sendResponse($data);
    }

    public function lastLevelCategories(){
        $user = auth()->user();
        $lastLevelCategories = Category::where('is_salon', 0)
                                        ->where('country_id' ,$user->country_id)
                                        ->doesntHave('children')->get();
        return $this->sendResponse(MainCategoryResource::collection($lastLevelCategories));
    }

    public function partTwo(){
        $user = auth()->user();
        $products = Product::where('country_id' ,$user->country_id)
                            ->with('images','variants.size','country')
                            ->latest();
        if(request()->has('category_id')){
            $categoryId = request()->input('category_id');
            $products =  $products->whereHas('categories', function($query) use ($categoryId) {
                $query->where('category_id', $categoryId);

            });
        }
        $products = $products->simplePaginate();
        return $this->sendResponse(resource_collection(ProductResource::collection($products)));
    }
}
