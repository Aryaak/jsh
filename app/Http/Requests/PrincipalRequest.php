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
            'info.email' => 'required|email',
            'info.phone' => 'required',
            'info.domicile' => 'required',
            'info.address' => 'required',
            'info.picName' => 'required',
            'info.picPosition' => 'required',
            'info.npwpNumber' => 'required',
            'info.npwpExpiredAt' => 'required|date',
            'info.nibNumber' => 'required',
            'info.nibExpiredAt' => 'required|date',
            'info.cityId' => 'required',
            'info.provinceId' => 'required',
            'info.jamsyarId' => 'required',
            'info.jamsyarCode' => 'required',
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
