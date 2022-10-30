<?php

namespace Database\Seeders;

use DB;
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
                    // for ($i=0; $i < 5; $i++) {
                        $params[] = [
                            'min_value' => mt_rand(15000,5000000),
                            'rate_value' => (float)rand()/(float)getrandmax(),
                            'polish_cost' => mt_rand(5000,15000),
                            'stamp_cost' => mt_rand(5000,15000),
                            'desc' => "dummy",
                            'insurance_id' => $insurance->id,
                            'insurance_type_id' => $insuranceType->id,
                            'agent_id' => $agent->id
                        ];
                    // }
                }
            }
        }
        AgentRate::insert($params);
        DB::table('banks')->update(['created_at' => now(),'updated_at' => now()]);
    }
}
