<?php

namespace Database\Seeders;

use App\Models\Demand;
use App\Models\DemandHistory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemandSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('Nenhum usuário encontrado. Execute a UserSeeder antes.');
            return;
        }

        Demand::factory(20)->create()->each(function (Demand $demand) use ($users) {
            
            DemandHistory::factory()->create([
                'demand_id'   => $demand->id,
                'user_id'     => $users->random()->id,
                'user_name'   => $users->random()->name,
                'type'        => 'COMMENT',
                'description' => 'Demanda registrada no sistema.',
                'created_at'  => $demand->demand_date,
            ]);

            if ($demand->is_audited) {
                DemandHistory::factory()->create([
                    'demand_id'   => $demand->id,
                    'user_id'     => $users->random()->id,
                    'user_name'   => $users->random()->name,
                    'type'        => 'AUDIT',
                    'description' => $demand->audit_approved
                        ? 'Demanda auditada e LIBERADA pelo gerente.'
                        : "Demanda auditada e RECUSADA. Motivo: {$demand->justification}",
                    'created_at'  => now(),
                ]);
            }

            DemandHistory::factory(rand(1, 3))->create([
                'demand_id' => $demand->id,
                'user_id'   => $users->random()->id,
            ]);
        });
    }
}