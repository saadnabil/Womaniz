<?php
namespace App\Http\Controllers\Api\Dashboard;
use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ImageValidation;
use App\Http\Requests\Dashboard\MultiImagesValidation;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImagesController extends Controller
{
    use ApiResponseTrait;

    public function uploadimages(MultiImagesValidation $request, Product $product){
        $data = $request->validated();
        foreach ($data['images'] as $image) {
            $imagename = FileHelper::upload_file('products', $image);
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $imagename,
            ]);
        }
        return $this->sendResponse([]);
    }

    public function destroy(ProductImage $productImage){
        FileHelper::delete_file($productImage->image);
        $productImage->delete();
        return $this->sendResponse([]);
    }

    public function update(ImageValidation $request,ProductImage $productImage){
        $data = $request->validated();
        $image = FileHelper::update_file('products',$data['image'],$productImage->image);
        $productImage->update([
            'image' => $image,
        ]);
        return $this->sendResponse([]);
    }
}
