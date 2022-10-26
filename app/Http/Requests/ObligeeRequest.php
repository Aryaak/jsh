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
            // 'name' => 'required',
            // 'address' => 'required',
            // 'pro' => 'required',
            // 'jamsyar_id' => 'required',
            // 'jamsyar_code' => 'required'
        ];

    }

    public function attributes()
    {
        return [
            // 'name' => 'Nama',
            // 'address' => 'Alamat',
            // 'type' => 'required',
            // 'jamsyar_id' => 'ID Jamsyar',
            // 'jamsyar_code' => 'required'
        ];
    }
}
