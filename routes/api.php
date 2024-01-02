<?php

use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\CategoriesController;
use App\Http\Controllers\Api\User\HomeController;
use App\Http\Controllers\Api\User\ProductsController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\SalonController;
use App\Http\Controllers\Api\User\SettingController;
use Illuminate\Support\Facades\Route;
Route::group(['prefix' => 'v1/user'],function(){

    Route::post('login', [AuthController::class , 'login']);
    Route::post('register', [AuthController::class , 'register']);
    Route::post('forgetPasswordStepOne', [AuthController::class , 'forgetPasswordStepOne']);
    Route::post('forgetPasswordStepTwo', [AuthController::class , 'forgetPasswordStepTwo']);
    Route::post('forgetPasswordStepThree', [AuthController::class , 'forgetPasswordStepThree']);

    Route::get('countries', [SettingController::class, 'countries']);

    Route::group(['middleware' => 'auth'],function(){

        Route::post('logout', [AuthController::class , 'logout'] );

        Route::group(['prefix' => 'categories'],function(){
            Route::get('/',[CategoriesController::class,'index']);
        });

        Route::group(['prefix' => 'home'], function() {
            Route::get('/', [HomeController::class, 'index']);
        });

        Route::group(['prefix' => 'profile'], function() {
            Route::get('/', [ProfileController::class, 'index']);
            Route::get('/policy', [ProfileController::class, 'policy']);
            Route::get('/security', [ProfileController::class, 'security']);
            Route::post('/update', [ProfileController::class, 'update']);
            Route::post('/addlocation', [ProfileController::class, 'addlocation']);
        });

        Route::group(['prefix' => 'product'],function(){
            Route::post('/',[ProductsController::class,'index']);
            Route::get('/show/{id}',[ProductsController::class,'show']);
            Route::get('/favourites',[ProductsController::class,'favourites']);
        });

        Route::group(['prefix' => 'salon'], function(){
            Route::post('bookStepOne', [SalonController::class, 'bookStepOne']);
            Route::post('bookStepTwo', [SalonController::class, 'bookStepTwo']);
            Route::post('bookStepThree', [SalonController::class, 'bookStepThree']);
            Route::post('bookStepFour', [SalonController::class, 'bookStepFour']);
        });

    });
});



