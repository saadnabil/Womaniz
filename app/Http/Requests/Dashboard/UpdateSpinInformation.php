<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\AbstractFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSpinInformation extends AbstractFormRequest
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
            'digit_one' => ['required' , 'numeric' , 'min:0', 'max:100'],
            'digit_two' =>  ['required' , 'numeric' , 'min:0', 'max:100'],
            'digit_three' =>  ['required' , 'numeric' , 'min:0', 'max:100'],
            'digit_four' =>  ['required' , 'numeric' , 'min:0', 'max:100'],
            'digit_five' =>  ['required' , 'numeric' , 'min:0', 'max:100'],
            'digit_six' =>  ['required' , 'numeric' , 'min:0', 'max:100'],
            'digit_seven' =>  ['required' , 'numeric' , 'min:0', 'max:100'],
            'digit_eight' =>  ['required' , 'numeric' , 'min:0', 'max:100'],
            'digit_nine' =>  ['required' , 'numeric' , 'min:0', 'max:100'],
        ];
    }
}
