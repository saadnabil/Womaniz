<?php
namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreCategoryValidation;
use App\Http\Resources\Api\CategoryCustomDataResource;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Dashboard\ChildCategoryResource;
use App\Http\Resources\Dashboard\DataTableCategoryResource;
use App\Http\Resources\Dashboard\MainCategoryResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Category;
use App\Models\CategoryBrand;

class CategoriesController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $categories = Category::whereNull('parent_id')->where(['type' => 'app_category' , 'country_id'=> auth()->user()->country_id, 'is_salon' => 0])->with('children','brands.categories')->get();
        return $this->sendResponse(CategoryResource::collection($categories));
    }



    public function mainCategories(){
        $categories = Category::where('parent_id',null)->where([
            'type' => 'app_category' ,
            'country_id'=> auth()->user()->country_id,
            'is_salon' => 0
        ])->get();
        return $this->sendResponse(DataTableCategoryResource::collection($categories));
    }

    public function subCategories(Category $category){
        $category->load('children');
        return $this->sendResponse(DataTableCategoryResource::collection($category->children));
    }

    public function getLastChildCategoriesForParentCategory($parentCategoryId){
        $childs = $this->getLastChildCategories($parentCategoryId);
        return $this->sendResponse(CategoryResource::collection($childs));
    }

    public function getLastChildCategories($parentId)
    {
        $categories = Category::where('parent_id', $parentId)->get();
        $lastChildren = [];
        foreach ($categories as $category) {
            if ($category->children->isEmpty()) {
                $lastChildren[] = $category;
            } else {
                $lastChildren = array_merge($lastChildren, $this->getLastChildCategories($category->id));
            }
        }
        return $lastChildren;
    }

    public function store(StoreCategoryValidation $request){
        $data = $request->validated();
        if(isset($data['image'])){
            $data['image'] = FileHelper::upload_file('categories',$data['image']);
        }
        $data['type'] = 'app_category';
        $data['country_id'] = auth()->user()->country_id;
        $data['type'] = isset($data['brand_id']) ? 'brand_category' : 'app_category';
        $category = Category::create($data);
        if(isset($data['brand_id'])){
            $checkParentHasThisBrand = CategoryBrand::where([
                'category_id' => $data['parent_id'],
                'brand_id' => $data['brand_id'],
            ])->first();
            if($checkParentHasThisBrand){
                CategoryBrand::firstorcreate([
                    'category_id' => $category->id,
                    'brand_id' => $data['brand_id'],
                ]);
            }else{
                return $this->sendResponse(['error' => 'sorry, cant add this category to this brand id because parent is different'], 'fail', 400);
            }
        }
        return $this->sendResponse([]);
    }

    public function update(StoreCategoryValidation $request, Category $category){
        $data = $request->validated();
        if(isset($data['image'])){
            $data['image'] = FileHelper::update_file('categories',$data['image'],$category->image);
        }
        if(isset($data['brand_id'])){
            return $this->sendResponse(['error' => 'sorry, it is forbidden to update brand id'], 'fail', 400);
         }
        if(isset($data['parent_id'])){
           return $this->sendResponse(['error' => 'sorry, it is forbidden to update parent id'], 'fail', 400);
        }
        $category->update($data);
        return $this->sendResponse([]);
    }

    public function destroy(Category $category){
        $category->delete();
        return $this->sendResponse([]);
    }

}
