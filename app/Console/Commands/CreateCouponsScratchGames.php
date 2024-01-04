<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\ScratchGame;
use App\Models\ScratchGameUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
class CreateCouponsScratchGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:scratchgames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates scratch games for each user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return Command::SUCCESS;
        info('success');
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
    }
}
