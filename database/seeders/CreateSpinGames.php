<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\SpinGame;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateSpinGames extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $countries = Country::get();
        foreach($countries as $country){
            SpinGame::create([
                'country_id' => $country->id,
                'digit_one' => '100',
                'digit_two' => '35',
                'digit_three' => '20',
                'digit_four' => 'spin_again',
                'digit_five' => '65',
                'digit_six' => '15',
                'digit_seven' => 'spin_again',
                'digit_eight' => '60',
                'digit_nine' => '95',
            ]);
        }
    }
}
