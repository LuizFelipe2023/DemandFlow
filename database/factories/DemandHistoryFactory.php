<?php

namespace Database\Factories;

use App\Models\Demand;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
class DemandHistoryFactory extends Factory
{
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();

        return [
            'demand_id'   => Demand::factory(),
            'user_id'     => $user?->id,
            'user_name'   => $user?->name ?? fake()->name(),
            'type'        => fake()->randomElement(['COMMENT', 'STATUS_CHANGE', 'CORRECTION', 'DEPLOY', 'AUDIT']),
            'description' => fake()->sentence(8),
            'old_status'  => null,
            'new_status'  => null,
        ];
    }
}