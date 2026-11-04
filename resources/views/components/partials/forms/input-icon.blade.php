@props(['name', 'label', 'type' => 'text', 'placeholder' => '', 'icon' => 'bi-person', 'wireModel' => null])

<div class="mb-2">
    <label for="{{ $name }}" class="form-label fw-semibold small">{{ $label }}</label>
    <div class="input-group">
        @if ($icon)
            <span
                class="input-group-text bg-light text-muted  @error($name) text-danger border-danger @else text-muted @enderror">
                <i class="bi {{ $icon }}"></i></span>
        @endif
        <input type="{{ $type }}" class="form-control @error($name) is-invalid @enderror" id="{{ $name }}"
            @if ($wireModel) wire:model="{{ $wireModel }}" @endif placeholder="{{ $placeholder }}"
            {{ $attributes }} required>
    </div>
    @error($name)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
