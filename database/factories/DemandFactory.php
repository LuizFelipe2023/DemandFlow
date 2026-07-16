<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DemandFactory extends Factory
{
    public function definition(): array
    {
        $isAudited = fake()->boolean(60);
        $auditApproved = $isAudited ? fake()->boolean(75) : null;

        return [
            'title'          => fake()->sentence(4),
            'description'    => fake()->paragraph(3),
            'requester'      => fake()->name(),
            'responsible_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'system'         => fake()->randomElement(['ERP', 'CRM', 'Portal do Cliente', 'App Mobile']),
            'priority'       => fake()->randomElement(['Low', 'Medium', 'High']),
            'status'         => fake()->randomElement(['Open', 'In Progress', 'Completed']),
            'demand_date'    => fake()->dateTimeBetween('-2 months', 'now'),
            'is_audited'     => $isAudited,
            'audit_approved' => $auditApproved,
            'justification'  => ($isAudited && !$auditApproved) ? fake()->realText(120) : null,
        ];
    }

    public function pendingAudit(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_audited'     => false,
            'audit_approved' => null,
            'justification'  => null,
        ]);
    }
}