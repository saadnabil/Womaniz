<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\AbstractFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class BookSalonValidation extends AbstractFormRequest
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
            'branch_id' => ['required', 'numeric'],
            'service_ids.*' => ['required', 'array'],
            'service_ids.*.id' => ['required', 'numeric'],
            'service_ids.*.expert_id' => ['required', 'numeric'],
            'service_ids.*.time' => ['required', 'date_format:h:i a'],
            'day' => ['required','date_format:Y/m/d'],
        ];
    }
}
