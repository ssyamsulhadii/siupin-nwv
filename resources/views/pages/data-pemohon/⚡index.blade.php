<?php

use App\Models\JenisPensiun;
use App\Models\Pegawai;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProgresUsul;

new class extends Component {
    use WithPagination;
    public $list_jenis_pensiun;
    public $list_progres_usul;
    public $total_pegawai;
    // Properti untuk menampung nilai filter & pencarian
    public $jenis_pensiun_id = '';
    public $progres_usul_id = '';
    public $search_nama = '';
    public $search_nip = '';

    public function mount()
    {
        $this->list_jenis_pensiun = JenisPensiun::withCount('pegawai')->get();
        $this->total_pegawai = Pegawai::count();
        $this->list_progres_usul = ProgresUsul::all();
    }

    public function updating($property)
    {
        if (in_array($property, ['jenis_pensiun_id', 'progres_usul_id', 'search_nama', 'search_nip'])) {
            $this->resetPage();
        }
    }

    // Fungsi untuk tombol Reset
    public function resetFilter()
    {
        $this->list_jenis_pensiun = JenisPensiun::withCount('pegawai')->get();
        $this->reset(['jenis_pensiun_id', 'progres_usul_id', 'search_nama', 'search_nip']);
        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    public function render()
    {
        //    Query data pegawai dengan filter kondisional (.when)
        $list_pegawai = Pegawai::query()
            ->when($this->jenis_pensiun_id, function ($query) {
                $query->where('jenis_pensiun_id', $this->jenis_pensiun_id);
            })
            ->when($this->progres_usul_id, function ($query) {
                $query->where('progres_usul_id', $this->progres_usul_id);
            })
            ->when($this->search_nama, function ($query) {
                $query->where('nama', 'like', '%' . $this->search_nama . '%');
            })
            ->when($this->search_nip, function ($query) {
                $query->where('nip', 'like', '%' . $this->search_nip . '%');
            })
            ->latest()
            ->paginate(10);

        return view('pages.data-pemohon.⚡index', [
            'list_pegawai' => $list_pegawai,
        ]);
    }
};
?>

<div>
    <div class="container-fluid px-3 px-lg-4 py-4">
        <x-partials.display.page-title title="Tampil Data"></x-partials.display.page-title>
        <section class="row g-3 mt-1" aria-label="Dashboard metrics">
            <!-- Card Total Keseluruhan -->
            <div class="col-12 col-sm-4 col-md-3 col-xl-2">
                <article class="metric-card metric-primary">
                    <div class="metric-top">
                        <span class="metric-label">Total</span>
                        <span class="metric-icon"><i class="bi bi-send" aria-hidden="true"></i></span>
                    </div>
                    <!-- Isi nilai total keseluruhan pegawai -->
                    <div class="fw-bold fs-1 text-center">{{ $total_pegawai }}</div>
                </article>
            </div>

            <!-- Loop untuk masing-masing jenis pensiun -->
            @foreach ($list_jenis_pensiun as $jenis_pensiun)
                <div class="col-12 col-sm-4 col-md-3 col-xl-2">
                    <article class="metric-card metric-primary">
                        <div class="metric-top">
                            <span class="metric-label">{{ $jenis_pensiun->nama }}</span>
                            <span class="metric-icon"><i class="bi bi-send" aria-hidden="true"></i></span>
                        </div>
                        <!-- Mengambil hasil withCount pegawai_count -->
                        <div class="fw-bold fs-1 text-center">{{ count($jenis_pensiun->pegawai) }}</div>
                    </article>
                </div>
            @endforeach
        </section>

        <section class="row g-3 mt-2">
            <div class="col-12 col-xl-12">
                <section class="panel">
                    <!-- Filter Pencarian -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header">
                            <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i>
                                <span>Filter Data ({{ $list_pegawai->total() }})</span>
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Filter Jenis Pensiun -->
                                <div class="col-md-3">
                                    <label for="jenis_pensiun" class="form-label fw-semibold small text-muted">Jenis
                                        Pensiun</label>
                                    <select class="form-select" id="jenis_pensiun" wire:model.live="jenis_pensiun_id">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($list_jenis_pensiun as $jenis)
                                            <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filter Progres Usul -->
                                <div class="col-md-3">
                                    <label for="progres_usul" class="form-label fw-semibold small text-muted">Progres
                                        Usul</label>
                                    <select class="form-select" id="progres_usul" wire:model.live="progres_usul_id">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($list_progres_usul as $progres)
                                            <option value="{{ $progres->id }}">{{ $progres->keterangan }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Search by Nama -->
                                <div class="col-md-3">
                                    <label for="search_nama"
                                        class="form-label fw-semibold small text-muted">Nama</label>
                                    <input type="text" class="form-control" id="search_nama"
                                        wire:model.live.debounce.300ms="search_nama"
                                        placeholder="Masukkan nama pegawai...">
                                </div>

                                <!-- Search by NIP -->
                                <div class="col-md-3">
                                    <label for="search_nip" class="form-label fw-semibold small text-muted">NIP</label>
                                    <input type="text" class="form-control" id="search_nip"
                                        wire:model.live.debounce.300ms="search_nip" placeholder="Masukkan NIP...">
                                </div>
                            </div>
                            <button type="button" class="btn btn-success btn-sm mt-3">
                                <i class="bi bi-filetype-csv me-1"></i> Impor
                            </button>
                        </div>
                    </div>

                    <!-- Tabel Data -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">

                            <div class="position-relative">

                                {{-- TABEL UTAMA --}}
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle mb-0" id="ordersTable"
                                        data-searchable-table="">
                                        <thead class="text-uppercase fs-7">
                                            <tr class="bg-success-subtle">
                                                <th class="text-dark text-center">No</th>
                                                <th class="text-dark px-3">Nama-Identitas</th>
                                                <th class="text-dark px-3">Jenis Pensiun</th>
                                                <th class="text-dark px-3">Status Data</th>
                                                <th class="text-dark px-3">Status Usul</th>
                                                <th class="text-dark text-center">Menu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($list_pegawai as $index => $pegawai)
                                                <tr>
                                                    <td class="text-center fw-semibold" style="min-width: 40px;">
                                                        {{ $list_pegawai->firstItem() + $index }}
                                                    </td>
                                                    <td>
                                                        <div class="fw-bold text-dark">{{ $pegawai->nama }}</div>
                                                        <div class="text-muted small">NIP.{{ $pegawai->nip }}</div>
                                                        <div class="text-muted small">NIK.{{ $pegawai->nik }}</div>
                                                        <div class="text-muted small">NKK.{{ $pegawai->nkk }}</div>
                                                    </td>
                                                    <td>
                                                        <!-- Badge Jenis Pensiun dengan warna soft (biru lembut) -->
                                                        <div class="mb-2" style="width: 250px;">
                                                            <span
                                                                class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1 fw-semibold fs-6">
                                                                <i class="bi bi-award me-1"></i>
                                                                {{ $pegawai->jenisPensiun->nama }}
                                                            </span>
                                                        </div>

                                                        <!-- Informasi Tanggal & Telepon dengan ikon beraksen -->
                                                        <div class="d-flex flex-column gap-1 small">
                                                            <div class="text-dark d-flex align-items-center">
                                                                @if ($pegawai->tanggal_usul)
                                                                    <span
                                                                        class="badge bg-light text-secondary border p-1 me-2 d-flex align-items-center justify-content-center"
                                                                        style="width: 22px; height: 22px;">
                                                                        <i class="bi bi-calendar-event"></i>
                                                                    </span>
                                                                    <span class="fw-medium">
                                                                        {{ $pegawai->tanggal_usul->isoFormat('DD-MMM-YYYY') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="text-dark d-flex align-items-center">
                                                                <span
                                                                    class="badge bg-light text-secondary border p-1 me-2 d-flex align-items-center justify-content-center"
                                                                    style="width: 22px; height: 22px;">
                                                                    <i class="bi bi-telephone"></i>
                                                                </span>
                                                                <span class="fw-medium">{{ $pegawai->telepon }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-between mb-1"
                                                            style="max-width: 180px;">
                                                            <span class="text-muted">Identitas Diri</span>
                                                            <i class="bi bi-check-circle-fill text-success"
                                                                title="True"></i>
                                                        </div>
                                                        <div class="d-flex justify-content-between mb-1"
                                                            style="max-width: 180px;">
                                                            <span class="text-muted">Pasangan</span>
                                                            @if ($pegawai->mempunyai_pasangan && $pegawai->pasangan)
                                                                <i class="bi bi-check-circle-fill text-success"
                                                                    title="True"></i>
                                                            @else
                                                                <i class="bi bi-x-circle-fill text-danger"
                                                                    title="False"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex justify-content-between mb-1"
                                                            style="max-width: 180px;">
                                                            <span class="text-muted">Anak</span>
                                                            @if ($pegawai?->pasangan?->mempunyai_anak && $pegawai?->pasangan?->anak)
                                                                <i class="bi bi-check-circle-fill text-success"
                                                                    title="True"></i>
                                                            @else
                                                                <i class="bi bi-x-circle-fill text-danger"
                                                                    title="False"></i>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex justify-content-between"
                                                            style="max-width: 180px;">
                                                            <span class="text-muted">Dokumen</span>
                                                            @if ($pegawai->status_usul > 0)
                                                                <i class="bi bi-check-circle-fill text-success"
                                                                    title="True"></i>
                                                            @else
                                                                <i class="bi bi-exclamation-circle-fill text-warning"
                                                                    title="Belum Lengkap"></i>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $pegawai->status_usul_badge }} text-dark border border-dark">{{ $pegawai->status_usul_text }}</span>
                                                        <div class="text-muted my-2 d-flex align-items-center gap-1">
                                                            <span
                                                                class="badge bg-{{ $pegawai->progresUsul->warna ?? 'danger' }} bg-opacity-10 text-dark border border-{{ $pegawai->progresUsul->warna ?? 'danger' }} border-opacity-25 px-2 py-1 fw-semibold">
                                                                <i class="bi bi-clock-history me-1"></i>
                                                                {{ $pegawai->progresUsul->keterangan ?? 'Belum Selesai Input' }}
                                                            </span>
                                                        </div>
                                                        <div
                                                            class="badge bg-secondary-subtle text-dark border border-secondary border-opacity-25 fw-semibold">
                                                            <i>
                                                                >
                                                                {{ $pegawai->keterangan_usul ?? 'Inputan Belum Selesai' }}
                                                            </i>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <x-partials.forms.action-button icon="bi-info-circle"
                                                            label="Lihat" color="dark" wireClick="method" />
                                                        <!-- Tombol Hapus -->
                                                        <x-partials.forms.action-button icon="bi-bookmark-check"
                                                            label="Tag" color="success" wireClick="method" />
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center py-5">
                                                        <div
                                                            class="d-flex flex-column align-items-center justify-content-center py-4">
                                                            <!-- Lingkaran Ikon -->
                                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-3 shadow-sm"
                                                                style="width: 70px; height: 70px;">
                                                                <i class="bi bi-folder-x text-muted fs-2"></i>
                                                            </div>
                                                            <!-- Teks Informasi -->
                                                            <h6 class="fw-bold text-dark mb-4">Data Tidak Ditemukan
                                                            </h6>
                                                            <!-- Tombol Reset / Aksi Opsional -->
                                                            <button type="button" wire:click="resetFilter"
                                                                class="btn btn-outline-primary btn-sm px-3">
                                                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                                                                Filter
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{-- LOADING OVERLAY --}}
                                <div wire:loading.flex
                                    wire:target="jenis_pensiun_id, progres_usul_id, search_nama, search_nip"
                                    class="position-absolute top-0 start-0 w-100 h-100 justify-content-center align-items-center rounded-2"
                                    style="z-index: 10;min-height: 200px;background-color: rgba(255, 255, 255, 0.75);">

                                    <div
                                        class="d-flex align-items-center gap-2 px-3 py-2 bg-white shadow-sm rounded-pill border text-primary">

                                        <div class="spinner-border spinner-border-sm" role="status">
                                        </div>

                                        <span class="small fw-semibold">
                                            Memuat data...
                                        </span>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Bagian Pagination -->
                    <div class="panel-footer px-3 py-3 border-top pt-5">
                        {{ $list_pegawai->links('livewire::bootstrap') }}
                    </div>
                </section>
            </div>
        </section>

    </div>
</div>
