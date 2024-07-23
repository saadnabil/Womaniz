<?php
namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Tag;
use App\Models\ProductTags;
use App\Models\ProductAdditionalFeatures;
use App\Models\ProductFeatures;
use App\Models\ProductFeatureValues;
use App\Models\ProductVariant;
use App\Models\Size;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class ProductBulk implements WithMultipleSheets
{
    protected $productsSheetImport;

    public function __construct()
    {
        $this->productsSheetImport = new ProductsSheetImport();
    }

    public function sheets(): array
    {
        return [
            'Products Data' => $this->productsSheetImport,
            'Product Variant' => new ProductTagsSheetImport($this->productsSheetImport),
        ];
    }
}

class ProductsSheetImport implements ToModel, WithHeadingRow
{
    private $productMap = [];

    public function model(array $row)
    {
                $product = Product::create([
                    'name_en' => $row[name_en],
                    'name_ar' => $row[name_ar],
                    'desc_en' => $row[desc_en],
                    'desc_ar' => $row[desc_ar],
                    'price' => $row[price],
                    'discount' => $row[discount],
                    'price_after_sale' =>  $row[price] - $row[price] * $row[discount] / 100,
                    'fit_size_desc_en' => $row[fit_size_desc_en],
                    'fit_size_desc_ar' => $row[fit_size_desc_ar],
                    'ingredients_desc_en' => $row[ingredients_desc_en],
                    'ingredients_desc_ar' => $row[ingredients_desc_ar],
                    'about_product_desc_en' => $row[about_product_desc_en],
                    'about_product_desc_ar' => $row[about_product_desc_ar],
                    'dimension' => $row[dimension],
                    'chain_length' => $row[chain_length],
                    'product_type' => $row[product_type],
                    'product_sub_type' => $row[product_sub_type],
                    'material_en' => $row[material_en],
                    'material_ar' => $row[material_ar],
                    'model_id' => $row[model_id],
                    'vendor_id' => $row[vendor_id]
            ]);

            // Store the mapping
            $this->productMap[$row['product_id']] = $product->id;




    }

    public function getProductMap()
    {
        return $this->productMap;
    }
}

class ProductTagsSheetImport implements ToModel, WithHeadingRow
{
    protected $productsSheetImport;

    public function __construct(ProductsSheetImport $productsSheetImport)
    {
        $this->productsSheetImport = $productsSheetImport;
    }

    public function model(array $row)
    {
        $productMap = $this->productsSheetImport->getProductMap();
        $productId = $productMap[$row['product_id']] ?? null;

        $size = Size::where("name", $row['size'])->first();


        if ($productId && $size) {
            ProductVariant::create([
                'product_id' => $productId,
                'size_id' => $size->id,
                'stock' => $row['stock'],
                'sku' => $row['sku'],
            ]);

        } else {
            Log::error('Product ID or Varinat not found', ['row' => $row]);
        }
    }
}


