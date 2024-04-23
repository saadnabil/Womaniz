<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\AbstractFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserFormValidation extends AbstractFormRequest
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
        $id = $this->route('user')->id ?? null;
        if(request()->isMethod('post')){
            return [
                'name' => ['required' , 'string' ,'max:255'],
                'email' => ['required' , 'email' ,'unique:users,email'],
                'password' => ['required' , 'string'],
                'birthdate' => ['required' , 'date' ,'date_format:Y-m-d'],
                'phone' => ['required' , 'string' ],
                'image' => ['nullable', 'image' , 'mimes:png,jpg,jpeg,gif,svg'],
                'gender' => ['required', 'string', 'in:Female,Male,Other'],
            ];
        }else{
            return [
                'name' => ['required' , 'string' ,'max:255'],
                'email' => ['required' , 'email' ,'unique:users,email,'.$id],
                'password' => ['required' , 'string'],
                'birthdate' => ['required' , 'date' ,'date_format:Y-m-d'],
                'phone' => ['required' , 'string' ],
                'status' => ['required' , 'numeric' , 'in:1,0'],
                'image' => ['nullable', 'image' , 'mimes:png,jpg,jpeg,gif,svg'],
                'gender' => ['required', 'string', 'in:Female,Male,Other'],
            ];
        }

    }
}
