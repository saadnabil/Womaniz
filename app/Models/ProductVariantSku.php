<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantSku extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sku',
        'stock',
        'price',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
