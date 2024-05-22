<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\AbstractFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class VendorFormValidation extends AbstractFormRequest
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
        $id = $this->route('vendor')->id ?? null;
        if(request()->isMethod('post')){
            return [
                'name' => ['required' , 'string' ,'max:255'],
                'contact_name' => ['required' , 'string' ,'max:255'],
                'email' => ['required' , 'email' ,'unique:vendors,email'],
                'password' => ['required' , 'string'],
                'phone' => ['required' , 'string' ],
                'image' => ['required', 'image' , 'mimes:png,jpg,jpeg,gif,svg'],
                'hq_address' => ['required' , 'string'],
                'shipping_address' => ['required' , 'string'],
                'commission' => ['required' , 'numeric', 'min:0','max:100'],
                'transfer_method' => ['required' , 'string', 'in:bank,iban,swift'],
                'bank_account_name' => ['required_if:transfer_method,bank' , 'string'],
                'account_number' =>  ['required_if:transfer_method,bank' , 'string'],
                'swift_number' =>  ['required_if:transfer_method,swift' , 'string'],
                'iban_number' =>  ['required_if:transfer_method,iban' , 'string' ],
                'categories' => ['required','array'],
                'categories.*' => ['required','numeric'],
            ];
        }else{
            return [
                'name' => ['required' , 'string' ,'max:255'],
                'contact_name' => ['required' , 'string' ,'max:255'],
                'email' => ['required' , 'email' ,'unique:vendors,email,'. $id],
                'password' => ['nullable' , 'string'],
                'phone' => ['required' , 'string' ],
                'image' => ['nullable', 'image' , 'mimes:png,jpg,jpeg,gif,svg'],
                'hq_address' => ['required' , 'string'],
                'shipping_address' => ['required' , 'string'],
                'commission' => ['required' , 'numeric', 'min:0','max:100'],
                'transfer_method' => ['required' , 'string', 'in:bank,iban,swift'],
                'bank_account_name' => ['required_if:transfer_method,bank' , 'string'],
                'account_number' =>  ['required_if:transfer_method,bank' , 'string'],
                'swift_number' =>  ['required_if:transfer_method,swift' , 'string'],
                'iban_number' =>  ['required_if:transfer_method,iban' , 'string', ],
                'categories' => ['required','array'],
                'categories.*' => ['required','numeric'],
            ];
        }

    }
}
