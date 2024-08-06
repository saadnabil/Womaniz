<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FillColorsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $colors = [
            ['color_en' => 'Red', 'color_ar' => 'أحمر', 'hexa' => '#FF0000'],
            ['color_en' => 'Green', 'color_ar' => 'أخضر', 'hexa' => '#008000'],
            ['color_en' => 'Blue', 'color_ar' => 'أزرق', 'hexa' => '#0000FF'],
            ['color_en' => 'Yellow', 'color_ar' => 'أصفر', 'hexa' => '#FFFF00'],
            ['color_en' => 'Black', 'color_ar' => 'أسود', 'hexa' => '#000000'],
            ['color_en' => 'White', 'color_ar' => 'أبيض', 'hexa' => '#FFFFFF'],
            ['color_en' => 'Orange', 'color_ar' => 'برتقالي', 'hexa' => '#FFA500'],
            ['color_en' => 'Purple', 'color_ar' => 'بنفسجي', 'hexa' => '#800080'],
            ['color_en' => 'Pink', 'color_ar' => 'وردي', 'hexa' => '#FFC0CB'],
            ['color_en' => 'Brown', 'color_ar' => 'بني', 'hexa' => '#A52A2A'],
            ['color_en' => 'Gray', 'color_ar' => 'رمادي', 'hexa' => '#808080'],
            ['color_en' => 'Cyan', 'color_ar' => 'سماوي', 'hexa' => '#00FFFF'],
            ['color_en' => 'Magenta', 'color_ar' => 'قرمزي', 'hexa' => '#FF00FF'],
            ['color_en' => 'Lime', 'color_ar' => 'ليموني', 'hexa' => '#00FF00'],
            ['color_en' => 'Maroon', 'color_ar' => 'ماروني', 'hexa' => '#800000'],
            ['color_en' => 'Navy', 'color_ar' => 'كحلي', 'hexa' => '#000080'],
            ['color_en' => 'Olive', 'color_ar' => 'زيتي', 'hexa' => '#808000'],
            ['color_en' => 'Teal', 'color_ar' => 'أزرق مخضر', 'hexa' => '#008080'],
            ['color_en' => 'Lavender', 'color_ar' => 'أرجواني فاتح', 'hexa' => '#E6E6FA'],
            ['color_en' => 'Coral', 'color_ar' => 'مرجاني', 'hexa' => '#FF7F50'],
        ];

        DB::table('colors')->insert($colors);
    }
}
