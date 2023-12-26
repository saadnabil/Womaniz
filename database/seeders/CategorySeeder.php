<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $mainCategories = [
            'Clothes',
            'Jewelry',
            'Beauty Salons',
            'Cosmetics',
            'Celebrities',
        ];

        // Reset the auto-increment counter for the categories table
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($mainCategories as $mainCategoryName) {
            $mainCategory = Category::create([
                'name' => $mainCategoryName,
            ]);

            // Create subcategories for the main category
            $this->createSubcategories($mainCategory, 3);
        }
    }

    private function createSubcategories($parentCategory, $level)
    {
        if ($level <= 0) {
            return;
        }

        $subcategories = [
            'Fashion',
            'Accessories',
            'Shoes',
        ];

        foreach ($subcategories as $subcategoryName) {
            $subcategory = Category::create([
                'name' => $subcategoryName,
                'parent_id' => $parentCategory->id,
            ]);

            // Create subcategories for the current subcategory
            $this->createSubcategories($subcategory, $level - 1);
        }
    }
}
