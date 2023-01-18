<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsuranceRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'alias' => 'required',
            'address' => 'required',
            'pc_name' => 'required',
            'pc_position' => 'required',
        ];
    }
    public function attributes(): array
    {
        return [
            'name' => 'Nama',
            'alias' => 'Alias',
            'address' => 'Alamat',
            'pc_name' => 'Nama PIC',
            'pc_position' => 'Jabatan PIC',
        ];
    }
}
