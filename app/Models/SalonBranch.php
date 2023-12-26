<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalonBranch extends Model
{

    use HasFactory,SoftDeletes;

    protected $guarded = [];

    protected $date = ['deleted_at'];

    public function salon(){
        return $this->belongsTo(Salon::class)->withTrashed();
    }

    public function services(){
        return $this->hasMany(SalonBranchService::class);
    }

    public function experts(){
        return $this->belongsToMany(Expert::class , 'salon_branch_experts');
    }

    public function bookings(){
        return $this->hasMany(SalonBooking::class);
    }

}
