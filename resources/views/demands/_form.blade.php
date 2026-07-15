<div class="mb-3">
    <label class="form-label">Título</label>
    <input type="text"
           name="title"
           class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $demand->title ?? '') }}">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Descrição</label>
    <textarea name="description"
              rows="5"
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $demand->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Sistema</label>
        <input type="text"
               name="system"
               class="form-control @error('system') is-invalid @enderror"
               value="{{ old('system', $demand->system ?? '') }}">
        @error('system')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Solicitante</label>
        <input type="text"
               name="requester"
               class="form-control @error('requester') is-invalid @enderror"
               value="{{ old('requester', $demand->requester ?? '') }}">
        @error('requester')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Data da Demanda</label>
        <input type="date"
               name="demand_date"
               class="form-control @error('demand_date') is-invalid @enderror"
               value="{{ old('demand_date', isset($demand->demand_date) ? $demand->demand_date->format('Y-m-d') : now()->format('Y-m-d')) }}">
        @error('demand_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Prioridade</label>
        <select name="priority" class="form-select @error('priority') is-invalid @enderror">
            <option value="Low" @selected(old('priority', $demand->priority ?? '') == 'Low')>Baixa</option>
            <option value="Medium" @selected(old('priority', $demand->priority ?? 'Medium') == 'Medium')>Média</option>
            <option value="High" @selected(old('priority', $demand->priority ?? '') == 'High')>Alta</option>
        </select>
        @error('priority')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Responsável</label>
        <select name="responsible_id" class="form-select @error('responsible_id') is-invalid @enderror">
            <option value="">Selecione um responsável...</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" @selected(old('responsible_id', $demand->responsible_id ?? '') == $user->id)>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        @error('responsible_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-4">
    <label class="form-label">Status</label>
    <select name="status" class="form-select @error('status') is-invalid @enderror">
        <option value="Open" @selected(old('status', $demand->status ?? 'Open') == 'Open')>Aberta</option>
        <option value="In Progress" @selected(old('status', $demand->status ?? '') == 'In Progress')>Em andamento</option>
        <option value="Completed" @selected(old('status', $demand->status ?? '') == 'Completed')>Concluída</option>
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex justify-content-end">
    <a href="{{ route('demands.index') }}" class="btn btn-secondary me-2">Cancelar</a>
    <button class="btn btn-primary">
        <i class="bi bi-check-circle me-1"></i> Salvar
    </button>
</div>