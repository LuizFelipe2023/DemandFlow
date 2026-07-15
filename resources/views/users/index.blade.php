@extends('layouts.app')

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
                    <i class="bi bi-people me-2"></i>Usuários
                </h4>
                <small class="text-muted">Gerencie os usuários e os privilégios de acesso do sistema.</small>
            </div>

            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i> Novo Usuário
            </a>
        </div>

        <div class="card-body bg-light border-bottom py-3">
            <form action="{{ route('users.index') }}" method="GET">
                <div class="row g-2">
                    <div class="col-md-5 col-lg-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input 
                                type="text" 
                                name="search" 
                                class="form-control border-start-0 ps-0" 
                                placeholder="Buscar por nome ou e-mail..." 
                                value="{{ request('search') }}"
                            >
                            <button class="btn btn-primary" type="submit">
                                Buscar
                            </button>
                            @if(request('search'))
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary" title="Limpar busca">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            @if($users->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3" style="width: 70px;">#</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Tipo de Perfil</th>
                                <th>Status E-mail</th>
                                <th class="text-center" style="width: 140px;">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="ps-3 fw-bold text-muted">
                                        #{{ sprintf('%03d', $user->id) }}
                                    </td>

                                    <td>
                                        <div class="fw-bold text-dark">
                                            {{ $user->name }}
                                        </div>
                                    </td>

                                    <td>
                                        <i class="bi bi-envelope text-secondary me-1"></i>{{ $user->email }}
                                    </td>

                                    <td>
                                        @switch($user->type?->name)
                                            @case('admin')
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                                    <i class="bi bi-shield-lock me-1"></i>Admin
                                                </span>
                                                @break
                                            @case('developer')
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                                    <i class="bi bi-code-slash me-1"></i>Developer
                                                </span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                                    <i class="bi bi-person me-1"></i>{{ $user->type?->name ?? 'Padrão' }}
                                                </span>
                                        @endswitch
                                    </td>

                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                <i class="bi bi-patch-check me-1"></i>Verificado
                                            </span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">
                                                Pendente
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-center pe-3">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border dropdown-toggle" 
                                                    type="button" 
                                                    data-bs-toggle="dropdown" 
                                                    aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i> Ações
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('users.show', $user->id) }}">
                                                        <i class="bi bi-eye text-secondary me-2"></i> Visualizar
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">
                                                        <i class="bi bi-pencil text-primary me-2"></i> Editar
                                                    </a>
                                                </li>

                                                <li><hr class="dropdown-divider"></li>

                                                {{-- Excluir --}}
                                                <li>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="dropdown-item text-danger" 
                                                                onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                                            <i class="bi bi-trash me-2"></i> Excluir
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if(method_exists($users, 'hasPages') && $users->hasPages())
                    <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                @endif

            @else
                <div class="text-center py-5">
                    <i class="bi bi-person-x display-1 text-muted opacity-50"></i>
                    @if(request('search'))
                        <h4 class="mt-3 fw-bold">Nenhum usuário encontrado</h4>
                        <p class="text-muted">Não encontramos resultados para a busca "<strong>{{ request('search') }}</strong>".</p>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-primary mt-2">
                            <i class="bi bi-arrow-left me-1"></i> Limpar Pesquisa
                        </a>
                    @else
                        <h4 class="mt-3 fw-bold">Nenhum usuário cadastrado</h4>
                        <p class="text-muted">Clique no botão abaixo para registrar o primeiro usuário.</p>
                        <a href="{{ route('users.create') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-person-plus me-1"></i> Novo Usuário
                        </a>
                    @endif
                </div>
            @endif
        </div>

    </div>
</div>
@endsection