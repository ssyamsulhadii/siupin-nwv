<div class="panel needs-validation">
    <div class="panel-header">
        <div>
            <h2 class="h5 mb-1 section-title"><i class="bi bi-ui-checks-grid" aria-hidden="true"></i>
                <span class="bg-warning-subtle p-1 rounded px-3">Form Identitas Diri</span>
            </h2>
        </div>
    </div>
    <div class="row g-3">
        {{-- Data Diri Mapping --}}
        <div class="row">
            <div class="col-lg-6">
                <x-partials.forms.input setcol="mb-2" name="form_identitas_diri.nama" label="Nama"
                    wire:model="form_identitas_diri.nama" disabled></x-partials.forms.input>
                <x-partials.forms.input setcol="mb-2" name="form_identitas_diri.nik" label="NIK"
                    wire:model="form_identitas_diri.nik" disabled></x-partials.forms.input>
                <div class="row mb-2">
                    <div class="col-6">
                        <x-partials.forms.input name="form_identitas_diri.jenis_kelamin" label="Jenis Kelamin"
                            wire:model="form_identitas_diri.jenis_kelamin" disabled></x-partials.forms.input>
                    </div>
                    <div class="col-6">
                        <x-partials.forms.input name="form_identitas_diri.tanggal_lahir" label="Tanggal Lahir"
                            wire:model="form_identitas_diri.tanggal_lahir" disabled></x-partials.forms.input>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <x-partials.forms.input setcol="mb-2" name="form_identitas_diri.nip" label="NIP"
                    wire:model="form_identitas_diri.nip" disabled></x-partials.forms.input>
                <x-partials.forms.input setcol="mb-2" name="form_identitas_diri.unit_organisasi"
                    label="Unit Organisasi" wire:model="form_identitas_diri.unit_organisasi"
                    disabled></x-partials.forms.input>
                <x-partials.forms.input setcol="mb-2" name="form_identitas_diri.pangkat_golongan"
                    label="Pangkat Golongan" wire:model="form_identitas_diri.pangkat_golongan"
                    disabled></x-partials.forms.input>

            </div>
        </div>
        {{-- Data Diri Input --}}
        <div class="row">
            <div class="col-lg-6">
                <x-partials.forms.select name="form_identitas_diri.jenis_pensiun_id" label="Jenis Pensiun"
                    placeholder="-- Pilih --" :options="$list_jenis_pensiun" wire:model="form_identitas_diri.jenis_pensiun_id" />
                <x-partials.forms.input setcol="py-3" name="form_identitas_diri.tanggal_pensiun"
                    label="Tanggal Pensiun <small class='text-danger'><strong>(Diisi Apabila Selain Jenis Pensiun BUP)</strong></small>"
                    wire:model="form_identitas_diri.tanggal_pensiun" type="date"></x-partials.forms.input>
                <x-partials.forms.input setcol="py-3" name="form_identitas_diri.nkk" label="Nomor Kattu Keluarg (NKK)"
                    wire:model="form_identitas_diri.nkk" type="number"></x-partials.forms.input>
                <x-partials.forms.text-area setcol="12" name="form_identitas_diri.alamat_sekarang"
                    label="Alamat Sekarang" wire:model="form_identitas_diri.alamat_sekarang" rows="3"
                    phr="Jln Pemuda KM 5.5"></x-partials.forms.text-area>
            </div>
            <div class="col-lg-6">
                <x-partials.forms.select name="form_identitas_diri.jabatan_nominatif_id" label="Jabatan Nominatif"
                    placeholder="-- Pilih --" :options="$list_jabatan_nominatif" wire:model="form_identitas_diri.jabatan_nominatif_id" />
                <x-partials.forms.input setcol="py-3" name="form_identitas_diri.jabatan" label="Nama Jabatan"
                    wire:model="form_identitas_diri.jabatan"></x-partials.forms.input>
                <x-partials.forms.input setcol="py-3" name="form_identitas_diri.telpon" label="Nomor Telpon"
                    wire:model="form_identitas_diri.telpon" type="number"></x-partials.forms.input>
                <x-partials.forms.text-area setcol="12" name="form_identitas_diri.alamat_pensiun"
                    label="Alamat Pensiun" wire:model="form_identitas_diri.alamat_pensiun" rows="3"
                    phr="Jln Pemuda KM 5.5"></x-partials.forms.text-area>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-4">
        <button type="button" wire:click="resetForm" class="btn btn-secondary me-2">Batal</button>
        <button type="button" wire:click="nextStepFormIdentitasPasangan" class="btn btn-warning">
            Berikutnya &rarr;
        </button>
    </div>
</div>
