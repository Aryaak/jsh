<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            BankSeeder::class,
            ProvinceSeeder::class,
            BranchSeeder::class,
            CitySeeder::class,
            AgentSeeder::class,
            InsuranceSeeder::class,
            InsuranceTypeSeeder::class,
            ObligeeSeeder::class,
            PrincipalSeeder::class,
            InsuranceRateSeeder::class,
            AgentRateSeeder::class,
            StatusSeeder::class,
            ScoringSeeder::class,
            BankRateSeeder::class,
            SuretyBondSeeder::class,
            GuaranteeBankSeeder::class,
            TemplateSeeder::class,
        ]);
    }
}
