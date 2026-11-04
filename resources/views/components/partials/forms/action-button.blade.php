@props([
    'icon' => 'bi-pencil', // Default ikon
    'label' => 'Ubah', // Default teks
    'color' => 'warning', // Default warna (primary, danger, warning, info, success, dll)
    'wireClick' => '', // Aksi Livewire click
])

<button type="button"
    class="btn btn-light bg-{{ $color }} bg-opacity-10 text-{{ $color }} border-0 rounded-2 px-2 py-1 d-inline-flex flex-column align-items-center lh-sm"
    title="{{ $label }}" @if ($wireClick) wire:click="{{ $wireClick }}" @endif
    style="width: 50px;">
    <i class="bi {{ $icon }} fs-6"></i>
    <span style="font-size: 0.68rem; font-weight: 600; margin-top: -9px;">{{ $label }}</span>
</button>
