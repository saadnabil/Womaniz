<?php
namespace App\Http\Requests\Dashboard;
use App\Http\Requests\AbstractFormRequest;
use App\Rules\Dashboard\ValidateIsLastLevelCategory;

class UpdateProductCategoriesValidation extends AbstractFormRequest
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
        return[
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'numeric', new ValidateIsLastLevelCategory],
        ];
    }
}
