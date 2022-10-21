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
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'identity_number' => 'required',
            'is_active' => 'required',
            'is_verified' => 'required',
            'jamsyar_username' => 'required',
            'jamsyar_password' => 'required',
            'branch_id' => 'required',
        ];

    }
}
