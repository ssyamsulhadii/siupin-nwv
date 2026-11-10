@props(['name' => '', 'label' => '', 'setcol' => 'col-12', 'value' => ''])

<div class="{{ $setcol }} mb-3">
    @if ($label)
        <label class="form-label fw-semibold">{{ $label }}</label>
    @endif

    <!-- Menggunakan atribut disabled agar nilainya TIDAK dikirim ke server oleh browser -->
    <div class="p-2 px-3 bg-light border rounded text-dark fw-medium text-break">
        {{ $value }}
    </div>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
