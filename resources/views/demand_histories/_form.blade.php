<div class="mb-3">
    <label class="form-label fw-semibold">Tipo da atualização</label>
    <select name="type" class="form-select @error('type') is-invalid @enderror">
        <option value="COMMENT" @selected(old('type', $history->type ?? '') == 'COMMENT')>
            Comentário
        </option>
        <option value="STATUS_CHANGE" @selected(old('type', $history->type ?? '') == 'STATUS_CHANGE')>
            Alteração de status
        </option>
        <option value="CORRECTION" @selected(old('type', $history->type ?? '') == 'CORRECTION')>
            Correção
        </option>
        <option value="DEPLOY" @selected(old('type', $history->type ?? '') == 'DEPLOY')>
            Deploy/Publicação
        </option>
    </select>
    @error('type')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Atualização</label>
    <textarea name="description"
              rows="4"
              maxlength="1000"
              class="form-control @error('description') is-invalid @enderror"
              placeholder="Descreva a atualização da demanda...">{{ old('description', $history->description ?? '') }}</textarea>
    
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <small class="text-muted d-block mt-1">
        <i class="bi bi-info-circle me-1"></i>A data e o autor serão registrados automaticamente.
    </small>
</div>

{{-- Botão de ação de largura total para a barra lateral --}}
<div class="d-grid mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-send me-1"></i> Registrar atualização
    </button>
</div>