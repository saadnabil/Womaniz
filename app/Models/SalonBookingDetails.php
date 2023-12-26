<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalonBookingDetails extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function salon(){
        return $this->belongsTo(Salon::class , 'salon_id' , 'id')->withTrashed();
    }

    public function branch(){
        return $this->belongsTo(SalonBranch::class , 'salon_branch_id' , 'id')->withTrashed();
    }

    public function user(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }

    public function expert(){
        return $this->belongsTo(Expert::class ,'expert_id' , 'id')->withTrashed();
    }

    public function service(){
        return $this->belongsTo(SalonBranchService::class , 'salon_branch_service_id' , 'id')->withTrashed();
    }

    public function booking(){
        return $this->belongsTo(SalonBooking::class)->withTrashed();
    }

}
