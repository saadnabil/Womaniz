<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\AbstractFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CahngePasswordValidation extends AbstractFormRequest
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
            'oldpassword' => ['required', 'string' ,'min:8'],
            'newpassword' => ['required', 'string' ,'min:8'],
            'confirmpassword' => ['required', 'string' ,'same:newpassword'],
        ];
    }
}
