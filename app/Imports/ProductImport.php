<?php
namespace App\Imports;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $rows = $rows->slice(1);
        Size::create(['title' => 'Flight 10']);
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
                    'ingredients_desc_en' => $row[8],
                    'ingredients_desc_ar' => $row[9],
                    'about_product_desc_en' => $row[10],
                    'about_product_desc_ar' => $row[11],
                    'dimension' => $row[12],
                    'chain_length' => $row[13],
                    'material_en' => $row[17],
                    'material_ar' => $row[18],
                    'model_id' => $row[19],
                    'vendor_id' => $row[20]
                ]);
                $variants = json_decode($row[16], true) ?? [];
                foreach($variants as $variant){
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size_id' => is_numeric($variant['size']) && in_array($variant['size'], $sizes) ? $variant['size'] : 1,
                        'stock' => is_numeric($variant['stock']) && $variant['stock'] > 0  ? $variant['stock'] : 0,
                        'sku' => $variant['stock'],
                    ]);
                }
             }
        }
        return;
    }
    private function isValidRow(Collection $row)
    {
        // Ensure necessary fields are not empty
        return !empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4]) && !empty($row[5]) && !empty($row[6]) && !empty($row[7]) && !empty($row[14]) && !empty($row[15]) && is_numeric($row[4]) && is_numeric($row[5]) && in_array($row[14], ['clothes','cosmetics','jewellery']) && in_array($row[15], ['clothes','cosmetics','ring','bracelet','necklace','earing']);
    }
}





 // dump($row[0]); //name_en
// dump($row[1]); //name_ar
// dump($row[2]); //desc_en
// dump($row[3]); //desc_ar
// dump($row[4]); //price
// dump($row[5]); //discount
// dump($row[6]); //fit_size_desc_en
// dump($row[7]); //fit_size_desc_ar
// dump($row[8]); //ingredients
// dump($row[9]); //ingredients
// dump($row[10]);//about desc en
// dump($row[11]);//about desc ar
// dump($row[12]);//dimsnsion
// dump($row[13]);//chain length
// dump($row[14]);//product type
// dump($row[15]);//product sub type
// dump($row[16]); //variants
// dump($row[17]); //material_en
// dump($row[18]); //material_ar
// dd('success');
