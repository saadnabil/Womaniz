<?php

namespace App\Rules\Dashboard;

use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;

class IsLastLevel implements Rule
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
        //
        $categories = $value;

        foreach($categories as $category){
            $category = Category::find($category['id']);
            if(!$category){
                $this->message = 'Category is not found';
                return false;
            }elseif($category && !$category->isLastChild()){
                $this->message = 'Category id '.$category['id'].' is not last child';
                return false;
            }else{
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
        return $this->message;
    }
}
