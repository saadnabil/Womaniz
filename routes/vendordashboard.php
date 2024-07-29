<?php
use App\Http\Controllers\Api\Dashboard\DataController;
use App\Http\Controllers\Api\VendorDashboard\OrdersController;
use App\Http\Controllers\Api\VendorDashboard\AuthController;
use App\Http\Controllers\Api\VendorDashboard\ProductsController;
use Illuminate\Support\Facades\Route;
Route::group(['prefix' => 'v1/vendordashboard'], function(){
    Route::post('login' ,[AuthController::class, 'login']);
    Route::group(['middleware' => 'auth:vendor'],function(){
        /**auth logout */
        Route::post('logout' ,[AuthController::class, 'logout']);
    });
    Route::get('orders/changeStatus/{order}/{status}' , [OrdersController::class, 'changeStatus']);
    Route::resource('orders' , OrdersController::class)->only('index','show');
    Route::get('data/policy', [DataController::class, 'policy']);
    Route::get('data/security', [DataController::class, 'security']);
    Route::resource('products' , ProductsController::class)->only('index','store','update','destroy');
});
