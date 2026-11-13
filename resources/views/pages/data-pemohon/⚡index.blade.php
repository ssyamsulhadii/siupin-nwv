<?php

use App\Models\JenisPensiun;
use App\Models\Pegawai;
use Livewire\Component;

new class extends Component {
    public $list_jenis_pensiun;
    public $total_pegawai;

    public function mount()
    {
        // Mengambil data jenis pensiun beserta jumlah pegawai yang berelasi
        $this->list_jenis_pensiun = JenisPensiun::withCount('pegawai')->get();

        // Menghitung total keseluruhan pegawai
        $this->total_pegawai = Pegawai::count();
    }
};
?>

<div>
    <div class="container-fluid px-3 px-lg-4 py-4">
        <x-partials.display.page-title title="Tampil Data"></x-partials.display.page-title>
        <section class="row g-3 mt-1" aria-label="Dashboard metrics">
            <!-- Card Total Keseluruhan -->
            <div class="col-12 col-sm-4 col-md-3 col-xl-2">
                <article class="metric-card metric-success">
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
                    <article class="metric-card metric-success">
                        <div class="metric-top">
                            <span class="metric-label">{{ $jenis_pensiun->nama }}</span>
                            <span class="metric-icon"><i class="bi bi-send" aria-hidden="true"></i></span>
                        </div>
                        <!-- Mengambil hasil withCount pegawai_count -->
                        <div class="fw-bold fs-1 text-center">{{ $jenis_pensiun->pegawai_count }}</div>
                    </article>
                </div>
            @endforeach
        </section>
    </div>
</div>
