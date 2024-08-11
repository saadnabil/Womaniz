<?php
namespace App\Http\Controllers\Api\Dashboard;
use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\ProductImage;
class ProductImagesController extends Controller
{
    use ApiResponseTrait;
    public function destroy(ProductImage $productImage){
        FileHelper::delete_file($productImage->image);
        $productImage->delete();
        return $this->sendResponse([]);
    }
}
