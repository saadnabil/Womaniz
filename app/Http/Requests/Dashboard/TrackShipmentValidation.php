<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\AbstractFormRequest;

class TrackShipmentValidation extends AbstractFormRequest
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
            'awbNo'   => 'required|string',
            'passkey' => 'required|string',
        ];
    }
}
