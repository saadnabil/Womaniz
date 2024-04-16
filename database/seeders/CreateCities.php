<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateCities extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = Country::get();
        foreach($countries as $country){
            for($i = 0 ; $i < 10 ; $i++){
                City::create([
                    'name_en' => 'city '.$i,
                    'name_ar' => 'مدينة'. $i,
                    'country_id' => $country->id,
                ]);
            }
        }
    }
}
