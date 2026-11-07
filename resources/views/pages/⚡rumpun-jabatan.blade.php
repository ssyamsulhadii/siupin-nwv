<?php

use App\Models\RumpunJabatan;
use Livewire\Component;

new class extends Component {
    public $list_rumpun_jabatan;
    public array $form = [
        'nama' => null,
        'bup' => null,
    ];
    // Properti untuk menyimpan ID data yang sedang diedit
    public ?int $rumpun_jabatan_id = null;

    public function mount()
    {
        $this->list_rumpun_jabatan = RumpunJabatan::get();
    }
    public function save()
    {
        $validated = $this->validate([
            'form.nama' => 'required|string|max:255',
            'form.bup' => 'required|integer',
        ]);
        if ($this->rumpun_jabatan_id) {
            RumpunJabatan::find($this->rumpun_jabatan_id)->update($validated['form']);
            session()->flash('message', 'Data Rumpun Jabatan berhasil diperbarui!');
        } else {
            RumpunJabatan::create($validated['form']);
            session()->flash('message', 'Data Rumpun Jabatan berhasil disimpan!');
        }
        $this->list_rumpun_jabatan = RumpunJabatan::get();
        $this->resetForm();
    }

    public function edit(RumpunJabatan $rumpun_jabatan)
    {
        $this->resetForm();
        $this->rumpun_jabatan_id = $rumpun_jabatan->id;
        $this->form = [
            'nama' => $rumpun_jabatan->nama,
            'bup' => $rumpun_jabatan->bup,
        ];
    }

    public function delete(RumpunJabatan $rumpun_jabatan)
    {
        $rumpun_jabatan->delete();
        $this->list_rumpun_jabatan = RumpunJabatan::get();
        $this->resetForm();
        session()->flash('message', 'Data Rumpun Jabatan berhasil dihapus!');
    }

    public function resetForm()
    {
        $this->reset(['form', 'rumpun_jabatan_id']);
        $this->resetValidation();
    }

    public function validationAttributes()
    {
        return [
            'form.nama' => 'Nama Rumpun Jabatan',
            'form.bup' => 'Batas Usia Pensiun',
        ];
    }
};
?>

<div>
    <div class="container-fluid px-3 px-lg-4 py-4">
        <x-partials.display.page-title title="Rumpun Jabatan"></x-partials.display.page-title>
        <section class="row g-3">
            {{-- Tabel Data --}}
            <div class="col-12 col-xl-6">
                <section class="panel">
                    <div class="panel-header">
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i>
                            <span>Daftar Rumpun Jabatan</span>
                        </h2>
                        <x-partials.feedback.alert />
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0" id="ordersTable" data-searchable-table="">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama</th>
                                    <th class="text-center">BUP</th>
                                    <th class="text-center">Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_rumpun_jabatan as $rumpun_jabatan)
                                    <tr>
                                        <td class="text-center fw-semibold" style="min-width: 40px;">
                                            {{ $loop->iteration }}</td>
                                        <td>{{ $rumpun_jabatan->nama }}</td>
                                        <td class="text-center">{{ $rumpun_jabatan->bup }}</td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1"
                                                role="group" aria-label="Aksi Jenis Pensiun">
                                                <!-- Tombol Ubah / Edit -->
                                                <x-partials.forms.action-button icon="bi-pencil" label="Ubah"
                                                    color="warning" wireClick="edit({{ $rumpun_jabatan->id }})" />
                                                <!-- Tombol Hapus -->
                                                <x-partials.forms.action-button icon="bi-trash" label="Hapus"
                                                    color="danger" wireClick="delete({{ $rumpun_jabatan->id }})" />
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
            <div class="col-12 col-xl-6">
                <form class="panel needs-validation" wire:submit="save" method="POST">
                    <div class="panel-header">
                        <div>
                            <h2 class="h5 mb-1 section-title"><i class="bi bi-ui-checks-grid"
                                    aria-hidden="true"></i><span>Form Informasi</span></h2>
                            <p class="text-muted mb-0">Isi Form Berikut.</p>
                        </div>

                    </div>
                    <div class="row g-3">
                        <x-partials.forms.input name="form.nama" label="Nama Rumpun Jabatan"
                            phr="Masukkan Nama Rumpun Jabatan" wire:model="form.nama"></x-partials.forms.input>
                        <x-partials.forms.input name="form.bup" label="BUP" phr="Masukkan Batas Usia Pensiun"
                            wire:model="form.bup" type="number"></x-partials.forms.input>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        @if ($rumpun_jabatan_id)
                            <button type="button" wire:click="resetForm" class="btn btn-secondary me-2">Batal</button>
                        @endif
                        <x-partials.forms.submit target="save" :is-update="(bool) $rumpun_jabatan_id" />
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
