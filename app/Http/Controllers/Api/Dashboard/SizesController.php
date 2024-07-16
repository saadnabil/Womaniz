<?php
namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\SizeResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Http\Request;

class SizesController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $sizes = Size::get();
        if(request()->has('product_sub_type')){
            $sizes = $sizes->whereIn('product_sub_type',['all',request('product_sub_type')]);
        }
        return $this->sendResponse(SizeResource::collection($sizes));
    }
}
