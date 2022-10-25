<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploaderRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'file' => ['required', 'file'],
        ];
    }
}
