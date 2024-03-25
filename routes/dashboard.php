<?php

use App\Http\Controllers\Api\Dashboard\CategoriesController;
use App\Http\Controllers\Api\Dashboard\ProductsController;
use App\Http\Controllers\Api\Dashboard\SizesController;
use App\Http\Controllers\Dashboard\AuthController;
use Illuminate\Support\Facades\Route;
Route::group(['prefix' => 'v1/dashboard'], function(){
    Route::post('login' ,[AuthController::class, 'login'] );
    Route::group(['middleware' => 'auth:admin'],function(){
        Route::post('logout' ,[AuthController::class, 'logout']);
        Route::resource('products' , ProductsController::class)->only('store');
        Route::resource('categories' , CategoriesController::class)->only('index');
        Route::get('sizes', [SizesController::class , 'index'] );
    });
});
