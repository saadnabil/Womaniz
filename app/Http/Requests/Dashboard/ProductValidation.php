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
        $id = $this->route('product')->id ?? null;
        $data =  [
            'name_en' => ['required', 'string', 'max:250'],
            'name_ar' => ['required', 'string', 'max:250'],
            'desc_en' => ['required', 'string'],
            'desc_ar' => ['required', 'string'],
            'price' => ['required', 'string' , 'min:0'],
            'discount' =>  ['required', 'numeric' ,'min:0'],
            'stock' => ['required','numeric','min:1'],
            'categories' => ['required', 'array'],
            'categories.*id' => ['required','numeric'],
            'brand_id' => ['nullable' , 'numeric'],
            'model_id' => ['required'],
            'vendor_id' => ['nullable','numeric'],
            'specifications' => ['nullable', 'array'],
            'specifications.*.name_en' => ['required_with:specifications.*.name_ar','required_with:specifications.*.value_en','required_with:specifications.*.value_ar','string'],
            'specifications.*.name_ar' => ['required_with:specifications.*.name_en','required_with:specifications.*.value_en','required_with:specifications.*.value_ar','string'],
            'specifications.*.value_en' => ['required_with:specifications.*.name_en','required_with:specifications.*.name_ar','required_with:specifications.*.value_ar','string'],
            'specifications.*.value_ar' => ['required_with:specifications.*.name_en','required_with:specifications.*.name_ar','required_with:specifications.*.value_en','string'],

            'variants' => ['nullable', 'array'],
            'variants.*.size' => ['nullable', 'string'],
            'variants.*.color' => ['nullable', 'string'],
            'variants.*.stock' => ['nullable', 'numeric'],
            'variants.*.sku' => ['nullable', 'string','unique:product_variant_skus,sku'],
            'variants.*.price' => ['nullable', 'string'],
            'variants.*.discount' => ['nullable', 'string'],

        ];

        if(request()->isMethod('post')){
            $data['thumbnail'] = ['required', 'image' ,'mimes:png,jpg,jpeg,svg,gif'];
            $data['images'] = ['required', 'array'];
            $data['images.*'] = ['required', 'image' ,'mimes:png,jpg,jpeg,svg,gif'];
            $data['seller_sku'] = ['required','string','unique:products,seller_sku'];


        }

        if(request()->isMethod('put')){
            $data['thumbnail'] = ['nullable', 'image' ,'mimes:png,jpg,jpeg,svg,gif'];
            $data['images'] = ['nullable', 'array'];
            $data['images.*'] = ['nullable', 'image' ,'mimes:png,jpg,jpeg,svg,gif'];
            $data['seller_sku'] = ['required','string','unique:products,seller_sku,'.$id];



         }

        return $data;
    }
}
