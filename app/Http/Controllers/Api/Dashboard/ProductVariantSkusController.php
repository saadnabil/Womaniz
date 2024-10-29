<?php
namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductVariantSkuValidation;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductVariant;
use App\Models\ProductVariantSku;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductVariantSkusController extends Controller
{
    use ApiResponseTrait;

    public function store(ProductVariantSkuValidation $request){
        $data = $request->validated();

        /**validate product exist*/
        $product = Product::where([
            'id' => $data['product_id'],
            'country_id' => auth()->user()->country_id,
        ])->first();
        if(!$product){
            return $this->sendResponse(['error' => 'product is not found'], 'fail' ,'404');
        }

        $productVariantSku = ProductVariantSku::create([
            'product_id' => $product->id,
            'sku' => $data['sku'],
            'stock' => $data['stock'],
            'price' => $data['price'],
            'discount' => $data['discount'],
            'price_after_sale' =>  $data['price'] - $data['price'] * $data['discount'] / 100
        ]);

        $size = Size::firstorcreate([
            'name' => $data['size'],
        ]);

        ProductVariant::create([
            'product_id' => $product->id,
            'size_id' => $size->id,
            'sku_id' => $productVariantSku->id,
        ]);

        $color = Color::firstorcreate([
            'hexa' => $data['color'],
        ]);

        ProductColor::create([
            'product_id' => $product->id,
            'color_id' =>  $color->id,
            'sku_id' => $productVariantSku->id,
        ]);
        return $this->sendResponse([]);
    }

    public function update(ProductVariantSkuValidation $request, ProductVariantSku $productVariantSku){
        $data = $request->validated();
        $productVariantSku->load('color','variant');
        /**create product variant skus */
        $productVariantSku =  $productVariantSku->update([
            'sku' => $data['sku'],
            'stock' => $data['stock'],
            'price' => $data['price'],
            'discount' => $data['discount'],
            'price_after_sale' =>  $data['price'] - $data['price'] * $data['discount'] / 100
        ]);
        return $this->sendResponse([]);
    }

    public function destroy(ProductVariantSku $productVariantSku){
        $productVariantSku->load('color','variant');
        $productVariantSku->color->delete();
        $productVariantSku->variant->delete();
        $productVariantSku->delete();
        return $this->sendResponse([]);
    }
}
