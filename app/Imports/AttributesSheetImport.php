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

class AttributesSheetImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $product = Product::where('seller_sku', $row['seller_sku'])->first();

            if ($product) {
                $variantSku = ProductVariantSku::create([
                    'product_id' => $product->id,
                    'sku' => $row['sku_attribute'],
                    'price' => $row['price'],
                    'quantity' => $row['quantity'],
                ]);

                if (!empty($row['color'])) {
                    $color = Color::firstOrCreate(['name_en' => $row['color']]);
                    ProductColor::create([
                        'product_id' => $product->id,
                        'color_id' => $color->id,
                        'variant_sku_id' => $variantSku->id,
                    ]);
                }

                if (!empty($row['size'])) {
                    $size = Size::firstOrCreate(['name_en' => $row['size']]);
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size_id' => $size->id,
                        'variant_sku_id' => $variantSku->id,
                    ]);
                }
            }
        }
    }
}
