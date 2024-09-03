<?php

namespace App\Imports;

use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariantSku;
use App\Models\ProductColor;
use App\Models\ProductCategory;
use App\Models\Color; // Assuming you have a Color model
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class ProductsImport implements ToCollection, WithHeadingRow
{


    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            DB::transaction(function () use ($row) {
                // 1. Insert Product Record
                $product = Product::create([
                    'name_en' => $row['name_en'],
                    'name_ar' => $row['name_ar'],
                    'desc_en' => $row['description_en'],
                    'desc_ar' => $row['description_ar'],
                    'price' => $row['original_price'],
                    'price_after_sale' => $row['sale_price'],
                    'discount' => ($row['sale_price'] > 0 ? ((($row['original_price'] - $row['sale_price'])/$row['original_price'])*100) : 0),
                    'model_id' => $row['model'],
                    'brand_id' => $row['brand_id'],
                    'seller_sku' => $row['seller_sku'],
                    'vendor_id' => $row['vendor_id'],
                ]);

                // 2. Insert Images into Product Images Table
                $this->insertProductImages($product->id, $row);

                // 3. Insert SKU Attributes and Colors into `product_variant_skus` and `product_colors` Tables
                $this->insertProductVariantsAndColors($product->id, $row);

                // 4. Insert Categories into `product_categories` Table
                $this->insertProductCategories($product->id, $row['categories_id']);
            });
        }
    }

    private function insertProductImages($productId, $row)
    {
        for ($i = 1; $i <= 8; $i++) {
            $pictureField = 'picture' . $i;
            if (!empty($row[$pictureField])) {
                ProductImage::create([
                    'product_id' => $productId,
                    'image' => $row[$pictureField],
                ]);
            }
        }
    }

    private function insertProductVariantsAndColors($productId, $row)
    {
        // Insert SKU Attribute into `product_variant_skus` Table
        $variantSku = ProductVariantSku::create([
            'product_id' => $productId,
            'sku' => $row['sku_attribute'],
            'stock' => $row['stock'],
            'price' => $row['original_price'],
        ]);

        // Find the color ID by name
        $color = Color::where('color_en', $row['color'])->first();
        if ($color) {
            ProductColor::create([
                'product_id' => $productId,
                'sku_id' => $variantSku->id,
                'color_id' => $color->id,
            ]);
        }
    }

    private function insertProductCategories($productId, $categories)
    {
        $categoryIds = explode(',', $categories);
        foreach ($categoryIds as $categoryId) {
            CategoryProduct::create([
                'product_id' => $productId,
                'category_id' => trim($categoryId),
            ]);
        }
    }
}
