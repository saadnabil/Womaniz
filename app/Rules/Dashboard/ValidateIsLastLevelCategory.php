<?php

namespace App\Rules\Dashboard;

use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;

class ValidateIsLastLevelCategory implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $category = Category::with('children')->find($value);
        if($category && count($category->children) > 0){
            return false;
        }elseif(!$category){
            return false;
        }else{
            return true;
        }
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute is not last child or not found!';
    }
}
