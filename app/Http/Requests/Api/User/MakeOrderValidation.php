<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\AbstractFormRequest;
use App\Rules\CheckAddressBelongsToUser;
use App\Rules\CheckCardBelongsToUser;
use App\Rules\NotRequiredPaymentCardId;
use Illuminate\Foundation\Http\FormRequest;

class MakeOrderValidation extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'address_id' => ['required','string', 'max:50', new CheckAddressBelongsToUser],
            'payment_method' => ['required', 'in:cash,visa'],
            'payment_card_id' => ['required_if:payment_method,visa',new CheckCardBelongsToUser, new NotRequiredPaymentCardId ],
        ];
    }
}
