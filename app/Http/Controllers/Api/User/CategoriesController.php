<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Category;
use App\Models\Expert;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $categories = Category::where('country_id', auth()->user()->country_id)->whereNull('parent_id')->with('children','brands.categories','salons.branches.services.children','salons.branches.experts.times')->get();
        return $this->sendResponse(CategoryResource::collection($categories));
    }
}
