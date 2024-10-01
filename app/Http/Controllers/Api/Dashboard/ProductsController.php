<?php
namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DeleteValidation;
use App\Http\Requests\Dashboard\ProductsBulkUploadValidation;
use App\Http\Requests\Dashboard\ProductValidation;
use App\Http\Resources\Dashboard\ProductResource;
use App\Http\Resources\Dashboard\ShowProductResource;
use App\Http\Traits\ApiResponseTrait;
use App\Imports\ProductBulk;
use App\Imports\ProductsImport;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Spatie\Activitylog\Facades\LogBatch;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class ProductsController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request){
        $user = auth()->user();
        $user = $user->load('country');
        $products = Product::where('country_id', $user->country->id)
                           ->with('variants','brand','categories','vendor')
                           ->latest();
        $search = request()->has('search') ? request('search') : null;
        $mainCategoryId = $request->has('main_category_id') ? request('main_category_id') : 'all';
        if($mainCategoryId != 'all'){
            $mainCategory = Category::findOrfail($mainCategoryId);
            $childCategoriesIds = $mainCategory->getMainCategoryAllDescendantIds();
            $products = $products->whereHas('categories',function($q) use($childCategoriesIds){
                $q->whereIn('category_id', $childCategoriesIds);
            });
        }
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
                ->orwhere('chain_length', 'like', '%'.$search.'%');
            });
        }
        if($request->has('brand_id')){
            $products =  $products->where('brand_id', request('brand_id'));
        }
        if($request->has('status')){
            $products =  $products->where('status', request('status'));
        }
        $products = $products->simplepaginate();
        return $this->sendResponse(resource_collection(ProductResource::collection($products)));
    }

    public function show(Product $product){
        $product->load('variants','brand','categories','color');
        return $this->sendResponse(new ShowProductResource($product));
    }

    public function fulldataexport(){
        $user = auth()->user();
        $user = $user->load('country');
        $products = Product::where('country_id', $user->country->id)
                            ->with('variants','brand','categories')
                            ->latest()->get();
        return $this->sendResponse(ProductResource::collection($products));
    }

    public function bulkupload(ProductsBulkUploadValidation $request){
        $data = $request->validated();

        // Excel::import(new ProductImport,  $data['file']);
        $logBatch = LogBatch::startBatch();
         Excel::import(new ProductsImport,  $data['file']);
        LogBatch::endBatch($logBatch);

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

    public function delete(DeleteValidation $request,){
        $data = $request->validated();
        Product::whereIn('id',$data['ids'])->delete();
        return $this->sendResponse([]);
    }

}
