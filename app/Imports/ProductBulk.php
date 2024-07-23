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
                    'name_en' => $row[0],
                    'name_ar' => $row[1],
                    'desc_en' => $row[2],
                    'desc_ar' => $row[3],
                    'price' => $row[4],
                    'discount' => $row[5],
                    'price_after_sale' =>  $row[4] - $row[4] * $row[5] / 100,
                    'fit_size_desc_en' => $row[6],
                    'fit_size_desc_ar' => $row[7],
                    'ingredients_desc_en' => $row[8],
                    'ingredients_desc_ar' => $row[9],
                    'about_product_desc_en' => $row[10],
                    'about_product_desc_ar' => $row[11],
                    'dimension' => $row[12],
                    'chain_length' => $row[13],
                    'product_type' => $row[14],
                    'product_sub_type' => $row[15],
                    'material_en' => $row[17],
                    'material_ar' => $row[18],
                    'model_id' => $row[19],
                    'vendor_id' => $row[20]
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


