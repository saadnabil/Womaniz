<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\AbstractFormRequest;
use App\Rules\Dashboard\CheckBrandCategoryIsMainCategory;
use Illuminate\Foundation\Http\FormRequest;

class BrandFormValidation extends AbstractFormRequest
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


            $data = [
                'name_en' => ['required','string'],
                'name_ar' => ['required','string'],
            ];
            if(request()->isMethod('POST')){
                $data['icon'] = ['required' ,'image' , 'mimes:jpg,jpeg,gif,png,svg'];
            }
            if(request()->isMethod('PUT')){
                $data['icon'] = ['nullable' ,'image' , 'mimes:jpg,jpeg,gif,png,svg'];
            }


        return $data;
    }
}
