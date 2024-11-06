<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\CategoryProduct;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsSheetImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            DB::transaction(function () use ($row) {
                $product = Product::create([
                    'name_en' => $row['name_en'],
                    'name_ar' => $row['name_ar'],
                    'desc_en' => $row['description_en'],
                    'desc_ar' => $row['description_ar'],
                    'price' => $row['original_price'],
                    'price_after_sale' => $row['sale_price'],
                    'discount' => $row['sale_price'] ? ((($row['original_price'] - $row['sale_price'] )* $row['sale_price'] )/ 100) : 0,
                    'model_id' => $row['model'],
                    'stock' => $row['stock'],
                    'brand_id' => $row['brand_id'],
                    'seller_sku' => $row['seller_sku'],
                    'vendor_id' => $row['vendor_id'],
                    'country_id' => 1,
                    'thumbnail' => $row['image'],
                ]);

                // Insert categories
                $this->insertProductCategories($product->id, $row['categories_id']);
                $this->insertProductImages($product->id, $row);

            });
        }
    }


    private function insertProductCategories($productId, $categoriesId)
    {
        if (!empty($categoriesId)) {
            $categories = explode(',', $categoriesId);
            foreach ($categories as $categoryId) {
                CategoryProduct::create([
                    'product_id' => $productId,
                    'category_id' => $categoryId,
                ]);
            }
        }
    }


    private function insertProductImages($productId, $row)
    {
        foreach ($row as $column => $value) {
            if (str_starts_with($column, 'image') && !empty($value)) {
                ProductImage::create([
                    'product_id' => $productId,
                    'image' => $value,
                ]);
            }
        }
    }
}

