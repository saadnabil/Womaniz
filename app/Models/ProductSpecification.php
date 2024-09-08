<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSpecification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'name_en',
        'name_ar',
        'value_en',
        'value_ar',
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }

}
