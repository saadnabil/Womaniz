<?php
namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BrandFormValidation;
use App\Http\Resources\Dashboard\BrandCategoryResource;
use App\Http\Resources\Dashboard\BrandCateroryResource;
use App\Http\Resources\Dashboard\BrandResource;
use App\Http\Resources\Dashboard\DataTableCategoryResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Brand;
use App\Models\CategoryBrand;

class BrandsController extends Controller
{
    use ApiResponseTrait;

    public function index(){
        $brands = Brand::where([
            'country_id' => auth()->user()->country_id,
         ])->get();
        return $this->sendResponse(BrandResource::collection($brands));
    }

    public function store(BrandFormValidation $request){
        $data = $request->validated();
        $data['country_id'] = auth()->user()->country_id;
        if(isset($data['icon'])){
            $data['icon'] = FileHelper::upload_file('brands',$data['icon']);
        }
        $brand = Brand::create($data);
        return $this->sendResponse([]);
    }

    public function update(BrandFormValidation $request, Brand $brand){
        $data = $request->validated();
        if(isset($data['icon'])){
            $data['icon'] = FileHelper::update_file('brands',$data['icon'], $brand->icon);
        };
        $brand->update($data);
        return $this->sendResponse([]);
    }

    public function destroy(Brand $brand){
        $brand->load('categories');
        $brand->categories()->delete(); // Deletes all related categories
        $brand->delete();
        return $this->sendResponse([]);
    }

    public function subCategories(Brand $brand){
        $brand->load('categories.children');
        return $this->sendResponse(DataTableCategoryResource::collection($brand->categories));
    }

}
