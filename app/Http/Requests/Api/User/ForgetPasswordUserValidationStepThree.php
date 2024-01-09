<?php
namespace App\Http\Requests\Api\User;

use App\Http\Requests\AbstractFormRequest;
use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordUserValidationStepThree extends AbstractFormRequest

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
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:4'],
            'password' => ['required', 'string' ,'min:8'],
            'confirmpassword' => ['required', 'string' ,'min:8', 'same:password'],
        ];
    }
}
