<?php

namespace App\Rules\Dashboard;

use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;

class IsLastChild implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $categoryIds = $value;
        foreach($categoryIds as $categoryId){

            $category = Category::find($categoryId);

            dd($category->isLastChild());

            if (!$category){
                return false;
            }


            elseif ($category->isChild() > 0){
                return false;
            }

            else{
                return true;
            }

        }


    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected category must be the last level.';
    }
}
