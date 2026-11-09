@props([
    'field',
    'label',
    'modalId',
    'folder',
    'pegawai' => null,
    'accept' => '.pdf',
    'maxSize' => '750KB',
    'formatText' => 'pdf',
])

<div class="mb-3">
    <label class="form-label" for="form_upload_dokumen.{{ $field }}">
        {{ $label }}
        <span class="small text-danger fw-bold">(Maks: {{ $maxSize }}, Format: {{ $formatText }})</span>
    </label>

    <div class="d-flex align-items-center gap-2">
        <input class="form-control @error('form_upload_dokumen.' . $field) is-invalid @enderror flex-grow-1"
            id="form_upload_dokumen.{{ $field }}" type="file" accept="{{ $accept }}"
            wire:model="form_upload_dokumen.{{ $field }}">

        @if ($form_upload_dokumen[$field] ?? false)
            <!-- KONDISI 1: File baru dipilih -->
            <button type="button" wire:click="uploadFile('{{ $field }}')" wire:loading.attr="disabled"
                class="btn btn-secondary text-white text-nowrap">
                <span wire:loading.remove wire:target="uploadFile('{{ $field }}')">
                    <i class="bi bi-upload me-1"></i> Upload
                </span>
                <span wire:loading wire:target="uploadFile('{{ $field }}')">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Menyimpan...
                </span>
            </button>
        @elseif (optional($pegawai?->dokumenPensiun)->{$field})
            <!-- KONDISI 2: Sudah ada file di DB -> Tombol Preview -->
            <button type="button"
                wire:click="previewFile('{{ $folder }}', '{{ $pegawai->dokumenPensiun->{$field} }}', '{{ $label }}')"
                class="btn btn-warning text-white text-nowrap">
                <i class="bi bi-eye me-1"></i> Preview
            </button>
        @else
            <!-- KONDISI 3: Belum ada file -->
            <button type="button" class="btn btn-outline-secondary text-nowrap" disabled>
                <i class="bi bi-upload me-1"></i> Upload
            </button>
        @endif
    </div>

    <!-- Error Handling -->
    @error('form_upload_dokumen.' . $field)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror

    <!-- Indikator Loading File Sementara -->
    <div wire:loading wire:target="form_upload_dokumen.{{ $field }}" class="text-primary small mt-1">
        <i class="spinner-border spinner-border-sm"></i> Sedang memproses file...
    </div>

    <!-- Pesan Sukses Upload -->
    @if (session()->has('upload_success_' . $field))
        <div class="text-success small mt-1 fw-semibold">
            <i class="bi bi-check-circle me-1"></i> {{ session('upload_success_' . $field) }}
        </div>
    @endif
</div>
