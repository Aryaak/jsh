<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuretyBondDraftRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'branchId' => 'required',
            'receiptNumber' => 'required',
            'bondNumber' => 'required',
            'polishNumber' => 'required',
            'agentId' => 'required',
            'insuranceId' => 'required',
            'insuranceTypeId' => 'required',
            'obligeeId' => 'required',
            'principalId' => 'required',
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
        ];
    }
    public function attributes()
    {
        return [
            'branchId' => 'Cabang',
            'receiptNumber' => 'No Kwitansi',
            'bondNumber' => 'No Bond',
            'polishNumber' => 'No Polis',
            'agentId' => 'Agen',
            'insuranceId' => 'Ansuransi',
            'insuranceTypeId' => 'Jenis Jaminan',
            'obligeeId' => 'Obligee',
            'principalId' => 'Principal',
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
        ];
    }
}
