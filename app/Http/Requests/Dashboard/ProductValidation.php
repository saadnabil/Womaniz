<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\AbstractFormRequest;
use App\Rules\CheckInsertProductCategories;
use App\Rules\Dashboard\CheckInsertedCategories;
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
            'categories' => ['required', 'array'],
            'categories.*.id' => ['required', 'numeric'],
            'name_en' => ['required', 'string', 'max:250'],
            'name_ar' => ['required', 'string', 'max:250'],
            'desc_en' => ['required', 'string'],
            'desc_ar' => ['required', 'string'],
            'price' => ['required', 'string' , 'min:0'],
            'discount' =>  ['required', 'numeric' ,'min:0'],
            'stock' => ['required','numeric','min:1'],
            'brand_id' => ['required' , 'numeric'],
            'model_id' => ['required'],
            'vendor_id' => ['nullable','numeric'],
            'specifications' => ['nullable', 'array'],
            'specifications.*.name_en' => ['nullable','string'],
            'specifications.*.name_ar' => ['nullable','string'],
            'specifications.*.value_en' => ['nullable','string'],
            'specifications.*.value_ar' => ['nullable','string'],
        ];

        if(request()->isMethod('post')){
            $data['thumbnail'] = ['required', 'image' ,'mimes:png,jpg,jpeg,svg,gif'];
            $data['images'] = ['required', 'array'];
            $data['images.*'] = ['required', 'image' ,'mimes:png,jpg,jpeg,svg,gif'];
            $data['seller_sku'] = ['required','string','unique:products,seller_sku'];

            /**in creation it must be unique */
            $data['variants'] = ['nullable', 'array'];
            $data['variants.*.sku'] = ['nullable', 'string','unique:product_variant_skus,sku'];
            $data['variants.*.size'] = ['nullable', 'string'];
            $data['variants.*.color'] = ['nullable', 'string'];
            $data[ 'variants.*.stock'] = ['nullable', 'numeric'];
            $data['variants.*.price'] = ['nullable', 'string'];
            $data['variants.*.discount'] = ['nullable', 'string'];
        }

        if(request()->isMethod('put')){
            $data['thumbnail'] = ['nullable', 'image' ,'mimes:png,jpg,jpeg,svg,gif'];
            $data['seller_sku'] = ['required','string','unique:products,seller_sku,'.$id];
         }

        return $data;
    }
}
