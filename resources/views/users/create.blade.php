@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
                <div>
                    <strong>Atenção!</strong> Por favor, corrija os erros no formulário abaixo.
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
            <div>
                <h4 class="fw-bold text-primary mb-0">
                    <i class="bi bi-person-plus me-2"></i>Novo Usuário
                </h4>
                <small class="text-muted">Preencha os campos abaixo para cadastrar um novo usuário no sistema.</small>
            </div>

            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Voltar
            </a>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="row g-3"> 
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-bold">Nome Completo <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-person text-secondary"></i></span>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name') }}" 
                                placeholder="Ex: João Silva" 
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

              
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-bold">E-mail <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-envelope text-secondary"></i></span>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                value="{{ old('email') }}" 
                                placeholder="usuario@empresa.com" 
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                
                    <div class="col-md-6">
                        <label for="password" class="form-label fw-bold">Senha <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-key text-secondary"></i></span>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                placeholder="Mínimo de 8 caracteres" 
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="user_type_id" class="form-label fw-bold">Perfil / Permissão <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-shield-lock text-secondary"></i></span>
                            <select name="user_type_id" id="user_type_id" class="form-select @error('user_type_id') is-invalid @enderror" required>
                                <option value="" disabled selected>Selecione um tipo de perfil...</option>
                                @foreach($userTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('user_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ ucfirst($type->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('users.index') }}" class="btn btn-light border">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Salvar Usuário
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection