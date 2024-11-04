<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\AbstractFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class MainCategoryFormValidation extends AbstractFormRequest
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
            'name_en' => ['required','string'],
            'name_ar' => ['required','string'],
            'parent_id' => ['nullable' , 'numeric','exists:categories,id'],
            'brand_id' => ['nullable' , 'numeric','exists:brands,id','required_with:parent_id'],
            'image' => ['nullable' ,'image' , 'mimes:jpg,jpeg,gif,png,svg'],
        ];
    }
}
