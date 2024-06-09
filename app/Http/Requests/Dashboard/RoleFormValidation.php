<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class RoleFormValidation extends FormRequest
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
        $id = $this->route('role')->id ?? null;
        $data = [
            'permissions' => ['nullable' , 'array' ,'min:1'],
            'permissions.*' => [ 'string'],
        ];
        if(request()->isMethod('post')){
            $data['name'] = ['required' , 'string', 'unique:roles,name' ];
        }elseif(request()->isMethod('put')){
            $data['name'] = ['required' , 'string', 'unique:roles,name,'.$id ];
        }

        return $data;
    }
}
