<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\AbstractFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class AdminFormValidation extends AbstractFormRequest
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
        $id = $this->route('admin')->id ?? null;
        if(request()->isMethod('post')){
            return [
                'name' => ['required' , 'string' ,'max:250'],
                'email' => ['required' , 'email' ,'unique:admins,email'],
                'password' => ['required' , 'string','max:20','min:8'],
                'birthdate' => ['required' , 'date' ,'date_format:Y-m-d'],
                'address' => ['required' , 'string','max:250'],
                'phone' => ['required' , 'string','max:250' ],
                'status' => ['required' , 'numeric' , 'in:1,0'],
                'image' => ['required', 'image' , 'mimes:png,jpg,jpeg,gif,svg'],
                'role' => ['required','string'],
                'jobs' => ['required', 'array'],
                'jobs.*' => ['numeric','min:1' , 'max:5'],
            ];
        }else{
            return [
                'name' => ['required' , 'string' ,'max:255'],
                'email' => ['required' , 'email' ,'unique:admins,email,'.$id],
                'password' => ['nullable' , 'string','max:20','min:8'],
                'birthdate' => ['required' , 'date' ,'date_format:Y-m-d'],
                'address' => ['required' , 'string','max:250'],
                'phone' => ['required' , 'string' ,'max:250'],
                'status' => ['required' , 'numeric' , 'in:1,0'],
                'image' => ['nullable', 'image' , 'mimes:png,jpg,jpeg,gif,svg'],
                'role' => ['required','string'],
                'jobs' => ['nullable', 'array'],
                'jobs.*' => ['numeric', 'min:1' , 'max:5'],
            ];
        }
    }
}
