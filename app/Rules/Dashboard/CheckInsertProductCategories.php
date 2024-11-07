<?php

namespace App\Rules;

use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;

class CheckInsertProductCategories implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $message;
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
        $categoryId = $value;
        $category = Category::where('id', $categoryId)->with('children')->first();

        if (!$category) {
            return false;
            $this->message = 'Category does not exist.';

        }

        if ($category->children->count() > 0) {
            $this->message = 'Sorry, can\'t add products in ' . $category->name . ' category because it is not a last level';
            return false;
        }

        return true;
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'fdfdfdfdfd';
    }
}
