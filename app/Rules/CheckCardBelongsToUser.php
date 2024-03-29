<?php

namespace App\Rules;

use App\Models\PaymentCard;
use Illuminate\Contracts\Validation\Rule;

class CheckCardBelongsToUser implements Rule
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
        //
        $card = PaymentCard::where([
            'id' => $value,
            'user_id' => auth()->user()->id,
        ])->first();
        if($card != null){
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
        return __('messages.Card is not found or not belongs to this user');
    }
}
