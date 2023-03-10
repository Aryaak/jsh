<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsuranceRateRequest extends FormRequest
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
            'insuranceId' => 'required',
            'insuranceTypeId' => 'required'
        ];
    }
    public function attributes()
    {
        return [
            'minValue' => 'Nilai Minimal',
            'rateValue' => 'Nilai Rate',
            'polishCost' => 'Biaya Polish',
            'stampCost' => 'Materai',
            'desc' => 'Keterangan',
            'insuranceId' => 'Nama Asuransi',
            'insuranceTypeId' => 'Jenis Jaminan'
        ];
    }
}
