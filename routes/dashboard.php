<?php

use App\Http\Controllers\Api\Dashboard\ActivitiesController;
use App\Http\Controllers\Api\Dashboard\AdminsController;
use App\Http\Controllers\Api\Dashboard\CategoriesController;
use App\Http\Controllers\Api\Dashboard\DataController;
use App\Http\Controllers\Api\Dashboard\PermissionsController;
use App\Http\Controllers\Api\Dashboard\ProductsController;
use App\Http\Controllers\Api\Dashboard\RestoreRequestController;
use App\Http\Controllers\Api\Dashboard\RolesController;
use App\Http\Controllers\Api\Dashboard\ScratchGameController;
use App\Http\Controllers\Api\Dashboard\SizesController;
use App\Http\Controllers\Api\Dashboard\SpinGameController;
use App\Http\Controllers\Api\Dashboard\UsersController;
use App\Http\Controllers\Api\Dashboard\VendorsController;
use App\Http\Controllers\Dashboard\AuthController;
use Illuminate\Support\Facades\Route;
Route::group(['prefix' => 'v1/dashboard'], function(){
    Route::post('login' ,[AuthController::class, 'login']);
    Route::group(['middleware' => 'auth:admin'],function(){

        Route::get('data', [DataController::class, 'index']);
        Route::get('data/cities', [DataController::class, 'cities']);

        Route::post('products/bulk/upload' ,[ProductsController::class, 'bulkupload' ]);
        Route::resource('products' , ProductsController::class)->only('store');
        Route::resource('categories' , CategoriesController::class)->only('index');

        /**activities */
        Route::resource('activities', ActivitiesController::class)->only('index');


        /**admins */
        Route::get('admins/fulldata/export', [AdminsController::class, 'fulldataexport']);
        Route::post('admins/delete', [AdminsController::class, 'delete']);
        Route::post('admins/{admin}/switchstatus', [AdminsController::class, 'switchstatus']);
        Route::resource('admins', AdminsController::class)->only('index','store','update','show');

        /**users */
        Route::post('users/{user}/switchstatus', [UsersController::class, 'switchstatus']);
        Route::get('users/fulldata/export', [UsersController::class, 'fulldataexport']);
        Route::resource('users', UsersController::class)->only('index','store','update','show');
        Route::post('users/delete', [UsersController::class, 'delete']);

        /**sizes */
        Route::get('sizes', [SizesController::class , 'index']);

        /**vendors */
        Route::get('vendors/fulldata/export', [VendorsController::class, 'fulldataexport']);
        Route::post('vendors/brands/add', [VendorsController::class, 'addbrand']);
        Route::post('vendors/delete', [VendorsController::class, 'delete']);
        Route::post('vendors/{vendor}/switchstatus', [VendorsController::class, 'switchstatus']);
        Route::resource('vendors',VendorsController::class)->only('index','store','update','show');

        /**scratch game */
        Route::get('scratch/information',[ScratchGameController::class , 'scratchInformation']);
        Route::post('scratch/information/update',[ScratchGameController::class , 'updateDiscountValue']);

         /**spin game */
        Route::get('spin/information',[SpinGameController::class , 'spinInformation']);
        Route::post('spin/information/update',[SpinGameController::class , 'spinInformationUpdate']);

        /**restore request */
        Route::post('restoreAccountRequest' ,[RestoreRequestController::class, 'index']);
        Route::post('restoreAccountRequest/changeStatus/{restoreAccountRequest}' ,[RestoreRequestController::class, 'changeStatus']);

        /**auth logout */
        Route::post('logout' ,[AuthController::class, 'logout']);

        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class)->only('index');

    });
    Route::get('data/policy', [DataController::class, 'policy']);
    Route::get('data/security', [DataController::class, 'security']);
});
