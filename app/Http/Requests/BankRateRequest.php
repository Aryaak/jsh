<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRateRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'minValue' => 'required|numeric',
            'rateValue' => 'required|numeric',
            'polishCost' => 'required|numeric',
            'stampCost' => 'required|numeric',
            'desc' => 'nullable',
            'bankId' => 'required',
            'insuranceId' => 'required',
            'insuranceTypeId' => 'required'
        ];
    }
}
