<?php
namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\SizeResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Category;
use App\Models\Size;

class SizesController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $sizes = Size::get();
        return $this->sendResponse(SizeResource::collection($sizes));
    }

    public function getSizesCategory(){
        $sizes = Size::get();
    }
}
