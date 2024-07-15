<?php
namespace App\Http\Controllers\Api\VendorDashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductsBulkUploadValidation;
use App\Http\Requests\Dashboard\ProductValidation;
use App\Http\Resources\Dashboard\ProductResource;
use App\Http\Traits\ApiResponseTrait;
use App\Imports\ProductImport;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductsController extends Controller
{
    use ApiResponseTrait;

    public function index(){
        $user = auth()->user();
        $user = $user->load('country');
        $products = Product::where('country_id', $user->country->id)
                           ->with('variants','brand','categories')
                           ->latest();
        $products = $products->simplepaginate();
        return $this->sendResponse(resource_collection(ProductResource::collection($products)));
    }

    public function store(ProductValidation $request, ProductService $productService){
        $data = $request->validated();
        $productService->createProduct($data);
        return $this->sendResponse([]);
    }

    public function update(ProductValidation $request, Product $product, ProductService $productService){
        $data = $request->validated();
        $productService->updateProduct($data, $product);
        return $this->sendResponse([]);
    }

    public function destroy(Request $request, Product $product){
        $product->delete();
        return $this->sendResponse([]);
    }

}
