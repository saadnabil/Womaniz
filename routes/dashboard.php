<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\ScratchGame;
use App\Models\ScratchGameUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::group(['prefix' => 'v1/dashboard'], function(){
        Route::post('login' ,[AuthController::class, 'login'] );
});
