<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Queue\ShouldQueue;



class Admin extends User  implements ShouldQueue , JWTSubject
{
    use HasFactory , SoftDeletes;

    protected $guarded = [];

    protected $data = ['deleted_at'];

    protected $guard = 'admin';


    public function country(){
        return $this->belongsTo(Country::class);
    }

}
