<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuretyBondRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'receiptNumber' => 'required',
            'bondNumber' => 'required',
            'polishNumber' => 'required',
            'agentId' => 'required',
            'insuranceId' => 'required',
            'insuranceTypeId' => 'required',
            'obligeeId' => 'required',
            'principalId' => 'required',
            'serviceCharge' => 'required|integer',
            'adminCharge' => 'required|integer',
            'contractValue' => 'required|integer',
            'insuranceValue' => 'required|integer',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'dueDayTolerance' => 'required|integer',
            'dayCount' => 'required|integer',
            'projectName' => 'required',
            'documentTitle' => 'required',
            'documentNumber' => 'required',
            'documentExpiredAt' => 'required|date',
            'scoring' => 'nullable|array',
        ];
    }
    public function attributes()
    {
        return [
            'receiptNumber' => 'No Kwitansi',
            'bondNumber' => 'No Bond',
            'polishNumber' => 'No Polis',
            'agentId' => 'Agen',
            'insuranceId' => 'Ansuransi',
            'insuranceTypeId' => 'Jenis Jaminan',
            'obligeeId' => 'Obligee',
            'principalId' => 'Principal',
            'serviceCharge' => 'Service Charge',
            'adminCharge' => 'Biaya Admin',
            'contractValue' => 'Nilai Kontrak',
            'insuranceValue' => 'Nilai Jaminan',
            'startDate' => 'Jangka Awal',
            'endDate' => 'Jangka Akhir',
            'dueDayTolerance' => 'Toleransi Jatuh Tempo',
            'dayCount' => 'Jumlah Hari',
            'projectName' => 'Nama Proyek',
            'documentTitle' => 'Dokumen Pendukung',
            'documentNumber' => 'Dokumen Pendukung',
            'documentExpiredAt' => 'Tanggal Berakhir Dokumen',
            'scoring' => 'Scoring Bank Garansi',
        ];
    }
}
