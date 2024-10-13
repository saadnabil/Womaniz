<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\AbstractFormRequest;

class CreateShipmentValidation extends AbstractFormRequest
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
            'passKey'    => 'required|string',
            'refNo'      => 'required|string',
            'sentDate'   => 'required|date|date_format:Y-m-d',
            'idNo'       => 'nullable|string',
            'cName'      => 'required|string',
            'cntry'      => 'required|string', //KSA, EG
            'cCity'      => 'required|string', //Cairo
            'cZip'       => 'required|string',
            'cPOBox'     => 'required|string',
            'cMobile'    => 'required|string|min:9',
            'cTel1'      => 'nullable|string',
            'cTel2'      => 'nullable|string',
            'cAddr1'     => 'required|string',
            'cAddr2'     => 'required|string',
            'shipType'   => 'required|string', //values should be in DLV,VAL,HAL
            'PCs'        => 'required|integer',
            'cEmail'     => 'nullable|string',
            'carrValue'  => 'nullable|integer',
            'carrCurr'   => 'nullable|string',
            'codAmt'     => 'required|integer',
            'weight'     => 'required|string',
            'custVal'    => 'nullable|string',
            'custCurr'   => 'nullable|string',
            'insrAmt'    => 'nullable|string',
            'insrCurr'   => 'nullable|string',
            'itemDesc'   => 'nullable|string',
            'vatValue'   => 'required|string',
            'harmCode'   => 'nullable|string',
        ];
    }
}
