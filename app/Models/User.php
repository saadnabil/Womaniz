<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Resources\Api\CartResource;
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

    public function validcoupons()
    {
        return $this->hasMany(Coupon::class)->where('expiration_date', '>=', Carbon::now()->toDateString());
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function appliedcoupon(){
        return $this->belongsTo(Coupon::class ,'coupon_id');
    }

    public function cartData(){
        $user = $this->load(['carts.product','appliedcoupon']);
        $totalSub = 0 ;
        $tax  = 14;
        $shipping = count($user->carts) > 0 ?  20 : 0 ;
        $discount = $user->appliedcoupon ? $user->appliedcoupon->discount : 0  ;
        $user->carts->each(function ($cart) use (&$total , &$totalSub) {
            $cart->price = $cart->quantity * $cart->product->price; // Assuming there's a 'price' column in your 'products' table
            $cart->price_after_sale = $cart->quantity * ( $cart->product->price -  $cart->product->price_after_sale);
            //sum cart final
            $totalSub += $cart->price_after_sale;
            //sum cart final
        });
        $data = [
            'vat' => $tax ,
            'shipping' => $shipping ,
            'total' =>  round(( ($totalSub - ($totalSub * $discount / 100))  + ( $totalSub * $tax / 100 ) + $shipping ) * 2) / 2 ,
            'totalSub' => $totalSub ,
            'discount' => $discount ,
            'details' => CartResource::collection($user->carts) ,
        ];
        return $data;
    }


}
