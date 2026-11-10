<?php

use App\Models\ProgresUsul;
use Livewire\Component;

new class extends Component {
    public $list_progres_usul;
    public $warna;
    public $keterangan;
    public $kategori_status_usul;
    public $list_kategori_status_usul;
    // Properti untuk menyimpan ID data yang sedang diedit
    public ?int $progres_usul_id = null;

    // Aturan validasi input
    protected $rules = [
        'warna' => 'required|string|max:50',
        'keterangan' => 'required|string|max:255',
        'kategori_status_usul' => 'required',
    ];

    // Pesan error kustom (opsional agar lebih informatif)
    protected $messages = [
        'warna.required' => 'Warna status wajib dipilih.',
        'keterangan.required' => 'Keterangan tidak boleh kosong.',
        'kategori_status_usul.required' => 'Kategori status usul wajib dipilih.',
    ];

    public function mount()
    {
        $this->list_progres_usul = ProgresUsul::all();
        $data_kategori = [['id' => 'Draft', 'nama' => 'Draft'], ['id' => 'Terkirim', 'nama' => 'Terkirim'], ['id' => 'Perbaikan', 'nama' => 'Perbaikan'], ['id' => 'Diterima', 'nama' => 'Diterima']];
        $this->list_kategori_status_usul = collect($data_kategori)->map(
            fn($item) => (object) [
                'id' => $item['id'],
                'nama' => $item['nama'],
            ],
        );
    }

    public function save()
    {
        $validated = $this->validate();
        if ($this->progres_usul_id) {
            ProgresUsul::find($this->progres_usul_id)->update($validated);
            session()->flash('message', 'Data progres usul berhasil diperbarui!');
        } else {
            ProgresUsul::create($validated);
            session()->flash('message', 'Data progres usul berhasil disimpan!');
        }
        $this->list_progres_usul = ProgresUsul::get();
        $this->resetForm();
    }

    public function edit(ProgresUsul $progres_usul)
    {
        $this->resetForm();
        $this->progres_usul_id = $progres_usul->id;
        $this->warna = $progres_usul->warna;
        $this->keterangan = $progres_usul->keterangan;
        $this->kategori_status_usul = $progres_usul->kategori_status_usul;
    }

    public function delete(ProgresUsul $progres_usul)
    {
        $progres_usul->delete();
        $this->list_progres_usul = ProgresUsul::get();
        $this->resetForm();
        session()->flash('message', 'Data progres usul berhasil dihapus!');
    }

    public function resetForm()
    {
        $this->reset(['warna', 'keterangan', 'kategori_status_usul']);
        $this->resetValidation();
    }
};
?>

<div>
    <div class="container-fluid px-3 px-lg-4 py-4">
        <x-partials.display.page-title title="Progres Usul"></x-partials.display.page-title>
        <section class="row g-3">
            {{-- Tabel Data --}}
            <div class="col-12 col-xl-6">
                <section class="panel">
                    <div class="panel-header">
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i>
                            <span>Daftar Progres Usul</span>
                        </h2>
                        <x-partials.feedback.alert />
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0" id="ordersTable" data-searchable-table="">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Warna</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center">Kategori Status Usul</th>
                                    <th class="text-center">Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_progres_usul as $progres_usul)
                                    <tr>
                                        <td class="text-center fw-semibold" style="min-width: 40px;">
                                            {{ $loop->iteration }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $progres_usul->warna }} px-3 py-2 text-uppercase fw-semibold shadow-sm">
                                                {{ $progres_usul->warna }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ $progres_usul->keterangan }}</td>
                                        <td class="text-center">{{ $progres_usul->kategori_status_usul }}</td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1"
                                                role="group" aria-label="Aksi Progres Usul">
                                                <!-- Tombol Ubah / Edit -->
                                                <x-partials.forms.action-button icon="bi-pencil" label="Ubah"
                                                    color="warning" wireClick="edit({{ $progres_usul->id }})" />
                                                <!-- Tombol Hapus -->
                                                <x-partials.forms.action-button icon="bi-trash" label="Hapus"
                                                    color="danger" wireClick="delete({{ $progres_usul->id }})" />
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
                        <!-- Input Warna -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Warna Status</label>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach (['primary' => 'Biru', 'success' => 'Hijau', 'warning' => 'Kuning', 'danger' => 'Merah', 'info' => 'Biru Muda', 'secondary' => 'Abu-abu'] as $key => $label)
                                    <div type="button" wire:click="$set('warna', '{{ $key }}')"
                                        class="badge bg-{{ $key }} p-3 fs-6 {{ $warna === $key ? 'border border-3 border-dark shadow-lg scale-up' : 'opacity-50' }}"
                                        style="cursor: pointer; transition: all 0.2s ease;">

                                        <!-- Tambahkan ikon centang (check) kecil jika warna ini dipilih -->
                                        @if ($warna === $key)
                                            <i class="bi bi-check-circle-fill me-1"></i>
                                        @endif

                                        {{ $label }}
                                    </div>
                                @endforeach
                            </div>
                            @error('warna')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <x-partials.forms.input name="keterangan" label="Keterangan" phr="Masukkan Keterangan"
                            wire:model="keterangan"></x-partials.forms.input>
                        <x-partials.forms.select name="kategori_status_usul" label="Kategori Status Usul"
                            placeholder="-- Pilih Type --" :options="$list_kategori_status_usul" wire:model="kategori_status_usul" />
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        @if ($progres_usul_id)
                            <button type="button" wire:click="resetForm" class="btn btn-secondary me-2">Batal</button>
                        @endif
                        <x-partials.forms.submit target="save" :is-update="(bool) $progres_usul_id" />
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
