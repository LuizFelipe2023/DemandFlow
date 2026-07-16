@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/indexDemands.css') }}">
@section('content')
<div class="container-fluid py-3">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
            <div>
                <h4 class="fw-bold text-primary mb-0">
                    <i class="bi bi-kanban me-2"></i>Demandas
                </h4>
                <small class="text-muted">Gerencie e acompanhe o progresso das demandas do sistema.</small>
            </div>

            <a href="{{ route('demands.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Nova Demanda
            </a>
        </div>

        <div class="card-body p-0">
            @if($demands->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3" style="width: 70px;">#</th>
                                <th>Título</th>
                                <th>Sistema</th>
                                <th>Solicitante</th>
                                <th>Responsável</th>
                                <th>Prioridade</th>
                                <th>Status</th>
                                <th>Auditoria</th>
                                <th>Data</th>
                                <th class="text-center" style="width: 140px;">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($demands as $demand)
                                <tr>
                                    <td class="ps-3 fw-bold text-muted">
                                        #{{ sprintf('%03d', $demand->id) }}
                                    </td>

                                    <td class="text-wrap" style="max-width: 300px;">
                                        <a href="{{ route('demands.show', $demand) }}" class="text-decoration-none text-dark fw-bold">
                                            {{ $demand->title }}
                                        </a>
                                    </td>

                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $demand->system }}</span>
                                    </td>

                                    <td>{{ $demand->requester }}</td>

                                    <td>
                                        @if($demand->responsible)
                                            <i class="bi bi-person me-1 text-secondary"></i>{{ $demand->responsible->name }}
                                        @else
                                            <span class="text-muted small"><em>Não atribuído</em></span>
                                        @endif
                                    </td>

                                    <td>
                                        @switch($demand->priority)
                                            @case('High')
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Alta</span>
                                                @break
                                            @case('Medium')
                                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Média</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Baixa</span>
                                        @endswitch
                                    </td>

                                    <td>
                                        @switch($demand->status)
                                            @case('Open')
                                                <span class="badge bg-success">Aberta</span>
                                                @break
                                            @case('In Progress')
                                                <span class="badge bg-warning text-dark">Em andamento</span>
                                                @break
                                            @case('Completed')
                                                <span class="badge bg-primary">Concluída</span>
                                                @break
                                        @endswitch
                                    </td>

                                    {{-- Status de Auditoria --}}
                                    <td>
                                        @if($demand->is_audited)
                                            @if($demand->audit_approved)
                                                <span class="badge bg-success-subtle text-success border border-success-subtle" title="Auditada e Aprovada">
                                                    <i class="bi bi-shield-check me-1"></i>Aprovada
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle" title="Auditada e Reprovada">
                                                    <i class="bi bi-shield-x me-1"></i>Reprovada
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                                <i class="bi bi-clock me-1"></i>Pendente
                                            </span>
                                        @endif
                                    </td>

                                    <td>{{ $demand->demand_date->format('d/m/Y') }}</td>

                                    <td class="text-center pe-3">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border dropdown-toggle" 
                                                    type="button" 
                                                    data-bs-toggle="dropdown" 
                                                    data-bs-boundary="viewport"
                                                    aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i> Ações
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('demands.show', $demand) }}">
                                                        <i class="bi bi-eye text-secondary me-2"></i> Visualizar
                                                    </a>
                                                </li>

                                                {{-- Opção de Auditar (Mostra apenas se não tiver sido auditada ainda) --}}
                                                @if(!$demand->is_audited)
                                                    <li>
                                                        <button class="dropdown-item text-warning fw-semibold" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#auditModal{{ $demand->id }}">
                                                            <i class="bi bi-shield-check text-warning me-2"></i> Auditar
                                                        </button>
                                                    </li>
                                                @endif

                                                <li>
                                                    <a class="dropdown-item" href="{{ route('demands.pdf', $demand->id) }}" target="_blank">
                                                        <i class="bi bi-file-earmark-pdf text-danger me-2"></i> Gerar PDF
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item" href="{{ route('demands.edit', $demand) }}">
                                                        <i class="bi bi-pencil text-primary me-2"></i> Editar
                                                    </a>
                                                </li>

                                                <li><hr class="dropdown-divider"></li>

                                                {{-- Excluir --}}
                                                <li>
                                                    <form action="{{ route('demands.destroy', $demand) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="dropdown-item text-danger" 
                                                                onclick="return confirm('Tem certeza que deseja excluir esta demanda?')">
                                                            <i class="bi bi-trash me-2"></i> Excluir
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>

                                        {{-- Modal de Auditoria para esta demanda --}}
                                        @if(!$demand->is_audited)
                                            <div class="modal fade text-start" id="auditModal{{ $demand->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form action="{{ route('demands.audit', $demand) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            
                                                            <div class="modal-header">
                                                                <h5 class="modal-title fw-bold">
                                                                    <i class="bi bi-shield-check text-primary me-2"></i>Auditar Demanda #{{ sprintf('%03d', $demand->id) }}
                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <p class="mb-3"><strong>Título:</strong> {{ $demand->title }}</p>

                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Resultado da Auditoria</label>
                                                                    <div class="d-flex gap-3">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="audit_approved" id="approve{{ $demand->id }}" value="1" checked>
                                                                            <label class="form-check-label text-success fw-bold" for="approve{{ $demand->id }}">
                                                                                <i class="bi bi-check-circle me-1"></i>Aprovar
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="audit_approved" id="reject{{ $demand->id }}" value="0">
                                                                            <label class="form-check-label text-danger fw-bold" for="reject{{ $demand->id }}">
                                                                                <i class="bi bi-x-circle me-1"></i>Reprovar
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="justification{{ $demand->id }}" class="form-label fw-bold">Justificativa / Observações</label>
                                                                    <textarea name="justification" id="justification{{ $demand->id }}" class="form-control" rows="3" placeholder="Insira o motivo ou observações sobre a auditoria..."></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-primary">Salvar Auditoria</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($demands->hasPages())
                    <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                        {{ $demands->links() }}
                    </div>
                @endif

            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted opacity-50"></i>
                    <h4 class="mt-3 fw-bold">Nenhuma demanda cadastrada</h4>
                    <p class="text-muted">Clique no botão abaixo para registrar a primeira demanda.</p>
                    <a href="{{ route('demands.create') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-circle me-1"></i> Nova Demanda
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection