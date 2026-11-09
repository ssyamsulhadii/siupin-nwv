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
                @include('pages.usul-pensiun.partials.upload-item', [
                    'field' => 'supeng_instansi',
                    'label' => 'Surat Pengantar Instansi',
                    'folder' => 'supeng-instansi',
                    'modalId' => 'previewModalDokumen',
                ])

                {{-- @include('partials.upload-item', [
                    'field' => 'super_pemohon',
                    'label' => 'Surat Pernyataan Pemohon',
                    'folder' => 'super-pemohon',
                    'modalId' => 'previewModalDokumen',
                ]) --}}

                {{-- Dan seterusnya sampai 14 dokumen --}}

                {{-- <x-partials.display.upload-item field="supeng_instansi" label="Surat Pengantar Instansi"
                    modalId="supengInstansi" folder="supeng-instansi" />

                <x-partials.display.upload-item field="super_pemohon" label="Surat Pernyataan Pemohon"
                    modalId="superPemohon" folder="super-pemohon" />

                <x-partials.display.upload-item field="super_disiplin"
                    label="Surat Pernyataan Tidak Sedang Menjalani Hukuman Disiplin" modalId="superDisiplin"
                    folder="super-disiplin" />

                <!-- Khusus Pas Foto (Format JPG/JPEG) -->
                <x-partials.display.upload-item field="pas_foto" label="Pas Foto Terbaru" modalId="pasFoto"
                    folder="pas-foto" accept=".jpg,.jpeg" formatText="jpg, jpeg" /> --}}

                <!-- Dan seterusnya untuk dokumen lain... -->
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
