<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\AbstractFormRequest;
use App\Rules\Dashboard\CheckSubTypeRule;

class ProductValidation extends AbstractFormRequest
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

            'product_type' => ['required','in:clothes,jewellery,cosmetics'],
            'product_sub_type' => ['required', new CheckSubTypeRule()],

            'name_en' => ['required', 'string', 'max:250'],
            'name_ar' => ['required', 'string', 'max:250'],

            'desc_en' => ['required', 'string'],
            'desc_ar' => ['required', 'string'],

            'price' => ['required', 'string' , 'min:0'],
            'discount' =>  ['required', 'numeric' ,'min:0'],

            'fit_size_desc_en' => ['nullable','string','required_if:product_type,jewellery','required_if:product_type,clothes'],
            'fit_size_desc_ar' => ['nullable','string','required_if:product_type,jewellery','required_if:product_type,clothes'],

            'ingredients_desc_en' => ['nullable','string','required_if:product_type,cosmetics'],
            'ingredients_desc_ar' => ['nullable','string','required_if:product_type,cosmetics'],

            'about_product_desc_en' => ['nullable','string','required_if:product_type,cosmetics'],
            'about_product_desc_ar' => ['nullable','string','required_if:product_type,cosmetics'],

            'dimension' =>  ['nullable','string','required_if:product_sub_type,ring','required_if:product_sub_type,earing'],

            'material_en' => ['nullable','required_if:product_type,jewellery','string'],
            'material_ar' => ['nullable','required_if:product_type,jewellery','string'],

            'chain_length' => ['nullable','required_if:product_sub_type,necklace', 'numeric'],

            'variants' => ['required', 'array'],
            'variants.*.size_id' => ['required', 'numeric'],
            'variants.*.stock' => ['required', 'numeric'],
            'variants.*.sku' => ['required', 'string'],

            'categories' => ['required', 'array'],
            'categories.*id' => ['required','numeric'],

            'brand_id' => ['nullable' , 'numeric'],

        ];

        if(request()->isMethod('post')){
            $data['thumbnail'] = ['required', 'image' ,'mimes:png,jpg,jpeg,svg,gif'];
            $data['images'] = ['required', 'array'];
            $data['images.*'] = ['required', 'image' ,'mimes:png,jpg,jpeg,svg,gif'];
        }

        if(request()->isMethod('put')){
            $data['thumbnail'] = ['nullable', 'image' ,'mimes:png,jpg,jpeg,svg,gif'];
            $data['images'] = ['nullable', 'array'];
             $data['images.*'] = ['nullable', 'image' ,'mimes:png,jpg,jpeg,svg,gif'];
         }

        return $data;
    }
}
