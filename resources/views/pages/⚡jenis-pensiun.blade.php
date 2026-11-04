<?php

use App\Models\JenisPensiun;
use Livewire\Component;

new class extends Component {
    public $list_jenis_pensiun;
    public array $form = [
        'nama' => null,
        'keterangan' => null,
        'with_tanggal' => null,
    ];
    // Properti untuk menyimpan ID data yang sedang diedit
    public ?int $jenis_pensiun_id = null;

    public function mount()
    {
        $this->list_jenis_pensiun = JenisPensiun::get();
    }

    public function save()
    {
        $validated = $this->validate([
            'form.nama' => 'required|string|max:255',
            'form.keterangan' => 'required|string',
            'form.with_tanggal' => 'required|boolean',
        ]);
        if ($this->jenis_pensiun_id) {
            JenisPensiun::find($this->jenis_pensiun_id)->update($validated['form']);
            session()->flash('message', 'Data jenis pensiun berhasil diperbarui!');
        } else {
            JenisPensiun::create($validated['form']);
            session()->flash('message', 'Data jenis pensiun berhasil disimpan!');
        }
        $this->list_jenis_pensiun = JenisPensiun::get();
        $this->resetForm();
    }

    public function edit(JenisPensiun $jenis_pensiun)
    {
        $this->resetForm();
        $this->jenis_pensiun_id = $jenis_pensiun->id;
        $this->form = [
            'nama' => $jenis_pensiun->nama,
            'keterangan' => $jenis_pensiun->keterangan,
            'with_tanggal' => $jenis_pensiun->with_tanggal,
        ];
    }

    public function delete(JenisPensiun $jenis_pensiun)
    {
        $jenis_pensiun->delete();
        $this->list_jenis_pensiun = JenisPensiun::get();
        $this->resetForm();
        session()->flash('message', 'Data jenis pensiun berhasil dihapus!');
    }

    public function resetForm()
    {
        $this->reset(['form', 'jenis_pensiun_id']);
        $this->resetValidation();
    }

    public function validationAttributes()
    {
        return [
            'form.nama' => 'Nama Jenis Pensiun',
            'form.keterangan' => 'Keterangan',
            'form.with_tanggal' => 'With Tanggal',
        ];
    }
};
?>

<div>
    <div class="container-fluid px-3 px-lg-4 py-4">
        <x-partials.display.page-title title="Jenis Pensiun"></x-partials.display.page-title>
        <section class="row g-3">
            {{-- Tabel Data --}}
            <div class="col-12 col-xl-7">
                <section class="panel">
                    <div class="panel-header">
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i>
                            <span>Daftar Jenis Pensiun</span>
                        </h2>
                        <x-partials.feedback.alert />
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0" id="ordersTable" data-searchable-table="">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama</th>
                                    <th>Keterangan</th>
                                    <th>With Tanggal</th>
                                    <th class="text-center">Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_jenis_pensiun as $jenis_pensiun)
                                    <tr>
                                        <td class="text-center fw-semibold" style="min-width: 40px;">
                                            {{ $loop->iteration }}</td>
                                        <td>{{ $jenis_pensiun->nama }}</td>
                                        <td>{{ $jenis_pensiun->keterangan }}</td>
                                        <td class="text-center">{{ $jenis_pensiun->with_tanggal ? 'Ya' : 'Tidak' }}</td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1"
                                                role="group" aria-label="Aksi Jenis Pensiun">
                                                <!-- Tombol Ubah / Edit -->
                                                <x-partials.forms.action-button icon="bi-pencil" label="Ubah"
                                                    color="warning" wireClick="edit({{ $jenis_pensiun->id }})" />
                                                <!-- Tombol Hapus -->
                                                <x-partials.forms.action-button icon="bi-trash" label="Hapus"
                                                    color="danger" wireClick="delete({{ $jenis_pensiun->id }})" />
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            {{-- Form Input --}}
            <div class="col-12 col-xl-5">
                <form class="panel needs-validation" wire:submit="save" method="POST">
                    <div class="panel-header">
                        <div>
                            <h2 class="h5 mb-1 section-title"><i class="bi bi-ui-checks-grid"
                                    aria-hidden="true"></i><span>Form Information</span></h2>
                            <p class="text-muted mb-0">Isi Form Berikut.</p>
                        </div>

                    </div>
                    <div class="row g-3">
                        <x-partials.forms.input name="form.nama" label="Nama Jenis Pensiun" wire:model="form.nama"
                            phr="Masukkan Nama Jenis Pensiun"></x-partials.forms.input>
                        <x-partials.forms.text-area setcol="12" name="form.keterangan" label="Keterangan"
                            wire:model="form.keterangan" rows="3"
                            phr="Masukkan Keterangan"></x-partials.forms.text-area>
                        <x-partials.forms.radio-button label="With Tanggal:" model="form.with_tanggal"
                            name="with_tanggal" option1Text="Ya" option1Value="1" option2Text="Tidak"
                            option2Value="0" />
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        @if ($jenis_pensiun_id)
                            <button type="button" wire:click="resetForm" class="btn btn-secondary me-2">Batal</button>
                        @endif
                        <x-partials.forms.submit target="save" :is-update="(bool) $jenis_pensiun_id" />
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
