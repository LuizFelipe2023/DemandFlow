@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">

    {{-- Breadcrumb e Botão Voltar --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('demands.index') }}">Demandas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Demanda #{{ $demand->id }}</li>
            </</ol>
        </nav>
        <a href="{{ route('demands.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>


    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
    
        <div class="col-lg-8 mb-4">

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <div>
                        <span class="badge bg-light text-muted border mb-1">#{{ sprintf('%03d', $demand->id) }}</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $demand->title }}</h4>
                    </div>

                    {{-- Grupo de botões ajustado com o botão de PDF --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('demands.pdf', $demand->id) }}" class="btn btn-outline-danger btn-sm" target="_blank">
                            <i class="bi bi-file-earmark-pdf me-1"></i> Gerar PDF
                        </a>
                        <a href="{{ route('demands.edit', $demand) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil me-1"></i> Editar
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6 col-md-4">
                            <small class="text-muted d-block fw-semibold text-uppercase fs-7">Sistema</small>
                            <span class="badge bg-light text-dark border">{{ $demand->system }}</span>
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <small class="text-muted d-block fw-semibold text-uppercase fs-7">Solicitante</small>
                            <span class="fw-semibold text-dark">{{ $demand->requester }}</span>
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <small class="text-muted d-block fw-semibold text-uppercase fs-7">Responsável</small>
                            @if($demand->responsible)
                                <span class="fw-semibold"><i class="bi bi-person me-1 text-secondary"></i>{{ $demand->responsible->name }}</span>
                            @else
                                <span class="text-muted fs-7"><em>Não atribuído</em></span>
                            @endif
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <small class="text-muted d-block fw-semibold text-uppercase fs-7">Data da Demanda</small>
                            <span><i class="bi bi-calendar3 me-1 text-secondary"></i>{{ $demand->demand_date->format('d/m/Y') }}</span>
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <small class="text-muted d-block fw-semibold text-uppercase fs-7">Prioridade</small>
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
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <small class="text-muted d-block fw-semibold text-uppercase fs-7">Status</small>
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
                        </div>
                    </div>

                    <hr class="text-muted opacity-25">

                    <div>
                        <small class="text-muted d-block fw-semibold text-uppercase fs-7 mb-2">Descrição</small>
                        <div class="p-3 bg-light rounded-3 text-secondary" style="white-space: pre-line;">{{ $demand->description }}</div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-clock-history me-2 text-primary"></i>Histórico da Demanda
                    </h5>
                </div>

                <div class="card-body p-4">
                    @forelse($demand->histories as $history)
                        <div class="border-start border-3 border-primary ps-3 mb-4 position-relative">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong class="text-dark d-block fs-6">{{ $history->type }}</strong>
                                    <small class="text-muted fs-7">
                                        <i class="bi bi-clock me-1"></i>{{ $history->created_at->format('d/m/Y H:i') }}
                                        @if($history->user_name)
                                            • <i class="bi bi-person me-1"></i>{{ $history->user_name }}
                                        @endif
                                    </small>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="button" 
                                            class="btn btn-sm btn-link text-primary p-0 opacity-75 opacity-100-hover"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editHistoryModal"
                                            data-history-id="{{ $history->id }}"
                                            data-history-type="{{ $history->type }}"
                                            data-history-description="{{ $history->description }}"
                                            data-history-old-status="{{ $history->old_status }}"
                                            data-history-new-status="{{ $history->new_status }}"
                                            title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <form action="{{ route('demands.histories.destroy', [$demand, $history]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-link text-danger p-0 opacity-75 opacity-100-hover" 
                                                onclick="return confirm('Deseja realmente remover este registro do histórico?')" 
                                                title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <p class="mt-2 mb-1 text-secondary">{{ $history->description }}</p>

                            @if($history->old_status && $history->new_status)
                                <div class="mt-1">
                                    <span class="badge bg-light text-muted border">{{ $history->old_status }}</span>
                                    <i class="bi bi-arrow-right mx-1 text-muted"></i>
                                    <span class="badge bg-light text-dark border">{{ $history->new_status }}</span>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="bi bi-chat-square-dots display-6 text-muted opacity-50"></i>
                            <p class="text-muted mt-2 mb-0">Nenhum histórico registrado até o momento.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-plus-circle me-2 text-primary"></i>Adicionar Atualização
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('demands.histories.store', $demand) }}" method="POST">
                        @csrf
                        @include('demand_histories._form')
                    </form>
                </div>
            </div>
        </div>

                    
        <div class="modal fade" id="editHistoryModal" tabindex="-1" aria-labelledby="editHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content shadow">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold text-dark" id="editHistoryModalLabel">
                            <i class="bi bi-pencil-square me-2 text-primary"></i>Editar Atualização
                        </h5>
                        <button type="button" class="btn-close" data-bs-close="modal" aria-label="Close"></button>
                    </div>
                    
                    <form id="editHistoryForm" method="POST" action="" data-demand-id="{{ $demand->id }}">
                        @csrf
                        @method('PUT')

                        <div class="modal-body">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tipo da atualização</label>
                                <select name="type" id="edit_type" class="form-select" required>
                                    <option value="COMMENT">Comentário</option>
                                    <option value="STATUS_CHANGE">Alteração de status</option>
                                    <option value="CORRECTION">Correção</option>
                                    <option value="DEPLOY">Deploy/Publicação</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Atualização</label>
                                <textarea name="description"
                                        id="edit_description"
                                        rows="4"
                                        maxlength="1000"
                                        class="form-control"
                                        placeholder="Descreva a atualização da demanda..." required></textarea>
                            </div>

                        </div>

                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-bs-close="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-1"></i> Salvar alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/demand_histories/editForm.js') }}"></script>

    </div>
</div>
@endsection