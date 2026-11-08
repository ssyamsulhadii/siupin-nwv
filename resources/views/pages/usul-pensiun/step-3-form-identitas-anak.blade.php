<div class="panel needs-validation">
    <div class="panel-header">
        <div>
            <h2 class="h5 mb-1 section-title"><i class="bi bi-ui-checks-grid" aria-hidden="true"></i>
                <span class="bg-warning-subtle p-1 rounded px-3">Form Identitas Anak</span>
            </h2>
        </div>
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
                <x-partials.forms.input setcol="mb-3" name="form_identitas_anak.nama" label="Nama Anak"
                    wire:model="form_identitas_anak.nama"></x-partials.forms.input>
                <x-partials.forms.input setcol="mb-3" name="form_identitas_anak.nik" label="NIK Anak"
                    wire:model="form_identitas_anak.nik" type="number"></x-partials.forms.input>
                <x-partials.forms.radio-button setcol="mb-3" label="Jenis Kelamin"
                    model="form_identitas_anak.jenis_kelamin" name="jenis_kelamin" option1Text="Lak-Laki"
                    option1Value="L" option2Text="Perempuan" option2Value="P" />
            </div>
            <div class="col-lg-6">
                <x-partials.forms.input setcol="mb-3" name="form_identitas_anak.tanggal_lahir" label="Tanggal Lahir"
                    wire:model="form_identitas_anak.tanggal_lahir" type="date"></x-partials.forms.input>
                <x-partials.forms.input setcol="mb-3" name="form_identitas_anak.telepon" label="Nomor Telepon"
                    wire:model="form_identitas_anak.telepon" type="number"
                    phr="08XX-XXXX-XXXX"></x-partials.forms.input>
                <x-partials.forms.input-file name="form_identitas_anak.akta_kelahiran" label="Akta Kelahiran"
                    accept=".pdf" maxSize="1MB" formatDesc="pdf" oldFile="" folderPath="akta-kelahiran"
                    icon="bi bi-eye" />
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-4">
        <button type="button" wire:click="$set('step', 2)" class="btn btn-secondary me-2">
            &larr; Sebelumnya
        </button>
        <button type="button" wire:click="addIdentitasAnak" class="btn btn-primary me-2">
            Tambah Anak
        </button>
        <button type="button" wire:click="saveIdentitasAnak" class="btn btn-warning">
            Berikutnya &rarr;
        </button>
    </div>

    <div class="table-responsive mt-4">
        <table class="table table-bordered align-middle mb-0" id="ordersTable" data-searchable-table="">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nama-NIK</th>
                    <th class="text-center">Tanggal Lahir</th>
                    <th class="text-center">Jenis Kelamin</th>
                    <th class="text-center">Telepon</th>
                    <th class="text-center">Akta Kelahiran</th>
                    <th class="text-center">Menu</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center fw-semibold" style="min-width: 40px;">1</td>
                    <td>..</td>
                    <td>..</td>
                    <td>..</td>
                    <td>..</td>
                    <td>..</td>
                    <td>..</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
