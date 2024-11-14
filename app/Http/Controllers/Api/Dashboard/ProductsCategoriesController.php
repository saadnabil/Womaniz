<?php

namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UpdateProductCategoriesValidation;
use App\Http\Traits\ApiResponseTrait;
use App\Models\CategoryProduct;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsCategoriesController extends Controller
{
    use ApiResponseTrait;
    public function updateCategories(UpdateProductCategoriesValidation $request, Product $product){
        $data = $request->validated();
        try{
            DB::beginTransaction();
            isset($data['status']) ? $data['status'] : 'live';
            $product->update([
                'status' => 'live',
            ]);
            foreach($data['categories'] as $category){
                CategoryProduct::firstorcreate([
                    'product_id' => $product->id,
                    'category_id' => $category,
                ]);
            }
            DB::commit();
            return $this->sendResponse([]);
        }catch(Exception $ex){
            DB::rollBack();
            return $this->sendResponse(['error' => 'An error occured !'], 'fail' , 400);
        }
       
    }
}