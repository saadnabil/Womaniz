<?php

namespace Database\Seeders;

use App\Models\AccountDeletedReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateAccountDeletedReason extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 10 ; $i++){
            AccountDeletedReason::create([
                'reason_en' =>  fake()->words(10, true),
                'reason_ar' =>  fake()->words(10, true),
            ]);
        }
    }
}
