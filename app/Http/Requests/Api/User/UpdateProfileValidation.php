<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileValidation extends FormRequest
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
            'name' => ['required','string', 'max:50'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['required', 'string', 'max:100'],
            'birthdate' => ['required', 'string', 'date_format:Y/m/d'],
        ];
    }
}
