<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantSku extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function product_variants(){
        return $this->hasMany(ProductVariant::class);
    }

    public function product_colors(){
        return $this->hasMany(ProductColor::class);
    }

}
