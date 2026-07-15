<?php

namespace App\Http\Services;

use App\Models\Demand;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DemandService
{
    /**
     * Injeta a dependência do service especialista em histórico.
     */
    public function __construct(
        protected DemandHistoryService $historyService
    ) {}

    /**
     * Retorna as demandas paginadas e otimizadas com o responsável.
     */
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return Demand::with('responsible')
            ->latest('demand_date')
            ->paginate($perPage);
    }

    /**
     * Busca uma demanda com o responsável e históricos (com o autor do histórico).
     */
    public function findById(int $id): Demand
    {
        return Demand::with([
            'responsible',
            'histories' => fn ($query) => $query->with('user')->latest()
        ])->findOrFail($id);
    }

    /**
     * Cria a demanda e registra o primeiro histórico reutilizando o DemandHistoryService.
     */
    public function store(array $data): Demand
    {
        return DB::transaction(function () use ($data) {
            $demand = Demand::create($data);

            // Reutiliza o Service de Histórico
            $this->historyService->store($demand, [
                'type' => 'COMMENT',
                'description' => 'Demanda criada no sistema.'
            ]);

            return $demand;
        });
    }

    /**
     * Atualiza a demanda e registra alteração de status via DemandHistoryService.
     */
    public function update(Demand $demand, array $data): Demand
    {
        return DB::transaction(function () use ($demand, $data) {
            $oldStatus = $demand->status;

            $demand->update($data);

            // Se o status mudou, delega a criação do histórico para o service especializado
            if (isset($data['status']) && $oldStatus !== $demand->status) {
                $this->historyService->store($demand, [
                    'type' => 'STATUS_CHANGE',
                    'description' => "Status alterado de '{$oldStatus}' para '{$demand->status}'.",
                    'old_status' => $oldStatus,
                    'new_status' => $demand->status,
                ]);
            }

            return $demand->refresh();
        });
    }

    /**
     * Remove a demanda.
     */
    public function delete(Demand $demand): void
    {
        $demand->delete();
    }
}