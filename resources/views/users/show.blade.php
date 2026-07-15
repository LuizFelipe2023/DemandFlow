@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
            <div>
                <h4 class="fw-bold text-primary mb-0">
                    <i class="bi bi-person-badge me-2"></i>Detalhes do Usuário #{{ sprintf('%03d', $user->id) }}
                </h4>
                <small class="text-muted">Informações detalhadas sobre o cadastro e perfil de acesso.</small>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Voltar
                </a>
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i> Editar
                </a>
            </div>
        </div>

        <div class="card-body p-4">
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded text-center border">
                        <div class="display-4 text-secondary mb-2">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                        <p class="text-muted small mb-2">{{ $user->email }}</p>
                        
                        <div>
                            @switch($user->type?->name)
                                @case('admin')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
                                        <i class="bi bi-shield-lock me-1"></i>Administrador
                                    </span>
                                    @break
                                @case('developer')
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
                                        <i class="bi bi-code-slash me-1"></i>Desenvolvedor
                                    </span>
                                    @break
                                @default
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2">
                                        <i class="bi bi-person me-1"></i>{{ ucfirst($user->type?->name ?? 'Usuário') }}
                                    </span>
                            @endswitch
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <h5 class="fw-bold text-dark mb-3">Informações Cadastrais</h5>
                    
                    <ul class="list-group list-group-flush border rounded">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted">
                                <i class="bi bi-hash me-2 text-primary"></i>ID
                            </span>
                            <span class="fw-bold">#{{ sprintf('%03d', $user->id) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted">
                                <i class="bi bi-person me-2 text-primary"></i>Nome Completo
                            </span>
                            <span class="fw-semibold">{{ $user->name }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted">
                                <i class="bi bi-envelope me-2 text-primary"></i>E-mail
                            </span>
                            <span class="fw-semibold">{{ $user->email }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted">
                                <i class="bi bi-patch-check me-2 text-primary"></i>Status da Conta
                            </span>
                            @if($user->email_verified_at)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="bi bi-check-circle me-1"></i>E-mail Verificado
                                </span>
                            @else
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">
                                    Pendente de Verificação
                                </span>
                            @endif
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted">
                                <i class="bi bi-calendar-event me-2 text-primary"></i>Data de Cadastro
                            </span>
                            <span class="fw-semibold">
                                {{ $user->created_at ? $user->created_at->format('d/m/Y \à\s H:i') : 'N/A' }}
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted">
                                <i class="bi bi-clock-history me-2 text-primary"></i>Última Atualização
                            </span>
                            <span class="fw-semibold">
                                {{ $user->updated_at ? $user->updated_at->format('d/m/Y \à\s H:i') : 'N/A' }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between align-items-center">
                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="btn btn-outline-danger" 
                            onclick="return confirm('Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.')">
                        <i class="bi bi-trash me-1"></i> Excluir Usuário
                    </button>
                </form>

                <a href="{{ route('users.index') }}" class="btn btn-light border">
                    Fechar
                </a>
            </div>

        </div>

    </div>
</div>
@endsection