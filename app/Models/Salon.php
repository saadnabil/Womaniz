<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salon extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];
    protected $date = ['deleted_at'];

    public function getNameAttribute(){
        $lang = app()->getLocale();
        if($lang == 'en'){
            return $this->name_en;
        }
        return $this->name_ar;
    }

    public function branches(){
        return $this->hasMany(SalonBranch::class);
    }

    public function times(){
        return $this->hasMany(SalonTime::class);
    }

    public function bookings(){
        return $this->hasMany(SalonBooking::class);
    }



}
