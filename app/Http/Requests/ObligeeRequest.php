<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObligeeRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'address' => 'required',
            'type' => 'nullable',
            'city_id' => 'nullable',
            'jamsyar_id' => 'nullable',
            'jamsyar_code' => 'nullable'
        ];

    }

    public function attributes()
    {
        return [
            'name' => 'Nama',
            'address' => 'Alamat',
            'type' => 'Jenis',
            'city_id' => 'Kota',
            'jamsyar_id' => 'ID Jamsyar',
            'jamsyar_code' => 'Kode Jamsyar'
        ];
    }
}
