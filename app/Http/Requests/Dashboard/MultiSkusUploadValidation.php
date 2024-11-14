<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\AbstractFormRequest;
use App\Rules\Dashboard\CheckSubTypeRule;
use App\Rules\ProductExistValidation;

class MultiSkusUploadValidation extends AbstractFormRequest
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
        $data['product_id'] =  ['required', 'numeric'];
        $data['skus.*.stock'] = ['required', 'numeric'];
        $data['skus.*.price'] = ['required', 'string'];
        $data['skus.*.discount'] = ['required', 'string'];
        $data['skus.*.sku'] = ['required', 'string','unique:product_variant_skus,sku'];
        $data['skus.*.color'] = ['required', 'string'];
        $data['skus.*.size'] = ['required', 'string'];
        return $data;
    }
}
