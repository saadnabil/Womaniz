<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Category;
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
            unset($data['images']);
            $data['thumbnail'] = FileHelper::upload_file('products', $data['thumbnail']);
            $data['country_id'] = auth()->user()->country_id;
            $product = Product::create($data);
            if ($images) {
                foreach ($images as $image) {
                    $imagename = FileHelper::upload_file('products', $image);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imagename,
                    ]);
                }
            }

            DB::commit();
            return $product->id;
        }catch(Exception $x){
            return [
                'error' => 'an error occured'
            ];
            DB::rollback();
        }
    }

    public function updateProduct($data, $product)
    {
        $product = $product->load( 'country', 'brand', 'categories');

        /* reset  categories */

        $product->categories()->detach();

        $data['price_after_sale'] =  $data['price'] - $data['price'] * $data['discount'] / 100;

        if (isset($data['thumbnail'])) {
            $data['thumbnail'] = FileHelper::update_file('products', $data['thumbnail'], $product->thumbnail);
        }

        $categories = $data['categories'];

        unset($data['categories']);

        $product->update($data);

        foreach ($categories as $category) {
            CategoryProduct::create([
                'product_id' => $product->id,
                'category_id' => $category['id'],
            ]);
        }

        return;
    }
}
