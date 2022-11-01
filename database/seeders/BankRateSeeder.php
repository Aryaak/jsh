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
                        'min_value' => mt_rand(15000,5000000),
                        'rate_value' => (float)rand()/(float)getrandmax(),
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