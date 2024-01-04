<?php
namespace App\Http\Controllers\Api\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ScratchGameResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Coupon;
use Carbon\Carbon;
class GamesController extends Controller
{
    use ApiResponseTrait;
    public function scratchgamedetails(){
        $user = auth()->user();
        $scratchgame = $user -> todayscratchgameuser;
        if($scratchgame){
            $scratchgame -> load('scratchgame');
        }
        return $this->sendResponse(new ScratchGameResource($scratchgame));
    }
    public function scratch(){
        $user = auth()->user();
        $scratchgame = $user -> todayscratchgameuser;
        if(!$scratchgame){
           return $this->sendResponse(['error' => __('messages.Game is not found')], 'fail' , 404);
        }
        $scratchgame -> load('scratchgame');
        if($scratchgame->open_cell_index == 5){
            return $this->sendResponse(['error' => __('messages.Game is over')], 'fail' , 404);
        }
        if(Carbon::now()->diffInMinutes(Carbon::createFromFormat('h:i a',$scratchgame->time_open_cell_index)) < 60){
            return $this->sendResponse(['error' => __('messages.Scratch is not available now')], 'fail' , 404);
        }
        $scratchgame->update([
            'open_cell_index' => $scratchgame->open_cell_index  + 1,
            'time_open_cell_index' => Carbon::now()->format('h:i a'),
        ]);
        if($scratchgame->open_cell_index == 5){ //scratched last cell in the game
            //steps add coupons
            Coupon::create([
                'user_id' => auth()->user()->id,
                'code' =>$scratchgame->scratchgame->code,
                'expiration_date' => $scratchgame->expiration_date,
                'discount' => $scratchgame->scratchgame->discount,
                'country_id' => $scratchgame->scratchgame->country_id,
                'type' => 'scratch',
            ]);
        }
        return $this->sendResponse(new ScratchGameResource($scratchgame));
    }
}



