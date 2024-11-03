<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\CategoryProduct;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use App\Models\ProductVariant;
use App\Models\ProductVariantSku;
use App\Models\Size;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductService
{

    public function createProduct($data)
    {
        DB::beginTransaction();
        try{
            $data['price_after_sale'] =  $data['price'] - $data['price'] * $data['discount'] / 100;
            $images = $data['images'] ?? null;
            $variants = $data['variants'] ?? null;
            $categories = $data['categories'];
            $specifications = $data['specifications'] ?? null;
            unset($data['images']);
            unset($data['variants']);
            unset($data['categories']);
            unset($data['specifications']);
            $data['thumbnail'] = FileHelper::upload_file('products', $data['thumbnail']);
            $data['country_id'] = auth()->user()->country_id;
            $product = Product::create($data);

            /**create product variant skus */
            if ($variants) {
                foreach ($variants as $variant) {
                    $productVariantSku = ProductVariantSku::create([
                        'product_id' => $product->id,
                        'sku' => $variant['sku'],
                        'stock' => $variant['stock'],
                        'price' => $variant['price'],
                        'discount' => $variant['discount'],
                        'price_after_sale' =>  $variant['price'] - $variant['price'] * $variant['discount'] / 100
                    ]);

                    $size = Size::firstorcreate([
                        'name' => $variant['size'],
                    ]);

                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size_id' => $size->id,
                        'sku_id' => $productVariantSku->id,
                    ]);

                    $color = Color::firstorcreate([
                        'hexa' => $variant['color'],
                    ]);

                    ProductColor::create([
                        'product_id' => $product->id,
                        'color_id' =>  $color->id,
                        'sku_id' => $productVariantSku->id,
                    ]);
                }
            }
            if ($images) {
                foreach ($images as $image) {
                    $imagename = FileHelper::upload_file('products', $image);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imagename,
                    ]);
                }
            }
            foreach ($categories as $category) {
                CategoryProduct::create([
                    'product_id' => $product->id,
                    'category_id' => $category['id'],
                ]);
            }
            if ($specifications) {
                foreach ($specifications as $specification) {
                    ProductSpecification::create([
                        'product_id' => $product->id,
                        'name_en' => $specification['name_en'],
                        'name_ar' => $specification['name_ar'],
                        'value_en' => $specification['value_en'],
                        'value_ar' => $specification['value_ar'],
                    ]);
                }
            }
            DB::commit();
            return;
        }catch(Exception $x){
            return [
                'error' => 'an error occured'
            ];
            DB::rollback();
        }

    }

    public function updateProduct($data, $product)
    {
        $product = $product->load( 'country', 'brand', 'categories', 'specifications');

        /* reset  categories - specifications   */

        $product->categories()->detach();
        $product->specifications()->delete();


        $data['price_after_sale'] =  $data['price'] - $data['price'] * $data['discount'] / 100;

        if (isset($data['thumbnail'])) {
            $data['thumbnail'] = FileHelper::update_file('products', $data['thumbnail'], $product->thumbnail);
        }
        $categories = $data['categories'];
        $specifications = $data['specifications'] ?? null;


        unset($data['categories']);
        unset($data['specifications']);

        $product->update($data);

        foreach ($categories as $category) {
            CategoryProduct::create([
                'product_id' => $product->id,
                'category_id' => $category['id'],
            ]);
        }

        if ($specifications) {
            foreach ($specifications as $specification) {
                ProductSpecification::create([
                    'product_id' => $product->id,
                    'name_en' => $specification['name_en'],
                    'name_ar' => $specification['name_ar'],
                    'value_en' => $specification['value_en'],
                    'value_ar' => $specification['value_ar'],
                ]);
            }
        }
        return;
    }
}
