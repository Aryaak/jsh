<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'title.*' => 'required',
            'text.*' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama',
            'title.*' => 'Judul',
            'text.*' => 'Template'
        ];
    }
}
