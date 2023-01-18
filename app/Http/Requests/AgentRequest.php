<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgentRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'branch_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'identity_number' => 'required',
            'address' => 'required',
            'number' => 'required',
            'name_bank' => 'required',
            'bank_id' => 'required',
            'is_active' => 'required',
            'is_verified' => 'required',
        ];
    }
    public function attributes(): array
    {
        return [
            'branch_id' => 'Cabang',
            'name' => 'Nama',
            'phone' => 'No HP',
            'email' => 'Alamat Email',
            'identity_number' => 'Nomor Identitas',
            'address' => 'Alamat',
            'bank_id' => 'Nama Bank',
            'number' => 'No. Rekening',
            'name_bank' => 'Atas Nama Rekening',
            'is_active' => 'Sudah Aktif',
            'is_verified' => 'Sudah Verifikasi',
        ];
    }
}
