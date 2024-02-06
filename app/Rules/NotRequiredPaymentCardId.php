<?php

namespace App\Rules;

use App\Models\PaymentCard;
use Illuminate\Contracts\Validation\Rule;

class NotRequiredPaymentCardId implements Rule
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
        $val = '';
        if(request('payment_method') == 'cash'    &&  request()->has('payment_card_id')  ){
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
        return __('messages.Payment card id is not required when payment method is visa');
    }
}
