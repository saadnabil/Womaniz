<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory ,SoftDeletes;
    protected $guarded = [];
    protected $date = ['deleted_at'];

    public function getNameAttribute(){
        $lang = app()->getLocale();
        if($lang == 'en'){
            return $this->name_en;
        }
        return $this->name_ar;
    }

    public function getDescAttribute(){
        $lang = app()->getLocale();
        if($lang == 'en'){
            return $this->desc_en;
        }
        return $this->desc_ar;
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function designer(){
        return $this->belongsTo(Designer::class);
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function variants(){
        return $this->hasMany(ProductVariant::class);
    }

    public function favoritedbyusers()
    {
        return $this->belongsToMany(User::class, 'user_products');
    }

}
