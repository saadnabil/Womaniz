<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory,SoftDeletes;
    protected $date = ['deleted_at'];
    protected $guarded = [];

    public function getImageAttribute(){
        $lang = app()->getLocale();
        if($lang == 'en'){
            return $this->image_en;
        }
        return $this->image_ar;
    }

}
