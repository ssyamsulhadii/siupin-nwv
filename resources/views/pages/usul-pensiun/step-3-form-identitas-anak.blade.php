<div class="panel needs-validation">
    <div class="panel-header">
        <h2 class="h5 mb-1 section-title"><i class="bi bi-ui-checks-grid" aria-hidden="true"></i>
            <span class="bg-warning-subtle p-1 rounded px-3">Form Identitas Anak</span>
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
                <x-partials.forms.input setcol="mb-3" name="form_identitas_anak.nama" label="Nama Anak"
                    wire:model="form_identitas_anak.nama"></x-partials.forms.input>
                <x-partials.forms.input setcol="mb-3" name="form_identitas_anak.nik" label="NIK Anak"
                    wire:model="form_identitas_anak.nik" type="number"></x-partials.forms.input>
                <x-partials.forms.input setcol="mb-3" name="form_identitas_anak.tanggal_lahir" label="Tanggal Lahir"
                    wire:model="form_identitas_anak.tanggal_lahir" type="date"></x-partials.forms.input>
                <x-partials.forms.radio-button setcol="mb-3" label="Jenis Kelamin"
                    model="form_identitas_anak.jenis_kelamin" name="jenis_kelamin" option1Text="Lak-Laki"
                    option1Value="L" option2Text="Perempuan" option2Value="P" />
            </div>
            <div class="col-lg-6">
                <x-partials.forms.input setcol="mb-3" name="form_identitas_anak.telepon" label="Nomor Telepon"
                    wire:model="form_identitas_anak.telepon" type="number"
                    phr="08XX-XXXX-XXXX"></x-partials.forms.input>
                <x-partials.forms.input setcol="mb-3" name="form_identitas_anak.nomor_akta"
                    label="Nomor Akta Kelahiran" wire:model="form_identitas_anak.nomor_akta"></x-partials.forms.input>
                <x-partials.forms.input setcol="mb-3" name="form_identitas_anak.tanggal_akta"
                    label="Tanggal Akta Kelahiran" wire:model="form_identitas_anak.tanggal_akta"
                    type="date"></x-partials.forms.input>
                <x-partials.forms.input-file name="form_identitas_anak.file_akta" label="Dokumen Akta Kelahiran"
                    accept=".pdf" maxSize="750kb" formatDesc="pdf" />
                <x-partials.forms.input setcol="my-3" name="form_identitas_anak.keterangan" label="Keterangan"
                    wire:model="form_identitas_anak.keterangan" phr="Anak Kandung ...."></x-partials.forms.input>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-4">
        <button type="button" wire:click="$set('step', 2)" class="btn btn-secondary me-2">
            &larr; Sebelumnya
        </button>
        <button type="button" wire:click="addIdentitasAnak" class="btn btn-primary me-2">
            <i class="bi {{ $anak_id ? 'bi-pencil-square' : 'bi-plus-circle' }}"></i> {{ $anak_id ? 'Ubah' : 'Tambah' }}
            Data Anak
        </button>
        @if (count($this->list_anak) > 0)
            <button type="button" wire:click="nextStepUploadDokumen" class="btn btn-warning">
                Berikutnya &rarr;
            </button>
        @endif
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
                    <th>Akta Kelahiran</th>
                    <th class="text-center">Menu</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($list_anak as $anak)
                    <tr>
                        <td class="text-center fw-semibold" style="min-width: 40px;">{{ $loop->iteration }}</td>
                        <td>{{ $anak->nama }} <br> {{ $anak->nik }}</td>
                        <td class="text-center">{{ $anak->tanggal_lahir->isoFormat('DD-MMMM-YYYY') }}</td>
                        <td class="text-center">{{ $anak->jenis_kelamin == 'L' ? 'Laki Laki' : 'Perempuan' }}</td>
                        <td class="text-center">{{ $anak->telepon }}</td>
                        <td>Nomor : {{ $anak->nomor_akta }} <br>
                            Tanggal : {{ $anak->tanggal_akta->isoFormat('DD-MMMM-YYYY') }} <br>
                        </td>
                        <td class="text-center">
                            <div class="d-flex align-items-center justify-content-center gap-1" role="group"
                                aria-label="Aksi Jenis Pensiun">
                                <!-- Lihat File -->
                                <x-partials.forms.action-button icon="bi-eye" label="Lihat" color="primary"
                                    wireClick="previewFile('akta-kelahiran', '{{ $anak->file_akta }}', 'Akta Kelahiran')" />
                                <!-- Tombol Ubah / Edit -->
                                <x-partials.forms.action-button icon="bi-pencil" label="Ubah" color="warning"
                                    wireClick="editIdentitasAnak({{ $anak->id }})" />
                                <!-- Tombol Hapus -->
                                <x-partials.forms.action-button icon="bi-trash" label="Hapus" color="danger"
                                    wireClick="deleteIdentitasAnak({{ $anak->id }})" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <h5 class="text-danger text-center">Data identitas anak belum diinput</h5>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
