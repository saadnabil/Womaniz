<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\AbstractFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class BookSalonStepOneValidation extends AbstractFormRequest
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
            'salon_id' => ['required','numeric'],
            'salon_branch_id' => ['required', 'numeric'],
            'salon_branch_service.*' => ['required', 'array'],
            'salon_branch_service.*.id' => ['required', 'numeric'],
        ];
    }
}
