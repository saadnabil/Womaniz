<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestoreAccountRequest extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    protected $date = ['deleted_at'];


    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

}
