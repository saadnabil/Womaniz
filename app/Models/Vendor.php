<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $date = ['deleted_at'];

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'vendor_work_categories');
    }

}
