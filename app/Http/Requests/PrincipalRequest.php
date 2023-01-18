<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrincipalRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        // dd($this);
        return [
            'info.name' => 'required',
            'info.email' => 'nullable|email',
            'info.phone' => 'nullable',
            'info.domicile' => 'nullable',
            'info.address' => 'nullable',
            'info.picName' => 'nullable',
            'info.picPosition' => 'nullable',
            'info.npwpNumber' => 'nullable',
            'info.npwpExpiredAt' => 'nullable|date',
            'info.nibNumber' => 'nullable',
            'info.nibExpiredAt' => 'nullable|date',
            'info.cityId' => 'nullable',
            'info.provinceId' => 'nullable',
            'info.jamsyarId' => 'nullable',
            'info.jamsyarCode' => 'nullable',
            'scoring' => 'required|array',
            'certificate' => 'required|array',
        ];
    }
    public function attributes()
    {
        return [
            'info.name' => 'Nama',
            'info.email' => 'Email',
            'info.phone' => 'No Hp/Telp',
            'info.domicile' => 'Domisili',
            'info.address' => 'Alamat',
            'info.picName' => 'Nama PIC',
            'info.picPosition' => 'Jabatan PIC',
            'info.npwpNumber' => 'No NPWP',
            'info.npwpExpiredAt' => 'Tanggal Berakhir NPWP',
            'info.nibNumber' => 'No NIB',
            'info.nibExpiredAt' => 'Tanggal Berakhir NIB',
            'info.cityId' => 'Kota',
            'info.provinceId' => 'Provinsi',
            'info.jamsyarId' => 'Jamsyar ID',
            'info.jamsyarCode' => 'Jamsyar Kode',
            'scoring' => 'Scoring',
            'certificate' => 'Akta Pendirian'
        ];
    }
}
