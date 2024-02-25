<?php
use App\Http\Controllers\Api\User\AddressesController;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\CartController;
use App\Http\Controllers\Api\User\CategoriesController;
use App\Http\Controllers\Api\User\CouponsController;
use App\Http\Controllers\Api\User\GamesController;
use App\Http\Controllers\Api\User\HomeController;
use App\Http\Controllers\Api\User\OrdersController;
use App\Http\Controllers\Api\User\PaymentCardsController;
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

        Route::post('logout', [AuthController::class , 'logout']);

        Route::group(['prefix' => 'games'], function(){
            Route::get('spinGameDetails' , [GamesController::class , 'spingamedetails']);
            Route::get('scratchGameDetails' , [GamesController::class , 'scratchgamedetails']);
            Route::get('scratch' , [GamesController::class , 'scratch']);
            Route::post('spin' , [GamesController::class , 'spin']);
        });

        Route::group(['prefix' => 'categories'],function(){
            Route::get('/',[CategoriesController::class,'index']);
        });

        Route::group(['prefix' => 'orders'],function(){
            Route::get('/past',[OrdersController::class,'pastorders']);
            Route::get('/current',[OrdersController::class,'currentorders']);
            Route::post('/makeorder',[OrdersController::class,'makeorder']);
        });

        Route::group(['prefix' => 'home'], function() {
            Route::get('/', [HomeController::class, 'index']);
        });

        Route::group(['prefix' => 'coupons'], function() {
            Route::get('/', [CouponsController::class, 'validcoupons']);
        });

        Route::group(['prefix' => 'cart'], function() {
            Route::get('/details', [CartController::class, 'cartDetails']);
            Route::get('/minusQuantity/{cartId}', [CartController::class, 'minusQuantity']);
            Route::post('/add', [CartController::class, 'add']);
            Route::get('/plusQuantity/{cartId}', [CartController::class, 'plusQuantity']);
            Route::get('/remove/{cartId}', [CartController::class, 'remove']);
            Route::post('/applycoupn', [CartController::class, 'applycoupn']);
            Route::get('/removecoupon', [CartController::class, 'removecoupon']);
        });

        Route::group(['prefix' => 'profile'], function() {
            Route::get('/', [ProfileController::class, 'index']);
            Route::get('/policy', [ProfileController::class, 'policy']);
            Route::get('/security', [ProfileController::class, 'security']);
            Route::post('/update', [ProfileController::class, 'update']);
            Route::post('/changepassword', [ProfileController::class, 'changepassword']);
        });

        Route::group(['prefix' => 'addresses'], function() {
            Route::get('/', [AddressesController::class, 'fetch']);
            Route::post('/add', [AddressesController::class, 'add']);
            Route::post('/update/{id}', [AddressesController::class, 'update']);


        });

        Route::group(['prefix' => 'paymentcards'] ,function(){
            Route::get('/', [PaymentCardsController::class, 'index']);
            Route::post('/add', [PaymentCardsController::class, 'add']);
            Route::get('/delete/{id}', [PaymentCardsController::class, 'delete']);
        });

        Route::group(['prefix' => 'product'],function(){
            Route::post('/',[ProductsController::class,'index']);
            Route::get('/show/{id}',[ProductsController::class,'show']);
            Route::get('/favourites',[ProductsController::class,'favourites']);
            Route::get('/favourites/togglefavourites/{id}',[ProductsController::class,'togglefavourites']);
        });

        Route::group(['prefix' => 'salon'], function(){
            Route::post('bookStepOne', [SalonController::class, 'bookStepOne']);
            Route::post('bookStepTwo', [SalonController::class, 'bookStepTwo']);
            Route::post('bookStepThree', [SalonController::class, 'bookStepThree']);
            Route::post('bookStepFour', [SalonController::class, 'bookStepFour']);
        });

    });
});



