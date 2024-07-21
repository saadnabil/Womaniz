<?php
namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductsBulkUploadValidation;
use App\Http\Requests\Dashboard\ProductValidation;
use App\Http\Resources\Dashboard\ProductResource;
use App\Http\Traits\ApiResponseTrait;
use App\Imports\ProductImport;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductsController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request){
        $user = auth()->user();
        $user = $user->load('country');
        $products = Product::where('country_id', $user->country->id)
                           ->with('variants','brand','categories')
                           ->latest();
        $search = request()->has('search') ? request('search') : null;
        if($request->has('search')){
            $products = $products->where(function($q) use($search){
                $q->where('name_en', 'like', '%'.$search.'%')
                ->orwhere('name_ar', 'like', '%'.$search.'%')
                ->orwhere('desc_en', 'like', '%'.$search.'%')
                ->orwhere('desc_ar', 'like', '%'.$search.'%')
                ->orwhere('price', 'like', '%'.$search.'%')
                ->orwhere('price_after_sale', 'like', '%'.$search.'%')
                ->orwhere('discount', 'like', '%'.$search.'%')
                ->orwhere('fit_size_desc_en', 'like', '%'.$search.'%')
                ->orwhere('fit_size_desc_ar', 'like', '%'.$search.'%')
                ->orwhere('ingredients_desc_en', 'like', '%'.$search.'%')
                ->orwhere('ingredients_desc_ar', 'like', '%'.$search.'%')
                ->orwhere('about_product_desc_en', 'like', '%'.$search.'%')
                ->orwhere('about_product_desc_ar', 'like', '%'.$search.'%')
                ->orwhere('dimension', 'like', '%'.$search.'%')
                ->orwhere('material_en', 'like', '%'.$search.'%')
                ->orwhere('material_ar', 'like', '%'.$search.'%')
                ->orwhere('chain_length', 'like', '%'.$search.'%')
                ->orwhere('product_type', 'like', '%'.$search.'%')
                ->orwhere('product_sub_type', 'like', '%'.$search.'%');
            });
        }
        if($request->has('brand_id')){
            $products =  $products->where('brand_id', request('brand_id'));
        }

        $products = $products->simplepaginate();
        return $this->sendResponse(resource_collection(ProductResource::collection($products)));
    }

    public function bulkupload(ProductsBulkUploadValidation $request){
        $data = $request->validated();
        Excel::import(new ProductImport,  $data['file']);
        return $this->sendResponse([]);
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
