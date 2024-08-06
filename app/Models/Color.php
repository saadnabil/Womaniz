<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $date = ['deleted_at'];

    public function getColorAttribute(){
        $lang = app()->getLocale();
        if($lang == 'en'){
            return $this->color_en;
        }
        return $this->color_ar;
    }
}
