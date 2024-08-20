<?php

use App\Jobs\SendOrderDetailsOnMail;
use App\Mail\OtpMail;
use App\Mail\SendOrderDetails;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('test', function(){

});

Route::get('test-mail-otp', function(){
    $data = [
        'email' => 'saadnabil00@gmail.com',
        'code' => '1234',
    ];
    Mail::to('saadnabil00@gmail')->send(new OtpMail($data));
});
Route::get('test-mail-order',function(){
    $order = Order::first();
    $order->load('user.addresses','address','orderDetails.product.brand','orderDetails.product.vendor.categories','orderDetails.product.categories','orderDetails.product_variant');
    dispatch(new SendOrderDetailsOnMail($order));
});


