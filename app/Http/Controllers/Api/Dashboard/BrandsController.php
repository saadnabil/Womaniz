<?php
namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BrandFormValidation;
use App\Http\Requests\Dashboard\MainCategoryFormValidation;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryBrand;

class BrandsController extends Controller
{
    use ApiResponseTrait;

    public function store(BrandFormValidation $request){
        $data = $request->validated();
        if(isset($data['image'])){
            $data['image'] = FileHelper::upload_file('categories',$data['image']);
        }
        $data['country_id'] = auth()->user()->country_id;
        $category_id = $data['category_id'];
        unset($data['category_id']);
        if(isset($data['icon'])){
            $data['icon'] = FileHelper::upload_file('brands',$data['icon']);
        }
        $brand = Brand::create($data);
        CategoryBrand::create([
            'category_id' => $category_id,
            'brand_id' => $brand->id
        ]);
        return $this->sendResponse([]);
    }

}
