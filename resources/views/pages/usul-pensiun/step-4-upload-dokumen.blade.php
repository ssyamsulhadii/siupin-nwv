<div class="panel needs-validation">
    <div class="panel-header">
        <h2 class="h5 mb-1 section-title"><i class="bi bi-ui-checks-grid" aria-hidden="true"></i>
            <span class="bg-warning-subtle p-1 rounded px-3">Form Upload Dokumen</span>
        </h2>
        <x-partials.feedback.alert />
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
            <!-- Kolom Kiri / Bagian 1 -->
            <div class="col-lg-6">
                @include('pages.usul-pensiun.partials.upload-item', [
                    'field' => 'supeng_instansi',
                    'label' => 'Surat Pengantar Instansi',
                    'folder' => 'supeng-instansi',
                ])

                @include('pages.usul-pensiun.partials.upload-item', [
                    'field' => 'super_pemohon',
                    'label' => 'Surat Pernyataan Pemohon',
                    'folder' => 'super-pemohon',
                ])

                @include('pages.usul-pensiun.partials.upload-item', [
                    'field' => 'super_disiplin',
                    'label' => 'Surat Pernyataan Tidak Sedang Menjalani Hukuman Disiplin',
                    'folder' => 'super-disiplin',
                ])

                @include('pages.usul-pensiun.partials.upload-item', [
                    'field' => 'super_pidana',
                    'label' => 'Surat Pernyataan Tidak Pernah Dipidana',
                    'folder' => 'super-pidana',
                ])

                @include('pages.usul-pensiun.partials.upload-item', [
                    'field' => 'sk_cpns',
                    'label' => 'SK CPNS',
                    'folder' => 'sk-cpns',
                ])

                @include('pages.usul-pensiun.partials.upload-item', [
                    'field' => 'sk_pns',
                    'label' => 'SK PNS',
                    'folder' => 'sk-pns',
                ])
            </div>

            <!-- Kolom Kanan / Bagian 2 -->
            <div class="col-lg-6">
                @include('pages.usul-pensiun.partials.upload-item', [
                    'field' => 'sk_pangkat_akhir',
                    'label' => 'SK Pangkat Terakhir',
                    'folder' => 'sk-pangkat-akhir',
                ])

                @include('pages.usul-pensiun.partials.upload-item', [
                    'field' => 'sk_pmk',
                    'label' => 'SK Peninjauan Masa Kerja (PMK) Opsional',
                    'folder' => 'sk-pmk',
                ])

                @include('pages.usul-pensiun.partials.upload-item', [
                    'field' => 'skp_tahunan',
                    'label' => 'SKP Tahunan Terakhir',
                    'folder' => 'skp-tahunan',
                ])

                @include('pages.usul-pensiun.partials.upload-item', [
                    'field' => 'foto_ktp',
                    'label' => 'Foto KTP',
                    'folder' => 'foto-ktp',
                ])

                @include('pages.usul-pensiun.partials.upload-item', [
                    'field' => 'foto_kk',
                    'label' => 'Foto Kartu Keluarga (KK)',
                    'folder' => 'foto-kk',
                ])

                <!-- Khusus Pas Foto: Atur format menjadi JPG/JPEG -->
                @include('pages.usul-pensiun.partials.upload-item', [
                    'field' => 'pas_foto',
                    'label' => 'Pas Foto Terbaru',
                    'folder' => 'pas-foto',
                    'accept' => '.jpg,.jpeg',
                    'formatText' => 'jpg, jpeg',
                ])
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-4">
        <button type="button" wire:click="previousStepFromFinal" class="btn btn-secondary me-2">
            &larr; Sebelumnya
        </button>
        <button type="button" wire:click="saveFinalData" class="btn btn-primary">Simpan & Selesai</button>
    </div>
</div>
