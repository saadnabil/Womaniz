<?php
namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\MainCategoryFormValidation;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Category;

class CategoriesController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $categories = Category::whereNull('parent_id')->where(['type' => 'app_category' , 'country_id'=> 1 /** will replace it with country id */, 'is_salon' => 0])->with('children','brands.categories')->get();
        return $this->sendResponse(CategoryResource::collection($categories));
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

    public function store(MainCategoryFormValidation $request){
        $data = $request->validated();
        if(isset($data['image'])){
            $data['image'] = FileHelper::upload_file('categories',$data['image']);
        }
        $data['type'] = 'app_category';
        $data['country_id'] = auth()->user()->country_id;
        Category::create($data);
        return $this->sendResponse([]);
    }

}
