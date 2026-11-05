<?php

use App\Models\DokumenInformasi;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

new class extends Component {
    use WithFileUploads;
    public $list_dokumen_informasi;
    // Properti untuk menyimpan ID data yang sedang diedit
    public $format_file;
    public array $form = ['label' => '', 'nama_file' => '', 'format_file' => '', 'keterangan' => ''];
    public ?int $dokumen_informasi_id = null;
    public $old_nama_file = null;

    public function mount()
    {
        $this->list_dokumen_informasi = DokumenInformasi::all();

        $data_format_file = [['id' => 'docx', 'nama' => 'docx'], ['id' => 'pdf', 'nama' => 'pdf'], ['id' => 'csv', 'nama' => 'csv']];
        $format_file = collect($data_format_file)->map(
            fn($item) => (object) [
                'id' => $item['id'],
                'nama' => $item['nama'],
            ],
        );
        $this->format_file = $format_file;
    }

    public function save()
    {
        $rule = $this->dokumen_informasi_id ? 'sometimes' : 'required';
        $rules = [
            'form.label' => 'required|string|max:255',
            'form.format_file' => 'required|in:csv,docx,pdf',
            'form.keterangan' => 'required|string',
            'form.nama_file' => $rule . '|file|mimes:csv,docx,pdf|max:1200',
        ];
        $validated = $this->validate($rules);
        // 1. Ambil nama file lama sebagai default
        $fileName = $this->old_nama_file;
        // 2. Jika ada file yang di-upload
        if (isset($this->form['nama_file']) && is_object($this->form['nama_file'])) {
            $file = $this->form['nama_file'];
            $fileName = $file->hashName();
            $file->storeAs('dokumen-informasi', $fileName, 'public');
            // Hapus file lama ketika mode edit
            if ($this->dokumen_informasi_id && $this->old_nama_file) {
                Storage::disk('public')->delete('dokumen-informasi/' . $this->old_nama_file);
            }
        }
        // 3. Simpan ke Database
        DokumenInformasi::updateOrCreate(
            ['id' => $this->dokumen_informasi_id],
            [
                'label' => $this->form['label'],
                'nama_file' => $fileName,
                'format_file' => $this->form['format_file'],
                'keterangan' => $this->form['keterangan'],
            ],
        );
        $this->list_dokumen_informasi = DokumenInformasi::all();
        session()->flash('message', $this->dokumen_informasi_id ? 'Dokumen berhasil diperbarui!' : 'Dokumen berhasil disimpan!');
        $this->resetForm();
    }

    public function edit(DokumenInformasi $dokumen_informasi)
    {
        $this->resetForm();
        $this->dokumen_informasi_id = $dokumen_informasi->id;
        $this->old_nama_file = $dokumen_informasi->nama_file;
        $this->form = [
            'label' => $dokumen_informasi->label,
            // 'nama_file' => $dokumen_informasi->nama_file,
            'format_file' => $dokumen_informasi->format_file,
            'keterangan' => $dokumen_informasi->keterangan,
        ];
    }

    public function delete(DokumenInformasi $dokumen_informasi)
    {
        Storage::disk('public')->delete('dokumen-informasi/' . $dokumen_informasi->nama_file);
        $dokumen_informasi->delete();
        $this->list_dokumen_informasi = DokumenInformasi::all();
        session()->flash('message', 'Data dokumen informasi berhasil dihapus!');
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['form', 'dokumen_informasi_id', 'old_nama_file']);
        $this->resetValidation();
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
                                    <th class="text-center">Preview</th>
                                    <th>Label</th>
                                    <th>Keterangan</th>
                                    <th class="text-center">Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_dokumen_informasi as $dokumen_informasi)
                                    <tr>
                                        <td class="text-center fw-semibold" style="min-width: 40px;">
                                            {{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            <a href="{{ asset('storage/dokumen-informasi/' . $dokumen_informasi->nama_file) }}"
                                                target="_blank">
                                                <x-partials.forms.action-button icon="bi-eye" label="Lihat"
                                                    color="primary" />
                                            </a>
                                        </td>
                                        <td>{{ $dokumen_informasi->label }}</td>
                                        <td>{{ $dokumen_informasi->keterangan }}</td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1"
                                                role="group" aria-label="Aksi Jenis Pensiun">
                                                <!-- Tombol Ubah / Edit -->
                                                <x-partials.forms.action-button icon="bi-pencil" label="Ubah"
                                                    color="warning" wireClick="edit({{ $dokumen_informasi->id }})" />
                                                <!-- Tombol Hapus -->
                                                <x-partials.forms.action-button icon="bi-trash" label="Hapus"
                                                    color="danger" wireClick="delete({{ $dokumen_informasi->id }})" />
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
                        <x-partials.forms.input name="form.label" label="Label" wire:model="form.label"
                            phr="Masukkan Nama File"></x-partials.forms.input>

                        <x-partials.forms.select name="form.format_file" label="Format File"
                            placeholder="-- Pilih Type --" :options="$format_file" wire:model="form.format_file" />

                        <x-partials.forms.text-area setcol="12" name="form.keterangan" label="Keterangan"
                            wire:model="form.keterangan" rows="3"
                            phr="Masukkan Keterangan"></x-partials.forms.text-area>

                        <x-partials.forms.input-file name="form.nama_file" label="Dokumen" accept=".pdf,.csv,.docx"
                            maxSize="1.2MB" formatDesc="docx,pdf,csv" :oldFile="$old_nama_file"
                            folderPath="assets/dokumen-informasi" icon="bi bi-eye" />
                        @if ($dokumen_informasi_id)
                            <small class="text-primary mt-0">{{ $old_nama_file }}</small>
                        @endif
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        @if ($dokumen_informasi_id)
                            <button type="button" wire:click="resetForm" class="btn btn-secondary me-2">Batal</button>
                        @endif
                        <x-partials.forms.submit target="save" :is-update="(bool) $dokumen_informasi_id" />
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
