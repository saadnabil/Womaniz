<?php
namespace App\Http\Controllers\Api\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\SpinGameValidation;
use App\Http\Resources\Api\ScratchGameResource;
use App\Http\Resources\Api\SpinGameResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Coupon;
use App\Models\SpinGame;
use Carbon\Carbon;
class GamesController extends Controller
{
    use ApiResponseTrait;

    public function scratchgamedetails(){
        $user = auth()->user()->load('country');
        $scratchgame = $user -> todayscratchgameuser;
        if(!$scratchgame){
            return $this->sendResponse(['error' => __('messages.Game is not found')] , 'fail' ,404);
        }
        $scratchgame -> load('scratchgame');
        return $this->sendResponse(new ScratchGameResource($scratchgame));
    }

    public function spingamedetails(){
        $user = auth()->user()->load('country');
        $spinGame = SpinGame::with('country')->where([
            'country_id' => $user->country_id,
        ])->first();
        if(!$spinGame){
            return $this->sendResponse(['error' => __('messages.Game is not found')] , 'fail' ,404);
        }
        return $this->sendResponse(new SpinGameResource($spinGame));
    }

    public function spin(SpinGameValidation $request){
        $data = $request->validated();
        $user = auth()->user()->load('country');
        if($user->spins <= 0){
            return $this->sendResponse(['error' => __('messages.Game is over')],'fail', 400);
        }
        $spinGame = SpinGame::with('country')->where([
            'country_id' => $user->country_id,
        ])->first();
        if(!$spinGame){
            return $this->sendResponse(['error' => __('messages.Game is not found')] , 'fail' ,404);
        }

    }

    public function scratch(){

        $user = auth()->user()->load('country');

        $country = $user->country;

        $scratchgame = $user -> todayscratchgameuser;

        if(!$scratchgame){
           return $this->sendResponse(['error' => __('messages.Game is not found')], 'fail' , 404);
        }

        if($scratchgame->open_cell_index == 5){
            return $this->sendResponse(['error' => __('messages.Game is over')], 'fail' , 404);
        }

        $scratchgame -> load('scratchgame');

        $time_open_cell_index = $scratchgame->time_open_cell_index == null ?  (Carbon::now($country->timezone)->subHours(3))->format('h:i a'): $scratchgame->time_open_cell_index;


        if(Carbon::now($country->timezon)->diffInMinutes(Carbon::createFromFormat('h:i a',$time_open_cell_index)) < 60){
            return $this->sendResponse(['error' => __('messages.Scratch is not available now')], 'fail' , 404);
        }

        $scratchgame->update([
            'open_cell_index' => $scratchgame->open_cell_index  + 1,
            'time_open_cell_index' => Carbon::now($country->timezon)->format('h:i a'),
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



