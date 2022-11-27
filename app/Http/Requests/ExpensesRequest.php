<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpensesRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'nominal' => 'required',
            'transaction_date' => 'required|date',
        ];

    }
    public function attributes()
    {
        return [
            'title' => 'Judul',
            'description' => 'Keterangan',
            'nominal' => 'Nominal',
            'transaction_date' => 'Tanggal',
        ];
    }
}
