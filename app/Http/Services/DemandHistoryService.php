<?php

namespace App\Http\Services;

use App\Models\Demand;
use App\Models\DemandHistory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DemandHistoryService
{
    /**
     * Lista todos os históricos de uma demanda com o usuário relacionado.
     */
    public function getByDemand(Demand $demand): Collection
    {
        return $demand->histories()
            ->with('user')
            ->latest()
            ->get();
    }

    /**
     * Cria um novo registro de histórico preenchendo o autor automaticamente.
     */
    public function store(Demand $demand, array $data): DemandHistory
    {
        return DB::transaction(function () use ($demand, $data) {
            return $demand->histories()->create([
                'type' => $data['type'] ?? 'COMMENT',
                'description' => $data['description'],
                'user_id' => auth()->id(),
                'user_name' => auth()->user()?->name ?? 'Sistema',
            ]);
        });
    }

    /**
     * Atualiza um registro de histórico existente.
     */
    public function update(DemandHistory $history, array $data): DemandHistory
    {
        return DB::transaction(function () use ($history, $data) {
            $history->update($data);

            return $history->refresh();
        });
    }

    /**
     * Remove um histórico.
     */
    public function delete(DemandHistory $history): void
    {
        $history->delete();
    }
}