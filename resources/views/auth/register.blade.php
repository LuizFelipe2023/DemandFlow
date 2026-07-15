@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 75vh;">
        <div class="col-12 col-md-8 col-lg-5">
            
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4 p-sm-5">
                    
                    <div class="text-center mb-4">
                        <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-person-plus fs-2"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-1">Criar Conta</h3>
                        <p class="text-muted small">Preencha os campos para se cadastrar</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-floating mb-3">
                            <input id="name" 
                                   type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Seu Nome"
                                   required 
                                   autocomplete="name" 
                                   autofocus>
                            <label for="name">
                                <i class="bi bi-person me-1"></i> Nome Completo
                            </label>
                            @error('name')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="email" 
                                   type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="nome@exemplo.com"
                                   required 
                                   autocomplete="email">
                            <label for="email">
                                <i class="bi bi-envelope me-1"></i> Endereço de E-mail
                            </label>
                            @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="password" 
                                   type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   placeholder="Sua senha"
                                   required 
                                   autocomplete="new-password">
                            <label for="password">
                                <i class="bi bi-lock me-1"></i> Senha
                            </label>
                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        
                        <div class="form-floating mb-4">
                            <input id="password-confirm" 
                                   type="password" 
                                   class="form-control" 
                                   name="password_confirmation" 
                                   placeholder="Confirme sua senha"
                                   required 
                                   autocomplete="new-password">
                            <label for="password-confirm">
                                <i class="bi bi-shield-lock me-1"></i> Confirmar Senha
                            </label>
                        </div>


                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold fs-6 shadow-sm">
                                Finalizar Cadastro <i class="bi bi-check-circle ms-1"></i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small">
                    Já possui uma conta? 
                    <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-bold">Faça login</a>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection