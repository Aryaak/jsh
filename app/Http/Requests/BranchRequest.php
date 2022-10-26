<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'is_regional' => 'required',
            'jamsyar_username' => 'required_if:is_regional,1',
            'jamsyar_password' => 'required_if:is_regional,1',
            'regionalId' => 'required_if:is_regional,0'
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'Nama',
            'jamsyar_username' => 'Jamsyar Username',
            'jamsyar_password' => 'Jamsyar Password',
            'regionalId' => 'Regional'
        ];
    }
    public function messages()
    {
        return [
            'jamsyar_username.required_if' => ':attribute harus diisi',
            'jamsyar_password.required_if' => ':attribute harus diisi',
        ];
    }
}
