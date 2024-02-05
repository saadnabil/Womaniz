<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory ,SoftDeletes;
    protected $guarded = [];
    protected $date = ['deleted_at'];

    public function orderDetails(){
        return $this->hasMany(OrderDetails::class);
    }

    public function coupon(){
        return $this->belongsTo(Coupon::class)->withTrashed();
    }
}
