<?php
namespace App\Services\User;

use App\Models\Product;

class ProductService {
    public function search($search) {
        $products = Product::with('brand')
            ->where('country_id', auth()->user()->country_id)
            ->where(function($query) use($search) {
                $query->whereRaw("MATCH(name_en, name_ar, desc_en, desc_ar) AGAINST(? IN BOOLEAN MODE)", [$search])
                    ->orWhere('price', 'like', '%'.$search.'%')
                    ->orWhere('price_after_sale', 'like', '%'.$search.'%')
                    ->orWhere('discount', 'like', '%'.$search.'%')
                    ->orWhere('designer_id', 'like', '%'.$search.'%')
                    ->orWhere('country_id', 'like', '%'.$search.'%')
                    ->orWhere('vat', 'like', '%'.$search.'%')
                    ->orWhere('size_id', 'like', '%'.$search.'%')
                    ->orWhere('brand_id', 'like', '%'.$search.'%')
                    ->orWhere('vendor_id', 'like', '%'.$search.'%')
                    ->orWhere('seller_sku', 'like', '%'.$search.'%')
                    ->orWhere('status', 'like', '%'.$search.'%')
                    ->orWhere('model_id', 'like', '%'.$search.'%');
            })
            ->latest()
            ->paginate();

        return $products;
    }
}
