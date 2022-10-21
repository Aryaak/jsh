<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'number' => 'required',
            'name_bank' => 'required',
            'agent_id' => 'required',
            'bank_id' => 'required',
        ];

    }
}
