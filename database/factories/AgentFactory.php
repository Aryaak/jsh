<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agent;

/**
 * @extends Factory<Agent>
 */
class AgentFactory extends Factory
{
    protected $model = Agent::class;

    public function definition()
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'address' => fake()->address(),
            'identity_number' => fake()->nik(),
            'is_active' => 1,
            'is_verified' => 1,
            'jamsyar_username' => fake()->username(),
            'jamsyar_password' => 'password',
            'branch_id' => fake()->randomElement([2,3,4,5,6]),
        ];
    }
}
