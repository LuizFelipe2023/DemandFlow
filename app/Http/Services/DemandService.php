<?php

namespace App\Http\Services;

use App\Models\Demand;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DemandService
{
    public function __construct(
        protected DemandHistoryService $historyService
    ) {}

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return Demand::with('responsible')
            ->latest('demand_date')
            ->paginate($perPage);
    }

    public function findById(int $id): Demand
    {
        return Demand::with([
            'responsible',
            'histories' => fn ($query) => $query->with('user')->latest()
        ])->findOrFail($id);
    }

    public function store(array $data): Demand
    {
        return DB::transaction(function () use ($data) {
            $demand = Demand::create($data);

            $this->historyService->store($demand, [
                'type' => 'COMMENT',
                'description' => 'Demanda criada no sistema.'
            ]);

            return $demand;
        });
    }

    public function update(Demand $demand, array $data): Demand
    {
        return DB::transaction(function () use ($demand, $data) {
            $oldStatus = $demand->status;

            $demand->update($data);

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

    public function delete(Demand $demand): void
    {
        $demand->delete();
    }

    public function audit(Demand $demand, array $data): Demand
    {
        return DB::transaction(function () use ($demand, $data) {
            $approved = (bool) ($data['audit_approved'] ?? false);
            $justification = $approved ? null : ($data['justification'] ?? null);

            $demand->update([
                'is_audited'     => true,
                'audit_approved' => $approved,
                'justification'  => $justification,
            ]);

            $description = $approved
                ? 'Demanda auditada e LIBERADA pelo gerente.'
                : "Demanda auditada e RECUSADA. Motivo: {$justification}";

            $this->historyService->store($demand, [
                'type'        => 'AUDIT',
                'description' => $description,
            ]);

            return $demand->refresh();
        });
    }
}