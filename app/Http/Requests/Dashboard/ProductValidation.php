<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\AbstractFormRequest;

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
        return [

            'product_type' => ['required', 'in:clothes,jewellery,cosmetics'],
            'jewellery_type' => ['required_if:product_type,jewellery', 'in:ring,necklace,earing,bracelet'],

            'name_en' => ['required', 'string', 'max:250'],
            'name_ar' => ['required', 'string', 'max:250'],
            'desc_en' => ['required', 'string'],
            'desc_ar' => ['required', 'string'],
            'price' => ['required', 'string' , 'min:0'],
            'discount' =>  ['required', 'numeric' ,'min:0'],
            'country_id' => ['required', 'numeric'],

            'fit_size_desc_en' => ['nullable','string','required_if:product_type,jewellery','required_if:product_type,clothes'],
            'fit_size_desc_ar' => ['nullable','string','required_if:product_type,jewellery','required_if:product_type,clothes'],

            'ship_information_desc_en' => ['nullable','string','required_if:product_type,jewellery','required_if:product_type,clothes'],
            'ship_information_desc_ar' => ['nullable','string','required_if:product_type,jewellery','required_if:product_type,clothes'],

            'return_order_desc_en' => ['required','string','required_if:product_type,jewellery'],
            'return_order_desc_ar' => ['required','string','required_if:product_type,jewellery'],

            'ingredients_desc_en' => ['nullable','string','required_if:product_type,cosmetics'],
            'ingredients_desc_ar' => ['nullable','string','required_if:product_type,cosmetics'],

            'about_product_desc_en' => ['nullable','string','required_if:product_type,cosmetics'],
            'about_product_desc_ar' => ['nullable','string','required_if:product_type,cosmetics'],

            'dimension' =>  ['nullable','string','required_if:jewellery_type,ring','required_if:jewellery_type,earing'],

            'diamond_en' => ['nullable','string','required_if:jewellery_type,ring','required_if:jewellery_type,earing'],
            'diamond_ar' => ['nullable','string','required_if:jewellery_type,ring','required_if:jewellery_type,earing'],

            'metal_en' => ['nullable','required_if:product_type,jewellery','string'],
            'metal_en' => ['nullable','required_if:product_type,jewellery','string'],

            'chain_length' => ['nullable','required_if:jewellery_type,necklace', 'numeric'],


            'thumbnail' => ['required', 'image' ,'mimes:png,jpg,jpeg,svg,gif'],

            'images' => ['required', 'array'],
            'images.*' => ['required', 'image' ,'mimes:png,jpg,jpeg,svg,gif'],

            'variants' => ['required', 'array'],

            'variants.*.size_id' => ['required', 'numeric'],
            'variants.*.stock' => ['required', 'numeric'],

            'categories' => ['required', 'array'],
            'categories.*id' => ['required','numeric'],

            'brand_id' => ['nullable' , 'numeric'],

        ];
    }
}
