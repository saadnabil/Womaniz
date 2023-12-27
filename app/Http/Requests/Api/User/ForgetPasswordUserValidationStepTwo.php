<?php
namespace App\Http\Requests\Api\User;

use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordUserValidationStepTwo extends FormRequest
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
            // 'password' => ['required_with:otp', 'string' ,'min:8'],
            // 'confirmpassword' => ['required_with:otp', 'string' ,'min:8', 'same:password'],
        ];
    }
}
