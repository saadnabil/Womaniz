<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPUnit\Framework\Constraint\Count;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use  HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */

     public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function scratchgameusers(){
        return $this->hasMany(ScratchGameUser::class);
    }

    public function todayscratchgameuser(){
        return $this->hasOne(ScratchGameUser::class)->whereDate('date',Carbon::today());
    }

    public function favouriteproducts(){
        return $this->belongsToMany(Product::class , 'user_products');
    }

    public function coupons(){
        return $this->hasMany(Coupon::class);
    }



    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function appliedcoupon(){
        return $this->belongsTo(Coupon::class ,'coupon_id');
    }

}
