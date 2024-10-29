<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\AbstractFormRequest;
use App\Rules\Dashboard\CheckSubTypeRule;
use App\Rules\ProductExistValidation;

class ProductVariantSkuValidation extends AbstractFormRequest
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
        $id = $this->route('product_variant_sku')->id ?? null;
        $data['stock'] = ['required', 'numeric'];
        $data['price'] = ['required', 'string'];
        $data['discount'] = ['required', 'string'];
        if(request()->isMethod('post')){
            $data['sku'] = ['required', 'string','unique:product_variant_skus,sku'];
            $data['color'] = ['required', 'string'];
            $data['size'] = ['required', 'string'];
            $data['product_id'] = ['required', 'numeric'];
        }
        if(request()->isMethod('put')){
            $data['sku'] = ['required', 'string','unique:product_variant_skus,sku,'.$id];
        }
        return $data;
    }
}
