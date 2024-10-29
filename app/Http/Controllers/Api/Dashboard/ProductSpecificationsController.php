<?php
namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductSpecificationValidation;
use App\Http\Requests\Dashboard\ProductVariantSkuValidation;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSpecification;
use App\Models\ProductVariant;
use App\Models\ProductVariantSku;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductSpecificationsController extends Controller
{
    use ApiResponseTrait;

    public function store(ProductSpecificationValidation $request){
        $data = $request->validated();
        /**validate product exist*/
        $product = Product::where([
            'id' => $data['product_id'],
            'country_id' => auth()->user()->country_id,
        ])->first();
        if(!$product){
            return $this->sendResponse(['error' => 'product is not found'], 'fail' ,'404');
        }
        $data['product_id'] = $product->id;
        ProductSpecification::create($data);
         return $this->sendResponse([]);
    }

    public function update(ProductSpecificationValidation $request, ProductSpecification $productSpecification){
        $data = $request->validated();
        $productSpecification->update($data);
        return $this->sendResponse([]);
    }

    public function destroy( ProductSpecification $productSpecification){
        $productSpecification->delete();
        return $this->sendResponse([]);
    }
}
