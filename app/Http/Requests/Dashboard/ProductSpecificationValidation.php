<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\AbstractFormRequest;
use App\Rules\Dashboard\CheckSubTypeRule;
use App\Rules\ProductExistValidation;

class ProductSpecificationValidation extends AbstractFormRequest
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
            'name_en' => ['required','string','max:250'],
            'name_ar' => ['required','string','max:250'],
            'value_en' => ['required','string','max:250'],
            'value_ar' => ['required','string','max:250'],

        ];
        if(request()->isMethod('post')){
            $data['product_id'] = ['required', 'numeric'];
        }
        return $data;
    }
}
