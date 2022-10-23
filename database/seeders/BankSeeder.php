<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bank;
use DB;

class BankSeeder extends Seeder
{
    public function run()
    {
        $params = [
            ['name' => 'Bank Central Asia'],
            ['name' => 'Bank Mandiri'],
            ['name' => 'Bank Danamon'],
            ['name' => 'Bank Nasional Indonesia'],
            ['name' => 'Bank Rakyat Indonesia'],
            ['name' => 'Bank Jago'],
        ];
        Bank::insert($params);
        DB::table('banks')->update(['created_at' => now(),'updated_at' => now()]);
    }
}
