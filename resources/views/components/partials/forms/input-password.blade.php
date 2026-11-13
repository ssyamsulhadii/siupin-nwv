@props([
    'name' => 'password',
    'label' => 'Password',
    'placeholder' => 'Masukkan password',
    'wireModel' => 'password',
    'id' => 'passwordInput',
])

<div class="mb-2">
    <label for="{{ $id }}" class="form-label fw-semibold small">{{ $label }}</label>
    <div class="input-group">
        <span class="input-group-text bg-light  @error($name) text-danger border-danger @else text-muted @enderror"><i
                class="bi bi-lock"></i></span>
        <input type="password" class="form-control border-end-0 @error($name) is-invalid @enderror"
            id="{{ $id }}" @if ($wireModel) wire:model="{{ $wireModel }}" @endif
            placeholder="{{ $placeholder }}">
        <button type="button"
            class="btn btn-outline-secondary border-start-0 bg-transparent text-muted toggle-password-btn no-hover-effect @error($name) text-danger border-danger @else text-muted @enderror"
            data-target="{{ $id }}" style="border-color: #dee2e6;">
            <i class="bi bi-eye toggle-icon"></i>
        </button>
    </div>
    @error($name)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
