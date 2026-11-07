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
                <x-partials.forms.select setcol="mb-3" name="form_identitas_diri.jenis_pensiun_id"
                    label="Jenis Pensiun" placeholder="-- Pilih --" :options="$list_jenis_pensiun"
                    wire:model="form_identitas_diri.jenis_pensiun_id" />
                <x-partials.forms.input setcol="mb-3" name="form_identitas_diri.tanggal_pensiun"
                    label="Tanggal Pensiun <small class='text-primary fw-bold'>(Diisi Apabila Jenis Pensiun Selain BUP)</small>"
                    wire:model="form_identitas_diri.tanggal_pensiun" type="date"></x-partials.forms.input>
                <x-partials.forms.text-area setcol="mb-3" name="form_identitas_diri.alamat_sekarang"
                    label="Alamat Sekarang" wire:model="form_identitas_diri.alamat_sekarang" rows="3"
                    phr="Jln Pemuda KM 5.5"></x-partials.forms.text-area>
                <x-partials.forms.radio-button setcol="mb-3" label="Mempunyai Pasangan/Pernah Punya Pasangan?"
                    model="form_identitas_diri.mempunyai_pasangan" name="form_identitas_diri.mempunyai_pasangan"
                    option1Text="Ya" option1Value="1" option2Text="Tidak" option2Value="0" />
                @if (isset($form_identitas_diri['mempunyai_pasangan']) && $form_identitas_diri['mempunyai_pasangan'] == '1')
                    <div class="form-group ">
                        <label for="status_pasangan" class="form-label"><strong>Status Pasangan</strong></label>
                        <select class="form-select @error('form_identitas_diri.status_pasangan') is-invalid @enderror"
                            id="status_pasangan" wire:model="form_identitas_diri.status_pasangan">
                            <option>Pilih</option>
                            <option value="hidup">Hidup</option>
                            <option value="meninggal">Meninggal</option>
                            <option value="bercerai">Bercerai</option>
                        </select>
                        @error('form_identitas_diri.status_pasangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
            </div>
            <div class="col-lg-6">
                <x-partials.forms.select setcol="mb-3" name="form_identitas_diri.rumpun_jabatan_id"
                    label="Rumpun Jabatan" placeholder="-- Pilih --" :options="$list_rumpun_jabatan"
                    wire:model="form_identitas_diri.rumpun_jabatan_id" />
                <x-partials.forms.input setcol="mb-3" name="form_identitas_diri.nama_jabatan" label="Nama Jabatan"
                    wire:model="form_identitas_diri.nama_jabatan"></x-partials.forms.input>
                <x-partials.forms.input setcol="mb-3" name="form_identitas_diri.telepon" label="Nomor Telepon"
                    wire:model="form_identitas_diri.telepon" type="number"
                    phr="08XX-XXXX-XXXX"></x-partials.forms.input>
                <x-partials.forms.text-area setcol="mb-3" name="form_identitas_diri.alamat_pensiun"
                    label="Alamat Pensiun" wire:model="form_identitas_diri.alamat_pensiun" rows="3"
                    phr="Jln Pemuda KM 5.5"></x-partials.forms.text-area>
                @if (isset($form_identitas_diri['mempunyai_pasangan']) && $form_identitas_diri['mempunyai_pasangan'] == '1')
                    <x-partials.forms.radio-button setcol="mb-3" label="Mempunyai anak yg menjadi tanggungan?"
                        model="form_identitas_diri.mempunyai_anak" name="mempunyai_anak" option1Text="Ya"
                        option1Value="1" option2Text="Tidak" option2Value="0" />
                @endif
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-4">
        <button type="button" wire:click="resetForm" class="btn btn-secondary me-2">Batal</button>
        <button type="button" wire:click="saveIdentitasDiri" class="btn btn-warning">
            Berikutnya &rarr;
        </button>
    </div>
</div>
