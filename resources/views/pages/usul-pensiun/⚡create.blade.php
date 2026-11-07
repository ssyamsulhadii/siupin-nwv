<?php

use App\Models\DataPns;
use App\Models\JenisPensiun;
use App\Models\Pegawai;
use App\Models\RumpunJabatan;
use App\Models\Pasangan;
use Livewire\WithFileUploads;
use Livewire\Component;
use Illuminate\Support\Facades\File;

new class extends Component {
    use WithFileUploads;
    public int $step = 1;
    public $list_jenis_pensiun;
    public $list_rumpun_jabatan;
    public $pegawai;
    public $old_nama_file = null;
    public array $data_mapping = [];
    public array $form_identitas_diri = [
        'jenis_pensiun_id' => '',
        'tanggal_pensiun' => null,
        'alamat_sekarang' => '',
        'mempunyai_pasangan' => '',
        'rumpun_jabatan_id' => '',
        'jabatan' => '',
        'telepon' => '',
        'alamat_pensiun' => '',
        'status_pasangan' => null,
        'mempunyai_anak' => false,
    ];
    public array $form_identitas_pasangan = [
        'nama' => '',
        'nip' => null,
        'nik' => '',
        'tanggal_lahir' => '',
        'telepon' => '',
        'pekerjaan' => '',
        'nomor_akta' => '',
        'tanggal_akta' => '',
        'file_akta' => '',
        'pegawai_id' => '',
    ];

    public function mount()
    {
        $this->pegawai = DataPns::findByNip(Auth::user()->username);
        $this->form_identitas_diri['nama_jabatan'] = $this->pegawai->jabatan;
        $this->data_mapping = [
            'nama' => $this->pegawai->nama,
            'nip' => $this->pegawai->nip,
            'nkk' => Auth::user()->nkk,
            'nik' => Auth::user()->nik,
            'tanggal_lahir' => $this->pegawai->tanggal_lahir,
            'unit_organisasi' => $this->pegawai->unit_organisasi,
            'pangkat_golongan' => $this->pegawai->golongan_akhir,
            'jenis_kelamin' => $this->pegawai->jenis_kelamin,
            'user_id' => Auth::user()->id,
        ];
        $pegawai = Pegawai::firstWhere('nip', $this->pegawai->nip);
        if ($pegawai) {
            $this->form_identitas_diri = [
                'jenis_pensiun_id' => $pegawai->jenis_pensiun_id,
                'tanggal_pensiun' => $pegawai->tanggal_pensiun?->isoFormat('YYYY-MM-DD'),
                'alamat_sekarang' => $pegawai->alamat_sekarang,
                'mempunyai_pasangan' => $pegawai->mempunyai_pasangan,
                'rumpun_jabatan_id' => $pegawai->rumpun_jabatan_id,
                'nama_jabatan' => $pegawai->nama_jabatan,
                'jabatan' => $pegawai->jabatan,
                'telepon' => $pegawai->telepon,
                'alamat_pensiun' => $pegawai->alamat_pensiun,
                'status_pasangan' => $pegawai->status_pasangan,
                'mempunyai_anak' => $pegawai->mempunyai_anak,
            ];
            $this->pegawai = $pegawai;
        }
        $this->list_jenis_pensiun = JenisPensiun::all();
        $this->list_rumpun_jabatan = RumpunJabatan::all();
    }

    //berada pada view step-1-form-identitas-diri
    public function saveIdentitasDiri()
    {
        $validated = $this->validate([
            'form_identitas_diri.jenis_pensiun_id' => 'required|exists:jenis_pensiun,id',
            'form_identitas_diri.tanggal_pensiun' => 'nullable|date',
            'form_identitas_diri.alamat_sekarang' => 'required|string',
            'form_identitas_diri.rumpun_jabatan_id' => 'required|exists:rumpun_jabatan,id',
            'form_identitas_diri.nama_jabatan' => 'required|string',
            'form_identitas_diri.telepon' => 'required|numeric',
            'form_identitas_diri.alamat_pensiun' => 'required|string',
            'form_identitas_diri.mempunyai_pasangan' => 'required|in:1,0',
            'form_identitas_diri.status_pasangan' => 'required_if:form_identitas_diri.mempunyai_pasangan,1',
            'form_identitas_diri.mempunyai_anak' => 'required_if:form_identitas_diri.mempunyai_pasangan,1',
        ]);
        $item_value = array_merge($this->data_mapping, $validated['form_identitas_diri'] ?? []);
        $pegawai = Pegawai::updateOrCreate(['user_id' => auth()->id()], $item_value);
        $this->pegawai = $pegawai;
        if ($pegawai->mempunyai_pasangan) {
            $this->step = 2;
        } else {
            $pegawai->update(['status_pasangan' => null, 'mempunyai_anak' => false]);
            $this->step = 4;
        }
    }

    //berada pada view step-2-form-identitas-pasangan
    public function saveIdentitasPasangan()
    {
        $this->form_identitas_pasangan['pegawai_id'] = $this->pegawai->id;
        $validated = $this->validate([
            'form_identitas_pasangan.nama' => 'required|string',
            'form_identitas_pasangan.nip' => 'nullable|numeric|digits:18',
            'form_identitas_pasangan.nik' => 'required|numeric|digits:16',
            'form_identitas_pasangan.tanggal_lahir' => 'required|date',
            'form_identitas_pasangan.telepon' => 'required|numeric',
            'form_identitas_pasangan.pekerjaan' => 'required|string',
            'form_identitas_pasangan.nomor_akta' => 'required|string',
            'form_identitas_pasangan.tanggal_akta' => 'required|date',
            'form_identitas_pasangan.file_akta' => 'required|file|mimes:pdf|max:1000',
            'form_identitas_pasangan.pegawai_id' => 'required|exists:pegawai,id',
        ]);
        dd($validated);
        $pasangan = Pasangan::updateOrCreate(['pegawai_id' => $this->pegawai->id], $validated['form_identitas_pasangan']);
        if ($this->pegawai->mempunyai_anak) {
            $this->step = 3;
        } else {
            $this->step = 4;
        }
    }
    //berada pada view step-3-form-identitas-anak
    public function saveIdentitasAnak()
    {
        $this->step = 4;
    }
    //berada pada view step-4-form-upload-dokumen
    public function saveFinalData()
    {
        //
    }

    public function previousStepFromFinal()
    {
        if ($this->pegawai->mempunyai_pasangan && $this->pegawai->mempunyai_anak) {
            $this->step = 3;
        } elseif ($this->pegawai->mempunyai_pasangan && !$this->pegawai->mempunyai_anak) {
            $this->step = 2;
        } else {
            $this->step = 1;
        }
    }

    public function resetForm()
    {
        $this->resetValidation();
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
