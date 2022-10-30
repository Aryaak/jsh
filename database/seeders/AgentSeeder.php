<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgentSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Agent::factory(10)->create();
    }
}
