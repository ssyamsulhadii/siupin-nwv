@props([
    'label' => 'Label', // Judul di atas radio button
    'model' => '', // Model Livewire (contoh: form.with_tanggal atau status)
    'name' => 'radio_group', // Atribut name/id unik untuk pembeda
    'option1Text' => 'Ya', // Teks pilihan pertama
    'option1Value' => '1', // Nilai pilihan pertama
    'option2Text' => 'Tidak', // Teks pilihan kedua
    'option2Value' => '0', // Nilai pilihan kedua
])

<div class="col-12">
    <label class="form-label fw-bold d-block">{{ $label }}</label>

    <!-- Pilihan Pertama -->
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="{{ $model }}" id="{{ $name }}_opt1"
            value="{{ $option1Value }}">
        <label class="form-check-label" for="{{ $name }}_opt1">
            {{ $option1Text }}
        </label>
    </div>

    <!-- Pilihan Kedua -->
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="{{ $model }}" id="{{ $name }}_opt2"
            value="{{ $option2Value }}">
        <label class="form-check-label" for="{{ $name }}_opt2">
            {{ $option2Text }}
        </label>
    </div>

    <!-- Menampilkan pesan error validasi otomatis -->
    @error($model)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
