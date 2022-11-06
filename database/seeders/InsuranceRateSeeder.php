<?php

namespace Database\Seeders;

use DB;
use App\Models\InsuranceRate;
use App\Models\Insurance;
use App\Models\InsuranceType;
use Illuminate\Database\Seeder;

class InsuranceRateSeeder extends Seeder
{
    public function run()
    {
        $params = [];
        foreach (Insurance::all() as $insurance) {
            foreach (InsuranceType::all() as $insuranceType) {
                $params[] = [
                    'min_value' => mt_rand(150000,500000),
                    'rate_value' => 0.1,
                    'polish_cost' => mt_rand(5000,15000),
                    'stamp_cost' => mt_rand(5000,15000),
                    'desc' => "dummy",
                    'insurance_id' => $insurance->id,
                    'insurance_type_id' => $insuranceType->id
                ];
            }
        }
        InsuranceRate::insert($params);
        DB::table('banks')->update(['created_at' => now(),'updated_at' => now()]);
    }
}
