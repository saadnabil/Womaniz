<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BrandCateroryResource;
use App\Http\Resources\Api\BrandResource;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\MainCategoryResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Expert;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    use ApiResponseTrait;
    public function subCategories(Brand $brand){
        $brand->load('categories');
        return $this->sendResponse(new BrandCateroryResource($brand));
    }
}
