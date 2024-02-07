<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\AbstractFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddCardValidation extends AbstractFormRequest
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
            'card_number' => ['required','numeric', 'digits:16'],
            'cardholder_name' => ['required', 'string', 'max:100'],
            'expiration_month' => ['required','numeric', 'string', 'min:1','max:12'],
            'expiration_year' => ['required', 'numeric', 'digits:4'],
            'is_default' => ['required','in:0,1'],
        ];
    }
}
