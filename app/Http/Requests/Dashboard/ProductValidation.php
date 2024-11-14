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
        $id = $this->route('product')->id ?? null;

        $data =  [
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
        ];

        if(request()->isMethod('post')){
            $data['thumbnail'] =  ['required', 'image' ,'mimes:png,jpg,jpeg,svg,gif'];
            $data['images'] = ['required', 'array','max:4'];
            $data['images.*'] = ['required', 'image' ,'mimes:png,jpg,jpeg,svg,gif'];
            $data['seller_sku'] = ['required','string','unique:products,seller_sku'];
        }

        if(request()->isMethod('put')){
            $data['thumbnail'] =  ['nullable', 'image' ,'mimes:png,jpg,jpeg,svg,gif'];
            $data['images'] = ['nullable', 'array','max:4'];
            $data['images.*'] = ['nullable', 'image' ,'mimes:png,jpg,jpeg,svg,gif'];
            $data['thumbnail'] = ['nullable', 'image' ,'mimes:png,jpg,jpeg,svg,gif'];
            $data['seller_sku'] = ['required','string','unique:products,seller_sku,'.$id];
        }

        //  'categories' => ['required', 'array'],
        //  'categories.*.id' => ['required', 'numeric'],
        return $data;
    }
}
