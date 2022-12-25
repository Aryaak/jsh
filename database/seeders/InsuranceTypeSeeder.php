<?php

namespace Database\Seeders;

use DB;
use App\Models\InsuranceType;
use Illuminate\Database\Seeder;

class InsuranceTypeSeeder extends Seeder
{
    public function run()
    {
        $params = [
            ['code' => 'PB','name' => 'Jaminan Pelaksanaan'],
            ['code' => 'MB','name' => 'Jaminan Pemeliharaan'],
            ['code' => 'BB','name' => 'Jaminan Penawaran'],
            ['code' => 'APB','name' => 'Jaminan Uang Muka']
        ];
        InsuranceType::insert($params);
        DB::table('insurance_types')->update(['created_at' => now(),'updated_at' => now()]);
    }
}
