<?php

use App\Models\Pegawai;
use Livewire\Component;

new class extends Component {
    public $activeTab = 'diri'; // Default tab yang dibuka pertama kali
    public $pegawai;
    public $pasangan;
    public $list_anak = null;
    public $dokumen_pensiun = null;
    public $pathFileAkses = null;
    public $titleDokumen = '';

    public function mount($pegawai)
    {
        $pegawai = Pegawai::firstWhere('nip', $pegawai);
        $this->pegawai = $pegawai;
        $this->pasangan = $pegawai?->pasangan;
        $this->list_anak = $this->pegawai->pasangan->anak;
        $this->dokumen_pensiun = $pegawai->dokumenPensiun;
    }

    public function previewFile($folder, $fileName, $titleDokumen)
    {
        $this->titleDokumen = $titleDokumen;
        $this->pathFileAkses = 'storage/dokumen-pensiun/' . $folder . '/' . $fileName;
        $this->dispatch('open-modal-previewModalDokumen');
    }
};
?>

<div>
    <x-partials.display.preview-file-modal id="previewModalDokumen" title="{{ $titleDokumen }}"
        path="{{ $pathFileAkses }}" />
    <div class="container-fluid px-3 px-lg-4 py-4">
        <x-partials.display.page-title title="Detail Usulan"></x-partials.display.page-title>
        <section class="row g-3">
            <div class="col-12">
                <section class="panel">
                    <div class="panel-header mb-4 p-4 bg-white rounded shadow-sm border border-1">
                        <!-- Judul Section -->
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                                <i class="bi bi-table text-primary fs-3" aria-hidden="true"></i>
                                <span>Form Informasi Usulan</span>
                            </h2>
                            <!-- Status Usul (Tampil jika bukan 0) dengan ukuran besar dan tegas -->
                            @if ($pegawai->status_usul != 0)
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-muted fw-semibold fs-6">Status:</span>
                                    <span
                                        class="badge bg-{{ $pegawai->status_usul_badge }} fs-5 px-4 py-2 shadow-sm rounded-pill">
                                        <i class="bi {{ $pegawai->status_usul_icon }} me-1"></i>
                                        {{ $pegawai->status_usul_text }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <!-- Keterangan Usul dengan Desain Banner / Alert yang Tegas -->
                        @if ($pegawai->status_usul != 0 && !empty($pegawai->keterangan_usul))
                            <div class="mt-3 p-3 bg-light border-start border-4 border-primary rounded-end shadow-sm">
                                <div class="d-flex align-items-start gap-3">
                                    <i class="bi bi-info-circle-fill text-primary fs-4 mt-1"></i>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1">Catatan / Keterangan Admin:</h6>
                                        <p class="mb-0 text-danger fs-5">
                                            {{ $pegawai->keterangan_usul }}
                                        </p>
                                    </div>
                                    <x-partials.feedback.alert />
                                </div>
                            </div>
                        @endif
                    </div>
                    @if ($pegawai->status_usul != 0)
                        <div class="card shadow-sm border-0">
                            <!-- Card Header dengan Nav Tabs Bootstrap 5 -->
                            <div class="card-header bg-white pt-3 pb-0 border-bottom-0">
                                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                    <!-- Tab 1: Identitas Diri -->
                                    <li class="nav-item" role="presentation">
                                        <button type="button"
                                            class="nav-link {{ $activeTab === 'diri' ? 'active fw-bold' : '' }}"
                                            wire:click="$set('activeTab', 'diri')">
                                            <i class="bi bi-person-badge me-1"></i> Identitas Diri
                                        </button>
                                    </li>

                                    @if ($pegawai->mempunyai_pasangan)
                                        <!-- Tab 2: Identitas Pasangan -->
                                        <li class="nav-item" role="presentation">
                                            <button type="button"
                                                class="nav-link {{ $activeTab === 'pasangan' ? 'active fw-bold' : '' }}"
                                                wire:click="$set('activeTab', 'pasangan')">
                                                <i class="bi bi-heart me-1"></i> Identitas Pasangan
                                            </button>
                                        </li>
                                    @endif

                                    @if (optional($pegawai->pasangan)->mempunyai_anak)
                                        <!-- Tab 3: Identitas Anak -->
                                        <li class="nav-item" role="presentation">
                                            <button type="button"
                                                class="nav-link {{ $activeTab === 'anak' ? 'active fw-bold' : '' }}"
                                                wire:click="$set('activeTab', 'anak')">
                                                <i class="bi bi-people me-1"></i> Identitas Anak
                                            </button>
                                        </li>
                                    @endif

                                    <!-- Tab 4: Dokumen Pensiun -->
                                    <li class="nav-item" role="presentation">
                                        <button type="button"
                                            class="nav-link {{ $activeTab === 'dokumen' ? 'active fw-bold' : '' }}"
                                            wire:click="$set('activeTab', 'dokumen')">
                                            <i class="bi bi-file-earmark-arrow-up me-1"></i> Dokumen Pensiun
                                        </button>
                                    </li>
                                    <!-- Tab 5: Pertek & SK Pensiun -->
                                    <li class="nav-item" role="presentation">
                                        <button type="button"
                                            class="nav-link {{ $activeTab === 'pertek_sk' ? 'active fw-bold' : '' }}"
                                            wire:click="$set('activeTab', 'pertek_sk')">
                                            <i class="bi bi-file-earmark-check me-1"></i> Pertek & SK Pensiun
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <!-- Card Body sebagai Tab Content Pane -->
                            <div class="card-body p-4">
                                <!-- Pane 1: Identitas Diri -->
                                @if ($activeTab === 'diri')
                                    <div wire:key="tab-diri">
                                        <div class="row">
                                            <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled label="Nama"
                                                    value="{{ $pegawai->nama }}" /></div>
                                            <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled label="NIP"
                                                    value="{{ $pegawai->nip }}" /></div>
                                            <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled label="NKK"
                                                    value="{{ $pegawai->nkk }}" /></div>
                                            <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled label="NIK"
                                                    value="{{ $pegawai->nik }}" /></div>
                                            <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                    label="Tanggal Lahir" value="{{ $pegawai->tanggal_lahir }}" />
                                            </div>
                                            <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                    label="Jenis Kelamin" value="{{ $pegawai->jenis_kelamin }}" />
                                            </div>
                                            <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                    label="Unit Organisasi" value="{{ $pegawai->unit_organisasi }}" />
                                            </div>
                                            <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                    label="Rumpun Jabatan"
                                                    value="{{ $pegawai->rumpunJabatan->nama }}" />
                                            </div>
                                            <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                    label="Nama Jabatan" value="{{ $pegawai->nama_jabatan }}" />
                                            </div>
                                            <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                    label="Pangkat Golongan"
                                                    value="{{ $pegawai->pangkat_golongan }}" /></div>

                                            <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                    label="Jenis Pensiun" value="{{ $pegawai->jenisPensiun->nama }}" />
                                            </div>
                                            @if ($pegawai->tanggal_pensiun)
                                                <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                        label="Tanggal Pensiun"
                                                        value="{{ $pegawai->tanggal_pensiun->isoFormat('DD-MMMM-YYYY') }}" />
                                                </div>
                                            @endif
                                            <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                    label="Alamat Sekarang" value="{{ $pegawai->alamat_sekarang }}" />
                                            </div>
                                            <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                    label="Alamat Pensiun" value="{{ $pegawai->alamat_pensiun }}" />
                                            </div>
                                            <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                    label="Nomor Telepon" value="{{ $pegawai->telepon }}" />
                                            </div>
                                            <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                    label="Mempunyai Pasangan"
                                                    value="{{ $pegawai->mempunyai_pasangan ? 'Ya' : 'Tidak' }}" />
                                            </div>
                                            @if ($pegawai->status_pasangan)
                                                <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                        label="Status Pasangan"
                                                        value="{{ $pegawai->status_pasangan }}" />
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                @endif

                                <!-- Pane 2: Identitas Pasangan -->
                                @if ($pegawai->mempunyai_pasangan)
                                    @if ($activeTab === 'pasangan')
                                        <div wire:key="tab-pasangan">
                                            <div class="row">
                                                <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                        label="Nama" value="{{ $pasangan->nama }}" />
                                                </div>
                                                @if ($pasangan->nip)
                                                    <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                            label="NIP" value="{{ $pasangan->nip }}" />
                                                    </div>
                                                @endif
                                                <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                        label="NIK" value="{{ $pasangan->nik }}" />
                                                </div>
                                                <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                        label="Tanggal Lahir"
                                                        value="{{ $pasangan->tanggal_lahir->isoFormat('DD-MM-YYYY') }}" />
                                                </div>
                                                <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                        label="Pekerjaan" value="{{ $pasangan->pekerjaan }}" />
                                                </div>
                                                <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                        label="Nomor Telepon" value="{{ $pasangan->telepon }}" />
                                                </div>
                                                <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                        label="Nomor Akta" value="{{ $pasangan->nomor_akta }}" />
                                                </div>
                                                <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                        label="Tanggak Akta"
                                                        value="{{ $pasangan->tanggal_akta->isoFormat('DD-MM-YYYY') }}" />
                                                </div>
                                                <div class="col-lg-3 mb-3"><x-partials.forms.input-disabled
                                                        label="Mempunyai Anak"
                                                        value="{{ $pasangan->mempunyai_anak ? 'Ya' : 'Tidak' }}" />
                                                </div>
                                                <div class="col-lg-3 mb-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">File Akta</label>
                                                        <button type="button"
                                                            wire:click="previewFile('dokumen-akta', '{{ $pasangan->file_akta }}', 'Dokumen Akta')"
                                                            class="btn btn-warning text-dark fw-bold d-flex align-items-center">
                                                            <i class="bi bi bi-eye me-1"></i> Lihat File
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                <!-- Pane 3: Identitas Anak -->
                                @if (optional($pegawai->pasangan)->mempunyai_anak)
                                    @if ($activeTab === 'anak')
                                        <div wire:key="tab-anak">
                                            <div class="row">
                                                <div class="table-responsive mt-4">
                                                    <table class="table table-bordered align-middle mb-0"
                                                        id="ordersTable" data-searchable-table="">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">No</th>
                                                                <th>Nama-NIK</th>
                                                                <th class="text-center">Tanggal Lahir</th>
                                                                <th class="text-center">Jenis Kelamin</th>
                                                                <th class="text-center">Telepon</th>
                                                                <th>Informasi Akta</th>
                                                                <th class="text-center">File Akta</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($list_anak as $anak)
                                                                <tr>
                                                                    <td class="text-center fw-semibold"
                                                                        style="min-width: 40px;">
                                                                        {{ $loop->iteration }}
                                                                    </td>
                                                                    <td>{{ $anak->nama }} <br> {{ $anak->nik }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $anak->tanggal_lahir->isoFormat('DD-MM-YYYY') }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $anak->jenis_kelamin == 'L' ? 'Laki Laki' : 'Perempuan' }}
                                                                    </td>
                                                                    <td class="text-center">{{ $anak->telepon }}</td>
                                                                    <td>Nomor : {{ $anak->nomor_akta }} <br>
                                                                        Tanggal :
                                                                        {{ $anak->tanggal_akta->isoFormat('DD-MMMM-YYYY') }}
                                                                        <br>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <button type="button"
                                                                            wire:click="previewFile('akta-kelahiran', '{{ $anak->file_akta }}', 'Akta Kelahiran')"
                                                                            class="btn btn-warning text-dark fw-bold">
                                                                            <i class="bi bi bi-eye me-1"></i> Lihat
                                                                            File
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6">
                                                                        <h5 class="text-danger text-center">Data
                                                                            identitas
                                                                            anak belum diinput</h5>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                <!-- Pane 4: Dokumen Pensiun -->
                                @if ($activeTab === 'dokumen')
                                    <div wire:key="tab-dokumen">
                                        <div class="row">
                                            @php
                                                $dokumens = [
                                                    'supeng_instansi' => 'Surat Pengantar Instansi',
                                                    'super_pemohon' => 'Surat Pernyataan Pemohon',
                                                    'super_disiplin' => 'Surat Pernyataan Hukuman Disiplin',
                                                    'super_pidana' => 'Surat Pernyataan Tidak Dipidana',
                                                    'sk_cpns' => 'SK CPNS',
                                                    'sk_pns' => 'SK PNS',
                                                    'sk_pangkat_akhir' => 'SK Pangkat Terakhir',
                                                    'skp_tahunan' => 'SKP Tahunan Terakhir',
                                                    'foto_ktp' => 'Foto KTP',
                                                    'foto_kk' => 'Foto Kartu Keluarga (KK)',
                                                    'pas_foto' => 'Pas Foto Terbaru',
                                                ];
                                            @endphp
                                            @foreach ($dokumens as $field => $label)
                                                <div class="col-lg-3 col-md-6 mb-3">
                                                    <div class="p-3 border rounded bg-light shadow-sm">
                                                        <label
                                                            class="form-label fw-bold mb-2">{{ $label }}</label>
                                                        <div>
                                                            <button type="button"
                                                                wire:click="previewFile('{{ str_replace('_', '-', $field) }}', '{{ $dokumen_pensiun->{$field} }}', '{{ $label }}')"
                                                                class="btn btn-warning text-dark fw-bold btn-sm d-inline-flex align-items-center">
                                                                <i class="bi bi-eye me-1"></i> Lihat File
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if ($dokumen_pensiun->sk_pmk)
                                                <div class="col-lg-3 col-md-6 mb-3">
                                                    <div class="p-3 border rounded bg-light shadow-sm">
                                                        <label class="form-label fw-bold mb-2">SK PMK</label>
                                                        <div>
                                                            <button type="button"
                                                                wire:click="previewFile('sk-pmk', '{{ $dokumen_pensiun->sk_pmk }}', 'SK PMK')"
                                                                class="btn btn-warning text-dark fw-bold d-inline-flex align-items-center">
                                                                <i class="bi bi-eye me-1"></i> Lihat File
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Pane 5: Pertek & SK Pensiun -->
                                @if ($activeTab === 'pertek_sk')
                                    <div wire:key="tab-pertek-sk">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 mb-3">
                                                <div class="p-3 border rounded bg-light shadow-sm">
                                                    <label class="form-label fw-bold mb-2">Pertek Pensiun</label>
                                                    <div>
                                                        @if ($dokumen_pensiun->pertek_pensiun)
                                                            <button type="button"
                                                                wire:click="previewFile('pertek-pensiun', '{{ $dokumen_pensiun->pertek_pensiun }}', 'Pertek Pensiun')"
                                                                class="btn btn-warning text-dark fw-bold d-inline-flex align-items-center">
                                                                <i class="bi bi-eye me-1"></i> Lihat File
                                                            </button>
                                                        @else
                                                            <div class="badge bg-danger">Pertek Pensiun Belum Tersedia
                                                                . . .</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 mb-3">
                                                <div class="p-3 border rounded bg-light shadow-sm">
                                                    <label class="form-label fw-bold mb-2">SK Pensiun</label>
                                                    <div>
                                                        @if ($dokumen_pensiun->sk_pensiun)
                                                            <button type="button"
                                                                wire:click="previewFile('sk-pensiun', '{{ $dokumen_pensiun->sk_pensiun }}', 'SK Pensiun')"
                                                                class="btn btn-warning text-dark fw-bold d-inline-flex align-items-center">
                                                                <i class="bi bi-eye me-1"></i> Lihat File
                                                            </button>
                                                        @else
                                                            <div class="badge bg-danger">SK Pensiun Belum Tersedia . .
                                                                .</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    @else
                        <div class="card shadow-sm border-0 p-3 pt-4">
                            <div class="alert alert-warning d-flex align-items-center shadow-sm border-0"
                                role="alert">
                                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2 fs-4"></i>
                                <div>
                                    <strong>Perhatian!</strong> Data Usul Pensiun Belum Selesai Diinput.
                                </div>
                            </div>
                        </div>
                    @endif
                </section>
            </div>
        </section>
    </div>


</div>
