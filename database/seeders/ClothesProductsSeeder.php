<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClothesProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i = 0 ; $i < 10 ; $i ++){
            $product =Product::create([
                'name_en' => 'Product Product',
                'name_ar' =>  'منتج منتج',
                'desc_en' => 'Product Description Product Description Product Description',
                'desc_ar' => 'وصف المنتح وصف المنتج وصف المنتج وصف المنتج',
                'thumbnail' => 'storage/fdjfjdkjfkdf.jpg',
                'price' => 120,
                'price_after_sale' => 60,
                'discount' => 50,
                'country_id' => 1,
                'product_type' => 'clothes',
                'size_id' => 1,
                'fit_size_desc_en' => 'size chart size chart size chart size chart size chart size char',
                'fit_size_desc_ar' => 'خصائص المقاس خصائص المقاس خصائص المقاس خصائص المقاس',
                'ship_information_desc_en' => 'shipping information shipping information shipping information shipping information',
                'ship_information_desc_ar' => 'خصائص الشحن خصائص الشحن خصائص الشحن',
                'return_order_desc_en' => 'return order information return order information return order information',
                'return_order_desc_ar' => 'خصائص استرجاع الاوردر خصائص استرجاع الاوردر',
            ]);



            $sizes = Size::where('title','!=', 'Default')->get();

            foreach($sizes as $size){
                ProductVariant::create([
                    'size_id' => $size->id,
                    'product_id' => $product->id,
                    'stock' => 30,
                ]);
            }

            for($x = 0; $x < 3 ; $x ++){
                ProductImage::create([
                    'image' => 'storage/kkfjdfkdkf.jpg',
                    'product_id' => $product->id,
                ]);
            }

        }

    }
}
