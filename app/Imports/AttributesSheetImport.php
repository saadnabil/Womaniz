<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductVariantSku;
use App\Models\ProductColor;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AttributesSheetImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $product = Product::where('seller_sku', $row['seller_sku'])->first();

            if ($product) {
                $variantSku = ProductVariantSku::create([
                    'product_id' => $product->id,
                    'sku' => $row['sku_attribute'],
                    'price' => $row['original_price'],
                    'price_after_sale' => $row['sale_price'],
                    'discount' => $row['sale_price'] ? ((($row['original_price'] - $row['sale_price'] )* $row['sale_price'] )/ 100) : 0,
                    'stock' => $row['quantity'],
                ]);

                if (!empty($row['color'])) {
                    $color = Color::firstOrCreate(['hexa' => $row['color']]);
                    ProductColor::create([
                        'product_id' => $product->id,
                        'color_id' => $color->id,
                        'sku_id' => $variantSku->id,
                    ]);
                }

                if (!empty($row['size'])) {

                    $size = Size::where(['name_en' => $row['size']])->first();
                    if(!$size){
                        $size = Size::create([
                            'name_en' => $row['size_en'],
                            'name_ar' => $row['size_ar'],
                        ]);
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'size_id' => $size->id,
                            'sku_id' => $variantSku->id,
                        ]);
                    }else{
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'size_id' => $size->id,
                            'sku_id' => $variantSku->id,
                        ]);
                    }

                }
            }
        }
    }
}
