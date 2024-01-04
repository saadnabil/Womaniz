<?php

use App\Models\Country;
use App\Models\ScratchGame;
use App\Models\ScratchGameUser;
use App\Models\User;
use Carbon\Carbon;
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
    $countries = Country::with('users')->get();
    foreach($countries as $country){
        $date = Carbon::now($country->timezone);
        $todayscratchgame = ScratchGame::where([
            'date' => $date->format('Y-m-d'),
            'country_id' => $country->id
        ])->first();
        if(!$todayscratchgame){
            $scratchgame = ScratchGame::create([
                'code' => strtoupper(Str::random(5)),
                'discount' => 30,
                'country_id' => $country->id,
                'date' => $date->format('Y-m-d'),
            ]);
            foreach($country->users as $user){
                ScratchGameUser::create([
                    'user_id' => $user->id,
                    'scratch_game_id' => $scratchgame->id,
                    'date' => $date->format('Y-m-d'),
                    'expiration_date' => $date->addDays(3)->format('Y-m-d'),
                    'open_cell_index' => 0,
                ]);
            }
        }
    }
});
