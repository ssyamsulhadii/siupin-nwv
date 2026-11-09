<div class="panel needs-validation">
    <div class="panel-header">
        <h2 class="h5 mb-1 section-title"><i class="bi bi-ui-checks-grid" aria-hidden="true"></i>
            <span class="bg-warning-subtle p-1 rounded px-3">Form Upload Dokumen</span>
        </h2>
    </div>
    <div class="row g-3">
        {{-- Data Diri Mapping --}}
        <div class="row">
            <div class="col-lg-3 mb-3">
                <x-partials.forms.input name="data_mapping.nama" label="Nama" wire:model="data_mapping.nama"
                    disabled></x-partials.forms.input>
            </div>
            <div class="col-lg-3 mb-3">
                <x-partials.forms.input name="data_mapping.nip" label="NIP" wire:model="data_mapping.nip"
                    disabled></x-partials.forms.input>
            </div>
            <div class="col-lg-3 mb-3">
                <x-partials.forms.input name="data_mapping.nkk" label="NKK" wire:model="data_mapping.nkk"
                    disabled></x-partials.forms.input>
            </div>
            <div class="col-lg-3 mb-3">
                <x-partials.forms.input name="data_mapping.nik" label="NIK" wire:model="data_mapping.nik"
                    disabled></x-partials.forms.input>
            </div>
        </div>
        {{-- Data Diri Input --}}
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="form_upload_dokumen.supeng_instansi">Surat Pengantar Instansi <span
                            class="small text-danger fw-bold">(Maks: 1MB, Format: pdf)</span></label>
                    <div class="d-flex align-items-center gap-2">
                        <input
                            class="form-control @error('form_upload_dokumen.supeng_instansi') is-invalid @enderror flex-grow-1"
                            id="form_upload_dokumen.supeng_instansi" type="file" accept=".pdf"
                            wire:model="form_upload_dokumen.supeng_instansi">

                        @if ($form_upload_dokumen['supeng_instansi'])
                            <!-- KONDISI 1: File baru dipilih -> Tampilkan tombol UPLOAD -->
                            <button type="button" wire:click="uploadFile" wire:loading.attr="disabled"
                                class="btn btn-secondary text-white text-nowrap">
                                <span wire:loading.remove wire:target="uploadFile">
                                    <i class="bi bi-upload me-1"></i> Upload
                                </span>
                                <span wire:loading wire:target="uploadFile">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Menyimpan...
                                </span>
                            </button>
                        @elseif (optional($pegawai->dokumenPensiun)->supeng_instansi)
                            <!-- KONDISI 2: Sudah ada file tersimpan & tidak sedang memilih file baru -> Tampilkan PREVIEW -->
                            <button type="button"
                                wire:click="previewFile('supengInstansi','supeng-instansi', '{{ $pegawai->dokumenPensiun->supeng_instansi }}')"
                                class="btn btn-warning text-white text-nowrap">
                                <i class="bi bi-eye me-1"></i> Preview
                            </button>
                        @else
                            <!-- KONDISI 3: Belum ada file sama sekali -> Tombol Upload Disabled -->
                            <button type="button" class="btn btn-outline-secondary text-nowrap" disabled>
                                <i class="bi bi-upload me-1"></i> Upload
                            </button>
                        @endif
                    </div>

                    <!-- Error Handling -->
                    @error('form_upload_dokumen.supeng_instansi')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    <!-- Indikator Loading saat file dipilih (proses temporary) -->
                    <div wire:loading wire:target="form_upload_dokumen.supeng_instansi" class="text-primary small mt-1">
                        <i class="spinner-border spinner-border-sm"></i> Sedang memproses file...
                    </div>

                    <!-- Pesan Sukses Upload -->
                    @if (session()->has('upload_success'))
                        <div class="text-success small mt-1 fw-semibold">
                            <i class="bi bi-check-circle me-1"></i> {{ session('upload_success') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-4">
        <button type="button" wire:click="previousStepFromFinal" class="btn btn-secondary me-2">
            &larr; Sebelumnya
        </button>
        <button type="button" wire:click="saveFinalData" class="btn btn-primary">Simpan</button>
    </div>
</div>
