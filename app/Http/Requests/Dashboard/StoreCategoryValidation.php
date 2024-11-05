<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\AbstractFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryValidation extends AbstractFormRequest
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
        $data =  [
            'name_en' => ['required','string'],
            'name_ar' => ['required','string'],
            'parent_id' => ['nullable' , 'numeric','exists:categories,id','required_with:brand_id'],
            'brand_id' => ['nullable' , 'numeric','exists:brands,id'],
            'image' => ['nullable' ,'image' , 'mimes:jpg,jpeg,gif,png,svg'],

        ];
        if(request()->isMethod('post')){
            $data['is_salon'] = ['nullable', 'in:1', 'prohibited_unless:parent_id,null','unique:categories,is_salon'];
        }
        return $data;

    }
}
