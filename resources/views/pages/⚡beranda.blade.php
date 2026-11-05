<?php

use App\Models\DokumenInformasi;
use Livewire\Component;

new class extends Component {
    public $list_dokumen_informasi = null;

    public function mount()
    {
        $this->list_dokumen_informasi = DokumenInformasi::where('format_file', 'docx')->get();
    }
};
?>

<div>
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="row g-3">
            <!-- Kolom Kiri: Tentang Aplikasi & Quote -->
            <div class="col-lg-4">
                <!-- Card Tentang Aplikasi -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-3 p-md-4">
                        <h5 class="card-title fw-bold text-dark mb-3 fs-6">
                            <i class="bi bi-info-circle text-primary me-2"></i>Tentang Aplikasi
                        </h5>
                        <div class="text-center my-3">
                            <div class="p-2 bg-light bg-opacity-75 border border-opacity-50 rounded-3 d-inline-block">
                                <div class="d-flex justify-content-center align-items-center gap-3">
                                    <div class="p-1 bg-white rounded shadow-sm d-flex align-items-center justify-content-center"
                                        style="width: 150px; height: 150px;">
                                        <img src="{{ asset('assets/images/brand/logo-kabkapuas.png') }}"
                                            style="max-height: 130px; max-width: 100%; object-fit: contain;"
                                            alt="Logo Kab Kapuas">
                                    </div>
                                    {{-- <div class="vr opacity-25" style="height: 35px;"></div> --}}
                                    <div class="p-1 bg-white rounded shadow-sm d-flex align-items-center justify-content-center"
                                        style="width: 150px; height: 150px;">
                                        <img src="{{ asset('assets/images/brand/logo-siupin.webp') }}"
                                            style="max-height: 130px; max-width: 100%; object-fit: contain;"
                                            alt="Logo SIUPIN">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="card-text text-muted small lh-base" style="text-align: justify">
                            <b>SIUPIN</b> (Sistem Informasi Usul Pensiun) adalah aplikasi layanan kepegawaian untuk
                            mempermudah proses pengusulan pensiun pegawai negeri secara cepat, transparan, dan
                            terintegrasi dari persiapan hingga masa purna tugas.
                        </p>
                    </div>
                </div>

                <!-- Card Quote (Dibuat Minimalis / Border Tipis) -->
                <div class="card border-0 shadow-sm border-start border-primary border-4">
                    <div class="card-body p-3">
                        <blockquote class="blockquote mb-0">
                            <p class="text-secondary mb-2 fst-italic" style="text-align: justify; font-size: 0.9rem;">
                                "Tetaplah menjadi baik, jika beruntung kita akan menemukan orang baik, jika tidak kita
                                akan
                                ditemukan oleh orang baik."
                            </p>
                            <footer class="blockquote-footer text-muted fs-7 m-0">
                                <cite title="Source Title"><strong>i'mnot <i class="bi bi-robot"></i></strong></cite>
                            </footer>
                        </blockquote>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Persyaratan & Dokumen -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3 p-md-4">
                        <!-- Header Persyaratan -->
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                            <i class="bi bi-journal-check text-primary fs-5"></i>
                            <h5 class="card-title fw-bold mb-0 text-dark fs-6">Persyaratan Usul Pensiun</h5>
                        </div>

                        <!-- Regulasi -->
                        <div class="mb-3 small">
                            <p class="text-muted mb-2">Penentuan klasifikasi jenis pensiun PNS merujuk pada regulasi
                                berikut:</p>
                            <ul class="text-muted ps-3 mb-2">
                                <li>Peraturan Pemerintah No. 11 Tahun 2017 tentang Manajemen PNS</li>
                                <li>Peraturan Pemerintah No. 35 Tahun 2019</li>
                                <li>Peraturan BKN No. 2 Tahun 2018 terkait tata cara teknis</li>
                                <li>Surat Edaran Bupati Kabupaten Kapuas Nomor <strong>800/122/P3I/BKPSDM/2025</strong>
                                </li>
                            </ul>
                        </div>

                        <p class="card-text text-muted small lh-base" style="text-align: justify">
                            Pengajuan usul pensiun wajib memenuhi kelengkapan administratif sesuai ketentuan
                            perundang-undanganyang berlaku agar proses verifikasi berjalan tertib dan lancar.
                        </p>

                        <!-- Informasi Kontak Bantuan / Konsultasi Pemberkasan -->
                        <div
                            class="alert alert-info border-0 bg-light border-start border-info border-3 small text-secondary py-2 px-3 mb-3">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-headset text-info fs-5 mt-1"></i>
                                <div>
                                    <span class="fw-bold text-dark">Butuh Bantuan Pemberkasan?</span><br>
                                    Jika terjadi kendala atau permasalahan dalam pengusulan pensiun, Anda dapat
                                    menghubungi:
                                    <ul class="mb-0 mt-1 ps-3">
                                        <li><strong>Bhinneke Dwi Pratiwi, SE, M.A.P</strong> : <a
                                                href="https://wa.me/+62895406090257" target="_blank"
                                                class="text-decoration-none">0895-4060-90257</a></li>
                                        <li><strong>Ayu Maulida Agustina, S.Pd</strong> : <a
                                                href="https://wa.me/+6288705042349" target="_blank"
                                                class="text-decoration-none">0887-0504-2349</a></li>
                                        <li><strong>Bastian, S.kom</strong> : <a href="https://wa.me/+6285821022127"
                                                target="_blank" class="text-decoration-none">0858-2102-2127</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <p class="fw-bold text-dark small mt-3 mb-2">Adapun persyaratan dokumen yang diperlukan:</p>

                        <!-- List Persyaratan Lebih Rapat & Ringkas -->
                        <ol class="text-muted ps-3 mb-3 lh-sm">
                            <li class="mb-1"><strong>Surat Pengantar</strong> dari Kepala Dinas / Instansi / Unit
                                Kerja masing-masing.</li>
                            <li class="mb-1"><strong>Surat Permohonan Pensiun</strong> (format tersedia di bawah).
                            </li>
                            <li class="mb-1"><strong>Surat Pernyataan</strong> tidak pernah dijatuhi hukuman
                                <strong>disiplin</strong> tingkat sedang/berat.
                            </li>
                            <li class="mb-1"><strong>Surat Pernyataan</strong> tidak sedang/menjalani proses
                                <strong>pidana atau dipidana penjara</strong> berkekuatan hukum tetap.
                            </li>
                            <li class="mb-1"><strong>SK CPNS</strong> yang asli (jika fotokopi wajib
                                dilegalisir).</li>
                            <li class="mb-1"><strong>SK PNS</strong> (jika fotokopi wajib dilegalisir).</li>
                            <li class="mb-1"><strong>SK Kenaikan Pangkat terakhir</strong> (jika fotokopi
                                wajib dilegalisir).</li>
                            <li class="mb-1"><strong>Surat Peninjauan Masa Kerja (PMK)</strong>.</li>
                            <li class="mb-1"><strong>Surat Keterangan Kematian</strong> suami/istri (jika pengajuan
                                jenis pensiun janda/duda).</li>
                            <li class="mb-1"><strong>Surat Keterangan Kejandaan / Kedudaan</strong> dari
                                Kelurahan/Desa (jika pengajuan
                                jenis pensiun janda/duda).</li>
                            <li class="mb-1"><strong>Surat Nikah / Akta Perkawinan / Akta Cerai</strong>
                                (yang asli atau fotokopi).</li>
                            <li class="mb-1"><strong>Akta Kelahiran Anak</strong> (yang asli atau fotokopi).</li>
                            <li class="mb-1"><strong>Sasaran Kinerja Pegawai (SKP) Tahunan Terakhir</strong>.</li>
                            <li class="mb-1"><strong>Kartu Keluarga (KK)</strong> (yang asli atau fotokopi).</li>
                            <li class="mb-1"><strong>Kartu Tanda Penduduk (KTP)</strong> (pemohon dan pasangan yang
                                asli atau fotokopi).</li>
                            <li class="mb-1"><strong>Pasfoto formal</strong> berwarna latar bebas.</li>
                        </ol>

                        <!-- Catatan / Warning Box Lebih Simpel -->
                        <div
                            class="alert alert-warning border-0 bg-light border-start border-warning border-3 small text-secondary py-2 px-3 mb-3">
                            <strong>Catatan:</strong> Dokumen nomor <strong>8 s/d 12</strong> bersifat opsional (wajib
                            diunggah jika ada). <strong>PDF maksimal 750 kb</strong> (kecuali pasfoto bentuk
                            jpeg/jpg/png).
                        </div>

                        <!-- List Dokumen Unduhan -->
                        <div class="mb-3">
                            <span class="d-block fw-bold text-dark small mb-2"><i class="bi bi-download me-1"></i>
                                Format
                                Dokumen Pendukung:</span>
                            <div class="list-group list-group-flush small">
                                @forelse ($list_dokumen_informasi as $dokumen_informasi)
                                    <a href="{{ asset('storage/dokumen-informasi/' . $dokumen_informasi->nama_file) }}"
                                        target="_blank"
                                        class="list-group-item list-group-item-action py-1 px-2 text-primary">
                                        <i class="bi bi-file-earmark-word me-1"></i> {{ $dokumen_informasi->label }}
                                    </a>
                                @empty
                                    <div class="text-center py-3 text-muted small">
                                        <i class="bi bi-folder-x fs-4 d-block mb-1"></i>
                                        Belum ada dokumen informasi.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Tombol Aksi yang Proporsional -->
                        @auth
                            <div class="mt-3">
                                <a href="#" class="btn btn-primary btn-sm px-4 py-2 fw-semibold w-100 shadow-sm">
                                    Input Usul Pensiun <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
