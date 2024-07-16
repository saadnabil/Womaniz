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


    public function getFitSizeDescAttribute(){
        $lang = app()->getLocale();
        if($lang == 'en'){
            return $this->fit_size_desc_en;
        }
        return $this->fit_size_desc_ar;
    }

    public function getIngredientsDescAttribute(){
        $lang = app()->getLocale();
        if($lang == 'en'){
            return $this->ingredients_desc_en;
        }
        return $this->ingredients_desc_ar;
    }

    public function getAboutProductDescAttribute(){
        $lang = app()->getLocale();
        if($lang == 'en'){
            return $this->about_product_desc_en;
        }
        return $this->about_product_desc_ar;
    }

    public function getMaterialAttribute(){
        $lang = app()->getLocale();
        if($lang == 'en'){
            return $this->material_en;
        }
        return $this->material_ar;
    }


    public function getShipInformation(){
        $lang = app()->getLocale();
        $ship_information = json_decode(setting('ship_information'),true);
        return $ship_information[$lang];
    }

    public function getReturnOrder(){
        $lang = app()->getLocale();
        $return_order = json_decode(setting('return_order'),true);
        return $return_order[$lang];
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products');
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

    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }


    protected static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            activity()
                ->performedOn($model)
                ->causedBy(auth()->user())
                ->withProperties($model->getAttributes())
                ->log('Create');
        });

        static::updated(function ($model) {
            $originalAttributes = $model->getOriginal();

            $attributes=[];
            foreach ($model->getDirty() as $attribute => $newValue) {
                $oldValue = $originalAttributes[$attribute] ?? null;

                if ($oldValue !== $newValue) {
                    $attributes[$attribute]['old']=$oldValue;
                    $attributes[$attribute]['new']=$newValue;
                }
            }

            activity()
                ->performedOn($model)
                ->causedBy(auth()->user())
                ->withProperties($attributes)
                ->log('Updated');


        });

        static::deleting(function ($model) {
            $attributes = $model->getAttributes();

            activity()
                ->performedOn($model)
                ->causedBy(auth()->user())
                ->withProperties($attributes)
                ->log('Delete');
        });
    }



}
