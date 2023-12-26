<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expert extends Model
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
        return $this->belongsToMany(SalonBranch::class , 'salon_branch_experts');
    }

    public function times(){
        return $this->hasMany(SalonBranchExpertTime::class);
    }

    public function services(){
        return $this->belongsToMany(SalonBranchService::class , 'salon_branch_service_experts');
    }

}
