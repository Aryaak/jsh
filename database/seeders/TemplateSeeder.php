<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run()
    {
        Template::create([
            'title' => "Kwitansi",
            'text' => '',
        ]);

        Template::create([
            'title' => "Surat Permohonan",
            'text' => '',
        ]);
    }
}
