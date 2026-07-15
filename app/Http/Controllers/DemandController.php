<?php

namespace App\Http\Controllers;

use App\Http\Services\ReportService;
use App\Http\Services\UserService;
use App\Models\Demand;
use App\Http\Services\DemandService;
use App\Http\Requests\StoreDemandRequest;
use App\Http\Requests\UpdateDemandRequest;

class DemandController extends Controller
{
    protected DemandService $demandService;
    protected UserService $userService;

    protected ReportService $reportService;

    public function __construct(DemandService $demandService, UserService $userService, ReportService $reportService)
    {
        $this->demandService = $demandService;
        $this->userService = $userService;
        $this->reportService = $reportService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $demands = $this->demandService->getAll();

        return view('demands.index', compact('demands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = $this->userService->getAll();
        return view('demands.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDemandRequest $request)
    {
        $this->demandService->store($request->validated());

        return redirect()
            ->route('demands.index')
            ->with('success', 'Demanda criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Demand $demand)
    {
        $demand = $this->demandService->findById($demand->id);

        return view('demands.show', compact('demand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Demand $demand)
    {
        $users = $this->userService->getAll();
        return view('demands.edit', compact('demand', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDemandRequest $request, Demand $demand)
    {
        $this->demandService->update($demand, $request->validated());

        return redirect()
            ->route('demands.index')
            ->with('success', 'Demanda atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Demand $demand)
    {
        $this->demandService->delete($demand);

        return redirect()
            ->route('demands.index')
            ->with('success', 'Demanda removida com sucesso!');
    }

    public function generateDemandPdf($id)
    {
           return $this->reportService->generateDemandReport($id);
    }

}