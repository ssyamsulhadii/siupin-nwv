<?php

use App\Models\DataPns;
use App\Models\JabatanNominatif;
use App\Models\JenisPensiun;
use Livewire\Component;

new class extends Component {
    public int $step = 1;
    public $list_jenis_pensiun;
    public $list_jabatan_nominatif;
    public array $form_identitas_diri = [
        //
    ];

    public function mount()
    {
        $pegawai = DataPns::findByNip(Auth::user()->username);
        $this->form_identitas_diri = [
            'nama' => $pegawai->nama,
            'nik' => $pegawai->nik,
            'jenis_kelamin' => $pegawai->jenis_kelamin,
            'tanggal_lahir' => $pegawai->tanggal_lahir,
            'nip' => $pegawai->nip,
            'unit_organisasi' => $pegawai->unit_organisasi,
            'pangkat_golongan' => $pegawai->golongan_akhir,
            'jabatan' => $pegawai->jabatan,
        ];
        $this->list_jenis_pensiun = JenisPensiun::all();
        $this->list_jabatan_nominatif = JabatanNominatif::all();
    }

    public function nextStepFormIdentitasPasangan()
    {
        $this->step = 2;
    }
    public function nextStepFormIdentitasAnak()
    {
        $this->step = 3;
    }
    public function nextStepUploadDokumen()
    {
        $this->step = 4;
    }
};
?>

<div>
    <div class="container-fluid px-3 px-lg-4 py-4">
        <x-partials.display.page-title title="Usul Pensiun"></x-partials.display.page-title>
        <section class="row g-3">
            @if ($step == 1)
                @include('pages.usul-pensiun.step-1-form-identitas-diri')
            @elseif ($step == 2)
                @include('pages.usul-pensiun.step-2-form-identitas-pasangan')
            @elseif ($step == 3)
                @include('pages.usul-pensiun.step-3-form-identitas-anak')
            @elseif ($step == 4)
                @include('pages.usul-pensiun.step-4-upload-dokumen')
            @endif
        </section>
    </div>
</div>
