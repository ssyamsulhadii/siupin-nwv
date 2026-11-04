@props(['name', 'label', 'rows', 'setcol' => 'col-12', 'phr' => ''])

<div class="{{ $setcol }}">
    <label class="form-label" for="{{ $name }}">{{ $label }}</label>
    <textarea wire:model="{{ $name }}" class="form-control @error($name) is-invalid @enderror" id="{{ $name }}"
        rows="{{ $rows }}" placeholder="{{ $phr }}"></textarea>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
