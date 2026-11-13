<div class="panel needs-validation">
    <div class="panel-header">
        <h2 class="h5 mb-1 section-title"><i class="bi bi-ui-checks-grid" aria-hidden="true"></i>
            <span class="bg-warning-subtle p-1 rounded px-3">Form Identitas Pasangan</span>
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
                <x-partials.forms.input name="data_mapping.nik" label="NIK" wire:model="data_mapping.nik"
                    disabled></x-partials.forms.input>
            </div>
            <div class="col-lg-3 mb-3">
                <x-partials.forms.input name="data_mapping.nkk" label="NKK" wire:model="data_mapping.nkk"
                    disabled></x-partials.forms.input>
            </div>
        </div>
        {{-- Data Diri Input --}}
        <div class="row">
            <div class="col-lg-6">
                <x-partials.forms.input setcol="mb-3" name="form_identitas_pasangan.nama" label="Nama Pasangan"
                    wire:model="form_identitas_pasangan.nama"></x-partials.forms.input>
                <x-partials.forms.input setcol="mb-3" name="form_identitas_pasangan.nik" label="NIK Pasangan"
                    wire:model="form_identitas_pasangan.nik" type="number"></x-partials.forms.input>
                <x-partials.forms.input setcol="mb-3" name="form_identitas_pasangan.nip"
                    label="NIP <small class='text-primary fw-bold'>(Diisi apabila pekerjaan pasangan adalah ASN-Aktif)</small>"
                    wire:model="form_identitas_pasangan.nip" type="number"></x-partials.forms.input>
                <x-partials.forms.input setcol="mb-3" name="form_identitas_pasangan.tanggal_lahir"
                    label="Tanggal Lahir" wire:model="form_identitas_pasangan.tanggal_lahir"
                    type="date"></x-partials.forms.input>
                <x-partials.forms.radio-button setcol="mb-3" label="Mempunyai anak yg menjadi tanggungan?"
                    model="form_identitas_pasangan.mempunyai_anak" name="mempunyai_anak" option1Text="Ya"
                    option1Value="1" option2Text="Tidak" option2Value="0" />
            </div>
            <div class="col-lg-6">
                <x-partials.forms.input setcol="mb-3" name="form_identitas_pasangan.telepon" label="Nomor Telepon"
                    wire:model="form_identitas_pasangan.telepon" type="number"
                    phr="08XX-XXXX-XXXX"></x-partials.forms.input>
                <x-partials.forms.input setcol="mb-3" name="form_identitas_pasangan.pekerjaan" label="Pekerjaan"
                    wire:model="form_identitas_pasangan.pekerjaan"></x-partials.forms.input>
                <x-partials.forms.input setcol="mb-3" name="form_identitas_pasangan.nomor_akta"
                    label="Nomor Akta (Menikah/Bercerai)"
                    wire:model="form_identitas_pasangan.nomor_akta"></x-partials.forms.input>
                <x-partials.forms.input setcol="mb-3" name="form_identitas_pasangan.tanggal_akta"
                    label="Tanggal Akta (Menikah/Bercerai)" wire:model="form_identitas_pasangan.tanggal_akta"
                    type="date"></x-partials.forms.input>
                <x-partials.forms.input-file name="form_identitas_pasangan.file_akta" label="Dokumen Akta"
                    accept=".pdf" maxSize="750kb" formatDesc="pdf" icon="bi bi-eye"
                    byClick="{{ $pegawai->pasangan?->file_akta }}"
                    wireClick="previewFile('dokumen-akta', '{{ $pegawai->pasangan?->file_akta }}', 'Dokumen Akta')" />

                @if ($pegawai->jenis_pensiun_id == 3)
                    {{-- Suket kematian --}}
                    <div class="my-3">
                        <x-partials.forms.input-file name="form_identitas_pasangan.suket_kematian"
                            label="Suket Kematian" accept=".pdf" maxSize="750kb" formatDesc="pdf" icon="bi bi-eye"
                            byClick="{{ $pegawai->pasangan?->suket_kematian }}"
                            wireClick="previewFile('suket-kematian', '{{ $pegawai->pasangan?->suket_kematian }}', 'Suket Kematian')" />
                    </div>
                    {{-- Suket Janda Duda --}}
                    <x-partials.forms.input-file name="form_identitas_pasangan.suket_janda_duda"
                        label="Suket Janda Duda dari Kelurahan/Desa" accept=".pdf" maxSize="750kb" formatDesc="pdf"
                        icon="bi bi-eye" byClick="{{ $pegawai->pasangan?->suket_kematian }}"
                        wireClick="previewFile('suket-janda-duda', '{{ $pegawai->pasangan?->suket_janda_duda }}', 'Suket Janda Duda')" />
                @endif
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-4">
        <button type="button" wire:click="$set('step', 1)" class="btn btn-secondary me-2">
            &larr; Sebelumnya
        </button>
        <button type="button" wire:click="saveIdentitasPasangan" class="btn btn-warning">
            Berikutnya &rarr;
        </button>
    </div>
</div>
