<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded = [];

    protected $date = ['deleted_at'];

    public function children(){
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function brands(){
        return $this->belongsToMany(Brand::class , 'category_brands');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function salons(){
        return $this->hasMany(Salon::class);
    }

    public function getNameAttribute(){
        $lang = app()->getLocale();
        if($lang == 'en'){
            return $this->name_en;
        }
        return $this->name_ar;
    }

}
