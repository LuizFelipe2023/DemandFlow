<?php

namespace App\Http\Controllers;

use App\Models\Demand;
use App\Models\DemandHistory;
use App\Http\Services\DemandHistoryService;
use App\Http\Requests\StoreDemandHistoryRequest;
use App\Http\Requests\UpdateDemandHistoryRequest;

class DemandHistoryController extends Controller
{
    protected DemandHistoryService $demandHistoryService;

    public function __construct(DemandHistoryService $demandHistoryService)
    {
        $this->demandHistoryService = $demandHistoryService;
    }

    /**
     * Armazena um novo histórico.
     */
    public function store(StoreDemandHistoryRequest $request, Demand $demand)
    {
        $this->demandHistoryService->store(
            $demand,
            $request->validated()
        );

        return redirect()
            ->route('demands.show', $demand)
            ->with('success', 'Histórico criado com sucesso!');
    }

    /**
     * Atualiza um histórico.
     */
    public function update(
        UpdateDemandHistoryRequest $request,
        Demand $demand,
        DemandHistory $history
    ) {
        $this->demandHistoryService->update(
            $history,
            $request->validated()
        );

        return redirect()
            ->route('demands.show', $demand)
            ->with('success', 'Histórico atualizado com sucesso!');
    }

    /**
     * Remove um histórico.
     */
    public function destroy(Demand $demand, DemandHistory $history)
    {
        $this->demandHistoryService->delete($history);

        return redirect()
            ->route('demands.show', $demand)
            ->with('success', 'Histórico removido com sucesso!');
    }
}