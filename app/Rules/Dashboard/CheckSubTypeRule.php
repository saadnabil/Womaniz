<?php

namespace App\Rules\Dashboard;

use Illuminate\Contracts\Validation\Rule;

class CheckSubTypeRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $message ;

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
        $producttype = request('product_type');
        if($producttype == 'clothes' &&  !in_array($value, ['clothes','shoes','bags'])){
            $this->message = 'The :attribute must be in clothes, shoes, bags';
            return false;
        }elseif($producttype == 'jewellery' &&  !in_array($value, ['ring','necklace','earing','bracelet'])){
            $this->message = 'The :attribute must be in ring, necklace, earing, bracelet';
            return false;
        }elseif($producttype == 'cosmetics' &&  !in_array($value, ['cosmetics'])){
            $this->message = 'The :attribute must be in cosmetics';
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
        return $this->message;
    }
}
