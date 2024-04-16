<?php

use App\Http\Controllers\Api\Dashboard\AdminsController;
use App\Http\Controllers\Api\Dashboard\CategoriesController;
use App\Http\Controllers\Api\Dashboard\DataController;
use App\Http\Controllers\Api\Dashboard\ProductsController;
use App\Http\Controllers\Api\Dashboard\SizesController;
use App\Http\Controllers\Api\Dashboard\UsersController;
use App\Http\Controllers\Dashboard\AuthController;
use Illuminate\Support\Facades\Route;
Route::group(['prefix' => 'v1/dashboard'], function(){
    Route::post('login' ,[AuthController::class, 'login'] );
    Route::group(['middleware' => 'auth:admin'],function(){
        Route::get('data', [DataController::class, 'index']);
        Route::get('data/cities', [DataController::class, 'cities']);
        Route::post('logout' ,[AuthController::class, 'logout']);
        Route::resource('products' , ProductsController::class)->only('store');
        Route::resource('categories' , CategoriesController::class)->only('index');
        Route::get('admins/filter', [AdminsController::class, 'search']);
        Route::resource('admins', AdminsController::class)->only('index','store','update','show');
        Route::get('users/filter', [UsersController::class, 'search']);
        Route::get('users/{user}/switchstatus', [UsersController::class, 'switchstatus']);
        Route::resource('users', UsersController::class)->only('index','store','update','show');
        Route::post('users/delete', [UsersController::class, 'delete']);
        Route::post('admins/delete', [AdminsController::class, 'delete']);
        Route::get('sizes', [SizesController::class , 'index']);
    });
});
