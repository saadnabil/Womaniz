<?php
namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;

class ProductService{

    public function createProduct($data){
        $data['price_after_sale'] =  $data['price'] - $data['price'] * $data['discount'] / 100;
        $images = $data['images'];
        $variants = $data['variants'];
        $categories = $data['categories'];
        unset($data['images']);
        unset($data['variants']);
        unset($data['categories']);
        $data['thumbnail'] = FileHelper::upload_file('products',$data['thumbnail']);
        $product = Product::create($data);
        foreach( $variants as $variant){
            ProductVariant::create([
                'product_id' => $product->id,
                'size_id' => $variant['size_id'],
                'stock' => $variant['stock'],
                'sku' => $variant['sku']
            ]);
        }
        foreach( $images as $image){
            $imagename = FileHelper::upload_file('products', $image);
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $imagename,
            ]);
        }
        foreach( $categories as $category){
            CategoryProduct::create([
                'product_id' => $product->id,
                'category_id' => $category['id'],
            ]);
        }
        return;
    }

    public function updateProduct($data,$product){

        $product = $product->load('variants','categories');

        /*reset variants and categories*/
        $product->variants()->delete();
        $product->categories()->detach();

        $data['price_after_sale'] =  $data['price'] - $data['price'] * $data['discount'] / 100;
        if(isset($data['images'])){
            foreach( $data['images'] as $image){
                $imagename = FileHelper::upload_file('products', $image);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imagename,
                ]);
            }
        }
        $variants = $data['variants'];
        $categories = $data['categories'];
        unset($data['images']);
        unset($data['variants']);
        unset($data['categories']);
        if(isset($data['thumbnail'])){
            $data['thumbnail'] = FileHelper::update_file('products',$data['thumbnail'], $product->thumbnail );
        }
        $product->update($data);

        foreach( $variants as $variant){
            ProductVariant::create([
                'product_id' => $product->id,
                'size_id' => $variant['size_id'],
                'stock' => $variant['stock'],
                'sku' => $variant['sku']
            ]);
        }

        foreach( $categories as $category){
            CategoryProduct::create([
                'product_id' => $product->id,
                'category_id' => $category['id'],
            ]);
        }
        return;
    }

}
