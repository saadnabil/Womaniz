<?php
namespace App\Http\Requests\Api\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreTest extends FormRequest
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
     protected function onCreate(){
        return [
            'image' => ['required','image', 'mimes:png,jpg,jpeg,giv'],
        ];
     }
     protected function onUpdate(){
        return [
            'image' => ['nullable','image', 'mimes:png,jpg,jpeg,giv'],
        ];
     }
    public function rules()
    {
        request()->isMethod('put') || request()->isMethod('patch') ?
                 $this->onUpdate() :   $this->onCreate();
    }

    public function attributes()
    {
        return [
            'image' => trans('admin.Image')
        ];
    }
}
