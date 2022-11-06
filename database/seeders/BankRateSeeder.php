<?php

namespace Database\Seeders;

use DB;
use App\Models\Bank;
use App\Models\BankRate;
use App\Models\Insurance;
use App\Models\InsuranceType;
use Illuminate\Database\Seeder;

class BankRateSeeder extends Seeder
{
    public function run()
    {
        $params = [];
        foreach (Bank::all() as $bank) {
            foreach (Insurance::all() as $insurance) {
                foreach (InsuranceType::all() as $insuranceType) {
                    $params[] = [
                        'min_value' => mt_rand(150000,500000),
                        'rate_value' => 0.1,
                        'polish_cost' => mt_rand(5000,15000),
                        'stamp_cost' => mt_rand(5000,15000),
                        'desc' => "dummy",
                        'bank_id' => $bank->id,
                        'insurance_id' => $insurance->id,
                        'insurance_type_id' => $insuranceType->id
                    ];
                }
            }
        }
        BankRate::insert($params);
        DB::table('bank_rates')->update(['created_at' => now(),'updated_at' => now()]);
    }
}
