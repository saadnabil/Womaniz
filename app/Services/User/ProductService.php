<?php
namespace App\Services\User;

use App\Models\Product;

class ProductService{
    public function search($search){
        $products = Product::with('brand')
                            ->where('country_id' , auth()->user()->country_id)
                            ->where(function($query) use($search){
                                $query->where('name_en', 'like', '%'.$search.'%')
                                        ->orwhere('name_ar', 'like', '%'.$search.'%')
                                        ->orwhere('desc_en', 'like', '%'.$search.'%')
                                        ->orwhere('desc_ar', 'like', '%'.$search.'%')
                                        ->orwhere('about_product_desc_en', 'like', '%'.$search.'%')
                                        ->orwhere('about_product_desc_ar', 'like', '%'.$search.'%')
                                        ->orwhere('ingredients_desc_en', 'like', '%'.$search.'%')
                                        ->orwhere('ingredients_desc_ar', 'like', '%'.$search.'%')
                                        ->orwhere('diamond_en', 'like', '%'.$search.'%')
                                        ->orwhere('diamond_ar', 'like', '%'.$search.'%')
                                        ->orwhere('metal_en', 'like', '%'.$search.'%')
                                        ->orwhere('metal_ar', 'like', '%'.$search.'%')
                                        ->orwhere('product_type', 'like', '%'.$search.'%')
                                        ->orWhereHas('brand', function ($brandQuery) use ($search) {
                                            $brandQuery->where('name_en', 'like', '%'.$search.'%')
                                                       ->orWhere('name_ar', 'like', '%'.$search.'%');
                                        });
                    })->latest()->paginate();
        return $products;
    }
}
