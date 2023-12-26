<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalonBranchService extends Model
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

    public function branch(){
        return $this->belongsTo(SalonBranch::class)->withTrashed();
    }

    public function children(){
        return $this->hasMany(SalonBranchService::class, 'parent_id', 'id');
    }

    public function experts(){
        return $this->belongsToMany(Expert::class , 'salon_branch_service_experts');
    }

}
