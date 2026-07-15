@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('demands.index') }}">Demandas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar #{{ $demand->id }}</li>
        </ol>
    </nav>

    <div class="card shadow-sm border-0">
        
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
            <h4 class="card-title fw-bold mb-0 text-primary">
                <i class="bi bi-pencil-square me-2"></i>Editar Demanda #{{ $demand->id }}
            </h4>
            
            <a href="{{ route('demands.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Voltar
            </a>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('demands.update', $demand) }}" method="POST">
                @csrf
                @method('PUT')

                @include('demands._form')
            </form>
        </div>

    </div>

</div>
@endsection