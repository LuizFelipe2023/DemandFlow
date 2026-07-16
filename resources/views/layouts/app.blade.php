<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DemandFlow') }}</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-2">
        <div class="container">

            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('demands.index') }}">
                <i class="bi bi-kanban me-2 text-primary fs-4"></i>
                <span>Demand<span class="text-primary">Flow</span></span>
            </a>

            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                    @auth
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('demands.index*') ? 'active fw-semibold' : '' }}"
                           href="{{ route('demands.index') }}">
                            <i class="bi bi-list-task me-1"></i> Demandas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('demands.create') ? 'active fw-semibold' : '' }}"
                           href="{{ route('demands.create') }}">
                            <i class="bi bi-plus-circle me-1"></i> Nova Demanda
                        </a>
                    </li>

                    @if(Auth::user()->type?->name === 'admin')
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('users.*') ? 'active fw-semibold' : '' }}"
                           href="{{ route('users.index') }}">
                            <i class="bi bi-people me-1"></i> Usuários
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->is('log-viewer*') ? 'active fw-semibold' : '' }}"
                           href="{{ url('log-viewer') }}" 
                           target="_blank">
                            <i class="bi bi-journal-text me-1 text-warning"></i> Logs
                        </a>
                    </li>
                    @endif

                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto align-items-lg-center">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center text-white" 
                               href="#" 
                               id="userDropdown" 
                               role="button" 
                               data-bs-toggle="dropdown" 
                               aria-expanded="false">
                                <i class="bi bi-person-circle fs-5 me-2 text-secondary"></i>
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown">
                                <li>
                                    <span class="dropdown-item-text text-muted fs-7">
                                        {{ Auth::user()->email }}
                                    </span>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('users.show', Auth::id()) }}">
                                        <i class="bi bi-person-badge me-2 text-secondary"></i> Meu Perfil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>

                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                                            <i class="bi bi-box-arrow-right me-2"></i> Sair
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                            </a>
                        </li>
                    @endauth
                </ul>

            </div>

        </div>
    </nav>

    <main class="py-4 flex-grow-1">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="bg-white border-top py-3 mt-auto">
        <div class="container text-center text-muted fs-7">
            <small>&copy; {{ date('Y') }} <strong>DemandFlow</strong> — Gerenciamento de Demandas</small>
        </div>
    </footer>

</body>

</html>