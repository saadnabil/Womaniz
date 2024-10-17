<?php
namespace App\Http\Requests\Api\User;

use App\Http\Requests\AbstractFormRequest;
use App\Models\Country;
use App\Rules\ValidateDeletedEmail;
use Illuminate\Foundation\Http\FormRequest;
class RegisterUserValidation extends AbstractFormRequest
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
        $countryIds = Country::pluck('id')->toarray();
        $countryIds = implode(',',$countryIds);
        return [
            'name' => ['required','string', 'max:50'],
            'email' => ['required', 'email',new ValidateDeletedEmail(),'unique:users,email,'.$this->id,],
            'birthdate' =>  ['required','string', 'date_format:Y/m/d'],
            'phone' => ['required','string', 'max:50'],
            'password' => ['required', 'string' ,'min:8'],
            'confirmpassword' => ['required', 'string' ,'min:8', 'same:password'],
            'country_id' => ['required', 'numeric','in:'.$countryIds],
            'otp' => ['nullable', 'digits:4'],
            'gender' => ['required', 'string', 'in:Female,Male,Other'],
        ];
    }
}
