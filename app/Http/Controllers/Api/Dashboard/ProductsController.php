<?php
namespace App\Http\Controllers\Api\Dashboard;
use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\ProductValidation;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
class ProductsController extends Controller
{
    use ApiResponseTrait;
    public function store(ProductValidation $request){
        $data = $request->validated();
        $data['price_after_sale'] =  $data['price'] - $data['price'] * $data['discount'] / 100;
        $images = $data['images'];
        $variants = $data['variants'];
        $categories = $data['categories'];
        unset($data['images']);
        unset($data['variants']);
        unset($data['categories']);
        if(isset($data['jewellery_type'])){
            unset($data['jewellery_type']);
        }
        $data['thumbnail'] = FileHelper::upload_file('products',$data['thumbnail']);
        $product = Product::create($data);
        foreach( $variants as $variant){
            ProductVariant::create([
                'product_id' => $product->id,
                'size_id' => $variant['size_id'],
                'stock' => $variant['stock'],
            ]);
        }
        foreach( $images as $image){
            $imagename = FileHelper::upload_file('products', $image);
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $imagename,
            ]);
            ProductVariant::create([
                'product_id' => $product->id,
                'size_id' => $variant['size_id'],
                'stock' => $variant['stock'],
            ]);
        }
        foreach( $categories as $category){
            CategoryProduct::create([
                'product_id' => $product->id,
                'category_id' => $category['id'],
            ]);
        }
        return $this->sendResponse([]);
    }
}
