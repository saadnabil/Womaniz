<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class BookSalonStepTwoValidation extends FormRequest
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
            'expert_id' => ['required', 'numeric'],
            'salon_branch_service.*' => ['required', 'array'],
            'salon_branch_service.*.id' => ['required', 'numeric'],
            'salon_branch_service.*.expert_id' => ['required', 'numeric'],
            // 'day' => ['required','date_format:Y/m/d'],
        ];
    }
}
