<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalonBooking extends Model
{

    use HasFactory,SoftDeletes;

    protected $guarded = [];

    protected $date = ['deleted_at'];

    public function salon(){
        return $this->belongsTo(Salon::class)->withTrashed();
    }

    public function branch(){
        return $this->belongsTo(SalonBranch::class, 'salon_branch_id' , 'id')->withTrashed();
    }

    public function details(){
        return $this->hasMany(SalonBookingDetails::class);
    }

}
