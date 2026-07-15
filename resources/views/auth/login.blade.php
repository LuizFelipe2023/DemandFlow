@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 75vh;">
        <div class="col-12 col-md-8 col-lg-5">
            
            {{-- Card Principal --}}
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4 p-sm-5">
                    
                    {{-- Cabeçalho / Branding --}}
                    <div class="text-center mb-4">
                        <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-box-arrow-in-right fs-2"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-1">Acessar Conta</h3>
                        <p class="text-muted small">Insira suas credenciais para continuar</p>
                    </div>

                    {{-- Formulário --}}
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Campo E-mail com Floating Label --}}
                        <div class="form-floating mb-3">
                            <input id="email" 
                                   type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="nome@exemplo.com"
                                   required 
                                   autocomplete="email" 
                                   autofocus>
                            <label for="email">
                                <i class="bi bi-envelope me-1"></i> Endereço de E-mail
                            </label>
                            @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        {{-- Campo Senha com Floating Label --}}
                        <div class="form-floating mb-3">
                            <input id="password" 
                                   type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   placeholder="Sua senha"
                                   required 
                                   autocomplete="current-password">
                            <label for="password">
                                <i class="bi bi-lock me-1"></i> Senha
                            </label>
                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        {{-- Lembrar-me e Esqueci a Senha --}}
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small text-secondary" for="remember">
                                    Lembrar de mim
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a class="text-decoration-none small text-primary fw-medium" href="{{ route('password.request') }}">
                                    Esqueceu a senha?
                                </a>
                            @endif
                        </div>

                        {{-- Botão de Entrar --}}
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold fs-6 shadow-sm">
                                Entrar <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            {{-- Link para Registro (Opcional) --}}
            @if (Route::has('register'))
                <div class="text-center mt-4">
                    <p class="text-muted small">
                        Não tem uma conta? 
                        <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-bold">Cadastre-se</a>
                    </p>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection