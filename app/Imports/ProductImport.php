<?php
namespace App\Imports;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
class ProductImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $rows = $rows->slice(1);
        $sizes = Size::pluck('id')->toarray();
        foreach ($rows as $row) {
            if ($row->filter()->isEmpty()) {
                continue;
            }
            if ($this->isValidRow($row)) {
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
                    'ship_information_desc_en' => $row[8],
                    'ship_information_desc_ar' => $row[9],
                    'return_order_desc_en' => $row[10],
                    'return_order_desc_ar' => $row[11],
                    'ingredients_desc_en' => $row[12],
                    'ingredients_desc_ar' => $row[13],
                    'about_product_desc_en' => $row[14],
                    'about_product_desc_ar' => $row[15],
                    'dimension' => $row[16],
                    'diamond_en' => $row[17],
                    'diamond_ar' => $row[18],
                    'metal_en' => $row[19],
                    'metal_ar' => $row[20],
                    'chain_length' => $row[21],
                    'product_type' => $row[22],
                ]);
                $variants = json_decode($row[24], true) ?? [];
                foreach($variants as $variant){
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size_id' => is_numeric($variant['size']) && in_array($variant['size'], $sizes) ? $variant['size'] : 1,
                        'stock' => is_numeric($variant['stock']) && $variant['stock'] > 0  ? $variant['stock'] : 0,
                    ]);
                }
             }
        }
    }
    private function isValidRow(Collection $row)
    {
        // Ensure necessary fields are not empty
        return !empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4]) && !empty($row[5]) && !empty($row[22]) && is_numeric($row[4]) && is_numeric($row[5]) && in_array($row[22], ['clothes','cosmetics','jewellery']) ;
    }
}
