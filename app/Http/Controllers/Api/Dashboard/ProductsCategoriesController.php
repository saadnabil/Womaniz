<?php

namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UpdateProductCategoriesValidation;
use App\Http\Traits\ApiResponseTrait;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsCategoriesController extends Controller
{
    use ApiResponseTrait;
    public function updateCategories(UpdateProductCategoriesValidation $request, Product $product){
        $data = $request->validated();
        foreach($data['categories'] as $category){
            
            CategoryProduct::firstorcreate([
                'product_id' => $product->id,
                'category_id' => $category,
            ]);
        }
        return $this->sendResponse([]);
    }
}