<?php

namespace App\Http\Services;
use App\Models\Demand;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class ReportService
{
    protected DemandService $demandService;

    public function __construct(DemandService $demandService)
    {
        $this->demandService = $demandService;
    }

    public function generateDemandReport($id)
    {
        $demand = $this->demandService->findById($id);
        $pdf = Pdf::loadView('demands.report', compact('demand'));
        $sistema = Str::slug($demand->system);
        $solicitante = Str::slug($demand->requester);
        return $pdf->download("{$sistema}-{$solicitante}-demanda-{$demand->id}.pdf");
    }
}