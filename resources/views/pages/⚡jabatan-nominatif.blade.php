<?php

use App\Models\JabatanNominatif;
use Livewire\Component;

new class extends Component {
    public $list_jabatan_nominatif;
    public array $form = [
        'nama' => null,
        'bup' => null,
    ];
    // Properti untuk menyimpan ID data yang sedang diedit
    public ?int $jabatan_nominatif_id = null;

    public function mount()
    {
        $this->list_jabatan_nominatif = JabatanNominatif::get();
    }
    public function save()
    {
        $validated = $this->validate([
            'form.nama' => 'required|string|max:255',
            'form.bup' => 'required|integer',
        ]);
        if ($this->jabatan_nominatif_id) {
            JabatanNominatif::find($this->jabatan_nominatif_id)->update($validated['form']);
            session()->flash('message', 'Data jabatan nominatif berhasil diperbarui!');
        } else {
            JabatanNominatif::create($validated['form']);
            session()->flash('message', 'Data jabatan nominatif berhasil disimpan!');
        }
        $this->list_jabatan_nominatif = JabatanNominatif::get();
        $this->resetForm();
    }

    public function edit(JabatanNominatif $jabatan_nominatif)
    {
        $this->resetForm();
        $this->jabatan_nominatif_id = $jabatan_nominatif->id;
        $this->form = [
            'nama' => $jabatan_nominatif->nama,
            'bup' => $jabatan_nominatif->bup,
        ];
    }

    public function delete(JabatanNominatif $jabatan_nominatif)
    {
        $jabatan_nominatif->delete();
        $this->list_jabatan_nominatif = JabatanNominatif::get();
        $this->resetForm();
        session()->flash('message', 'Data jabatan nominatif berhasil dihapus!');
    }

    public function resetForm()
    {
        $this->reset(['form', 'jabatan_nominatif_id']);
        $this->resetValidation();
    }

    public function validationAttributes()
    {
        return [
            'form.nama' => 'Nama Jabatan Nominatif',
            'form.bup' => 'Batas Usia Pensiun',
        ];
    }
};
?>

<div>
    <div class="container-fluid px-3 px-lg-4 py-4">
        <x-partials.display.page-title title="Jabatan Nominatif"></x-partials.display.page-title>
        <section class="row g-3">
            {{-- Tabel Data --}}
            <div class="col-12 col-xl-6">
                <section class="panel">
                    <div class="panel-header">
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i>
                            <span>Daftar Jabatan Nominatif</span>
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
                                @foreach ($list_jabatan_nominatif as $jabatan_nominatif)
                                    <tr>
                                        <td class="text-center fw-semibold" style="min-width: 40px;">
                                            {{ $loop->iteration }}</td>
                                        <td>{{ $jabatan_nominatif->nama }}</td>
                                        <td class="text-center">{{ $jabatan_nominatif->bup }}</td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1"
                                                role="group" aria-label="Aksi Jenis Pensiun">
                                                <!-- Tombol Ubah / Edit -->
                                                <x-partials.forms.action-button icon="bi-pencil" label="Ubah"
                                                    color="warning" wireClick="edit({{ $jabatan_nominatif->id }})" />
                                                <!-- Tombol Hapus -->
                                                <x-partials.forms.action-button icon="bi-trash" label="Hapus"
                                                    color="danger" wireClick="delete({{ $jabatan_nominatif->id }})" />
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
                                    aria-hidden="true"></i><span>Form Information</span></h2>
                            <p class="text-muted mb-0">Isi Form Berikut.</p>
                        </div>

                    </div>
                    <div class="row g-3">
                        <x-partials.forms.input name="form.nama" label="Nama Jabatan Nominatif"
                            phr="Masukkan Nama Jabatan Nominatif" wire:model="form.nama"></x-partials.forms.input>
                        <x-partials.forms.input name="form.bup" label="BUP" phr="Masukkan Batas Usia Pensiun"
                            wire:model="form.bup" type="number"></x-partials.forms.input>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        @if ($jabatan_nominatif_id)
                            <button type="button" wire:click="resetForm" class="btn btn-secondary me-2">Batal</button>
                        @endif
                        <x-partials.forms.submit target="save" :is-update="(bool) $jabatan_nominatif_id" />
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
