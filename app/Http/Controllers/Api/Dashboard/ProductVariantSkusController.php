<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\MultiSkusUploadValidation;
use App\Http\Requests\Dashboard\ProductVariantSkuValidation;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductVariant;
use App\Models\ProductVariantSku;
use App\Models\Size;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductVariantSkusController extends Controller
{
    use ApiResponseTrait;

    public function storeV1(ProductVariantSkuValidation $request)
    {
        $data = $request->validated();

        /**validate product exist*/
        $product = Product::where([
            'id' => $data['product_id'],
            'country_id' => auth()->user()->country_id,
        ])->first();
        if (!$product) {
            return $this->sendResponse(['error' => 'product is not found'], 'fail', '404');
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

    public function store(MultiSkusUploadValidation $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            /**validate product exist*/
            $product = Product::where([
                'id' => $data['product_id'],
                'country_id' => auth()->user()->country_id,
            ])->first();

            if (!$product) {
                return $this->sendResponse(['error' => 'product is not found'], 'fail', '404');
            }

        
            foreach ($data['skus'] as $sku) {
                $productVariantSku = ProductVariantSku::create([
                    'product_id' => $product->id,
                    'sku' => $sku['sku'],
                    'stock' => $sku['stock'],
                    'price' => $sku['price'],
                    'discount' => $sku['discount'],
                    'price_after_sale' =>  $sku['price'] - $sku['price'] * $sku['discount'] / 100
                ]);

                $size = Size::firstorcreate([
                    'name' => $sku['size'],
                ]);

                ProductVariant::create([
                    'product_id' => $product->id,
                    'size_id' => $size->id,
                    'sku_id' => $productVariantSku->id,
                ]);

                $color = Color::firstorcreate([
                    'hexa' => $sku['color'],
                ]);

                ProductColor::create([
                    'product_id' => $product->id,
                    'color_id' =>  $color->id,
                    'sku_id' => $productVariantSku->id,
                ]);
            }
            DB::commit();
            return $this->sendResponse([]);
        } catch (Exception $exception) {
            return $this->sendResponse(['error' => 'an error occured'], 'fail' ,400);
            DB::rollBack();
        }
    }

    public function update(ProductVariantSkuValidation $request, ProductVariantSku $productVariantSku)
    {
        $data = $request->validated();
        $productVariantSku->load('color', 'variant');
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

    public function destroy(ProductVariantSku $productVariantSku)
    {
        $productVariantSku->load('color', 'variant');
        $productVariantSku->color->delete();
        $productVariantSku->variant->delete();
        $productVariantSku->delete();
        return $this->sendResponse([]);
    }
}
