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
        ];
    }
}
