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
            ['code' => 'PB','name' => 'Pelaksanaan'],
            ['code' => 'MB','name' => 'Pemeliharaan'],
            ['code' => 'BB','name' => 'Penawaran'],
            ['code' => 'APB','name' => 'Uang Muka']
        ];
        InsuranceType::insert($params);
        DB::table('insurance_types')->update(['created_at' => now(),'updated_at' => now()]);
    }
}
