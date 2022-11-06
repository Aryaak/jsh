<?php

namespace Database\Seeders;

use DB;
use App\Models\Bank;
use App\Models\Agent;
use App\Models\AgentRate;
use App\Models\Insurance;
use App\Models\InsuranceType;
use Illuminate\Database\Seeder;

class AgentRateSeeder extends Seeder
{
    public function run()
    {
        $params = [];

        foreach (Agent::all() as $agent) {
            foreach (Insurance::all() as $insurance) {
                foreach (InsuranceType::all() as $insuranceType) {
                    $params[] = [
                        'min_value' => mt_rand(15000,500000),
                        'rate_value' => 0.9,
                        'polish_cost' => mt_rand(5000,15000),
                        'stamp_cost' => mt_rand(5000,15000),
                        'desc' => "dummy",
                        'insurance_id' => $insurance->id,
                        'insurance_type_id' => $insuranceType->id,
                        'agent_id' => $agent->id,
                        'bank_id' => null,
                    ];
                }
            }
        }
        foreach (Bank::all() as $bank) {
            foreach (Agent::all() as $agent) {
                foreach (Insurance::all() as $insurance) {
                    foreach (InsuranceType::all() as $insuranceType) {
                        $params[] = [
                            'min_value' => mt_rand(15000,500000),
                            'rate_value' => 0.9,
                            'polish_cost' => mt_rand(5000,15000),
                            'stamp_cost' => mt_rand(5000,15000),
                            'desc' => "dummy",
                            'insurance_id' => $insurance->id,
                            'insurance_type_id' => $insuranceType->id,
                            'agent_id' => $agent->id,
                            'bank_id' => $bank->id,
                        ];
                    }
                }
            }
        }

        AgentRate::insert($params);
        DB::table('banks')->update(['created_at' => now(),'updated_at' => now()]);
    }
}
