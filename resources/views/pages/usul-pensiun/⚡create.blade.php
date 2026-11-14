<?php

use App\Models\DataPns;
use App\Models\JenisPensiun;
use App\Models\Pegawai;
use App\Models\RumpunJabatan;
use App\Models\Pasangan;
use App\Models\Anak;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFileUploads;
    public int $step = 1;
    public $list_jenis_pensiun;
    public $list_rumpun_jabatan;
    public $pegawai;
    public $pasangan;
    public $list_anak = null;
    public ?int $anak_id = null;
    public $old_nama_file = null;
    public $pathFileAkses = null;
    public $titleDokumen = null;
    public array $data_mapping = [];
    public array $form_identitas_diri = [];
    public array $form_identitas_pasangan = [];
    public array $form_identitas_anak = [];
    public array $form_upload_dokumen = [];

    public function mount()
    {
        $this->form_identitas_diri = config('propertiUsulPensiun.identitas_diri');
        $this->form_identitas_pasangan = config('propertiUsulPensiun.identitas_pasangan');
        $this->form_identitas_anak = config('propertiUsulPensiun.identitas_anak');
        $this->form_upload_dokumen = config('propertiUsulPensiun.upload_dokumen');
        $pegawai = Pegawai::firstWhere('nip', Auth::user()->username);
        if ($pegawai) {
            $this->pegawai = $pegawai;
            $this->pegawai->golongan_akhir = $pegawai->pangkat_golongan;
        } else {
            $this->pegawai = DataPns::findByNip(Auth::user()->username);
        }

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

        // Jika data pegawai ada DAN statusnya 1 (Terkirim) atau 3 (Diterima), maka tolak akses
        if ($pegawai && in_array($pegawai?->status_usul, [1, 3])) {
            session()->flash('warning', 'Data usul pensiun sudah terkirim, hubungi admin untuk perbaikan data!');
            return to_route('usul-pensiun.detail_usulan', ['pegawai' => $pegawai->nip]);
        }

        // Mapping Data Pegawai
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
            ];
            $this->pegawai = $pegawai;
            // Mapping Data Pasangan
            if ($pegawai->pasangan) {
                $this->pasangan = $pegawai->pasangan;
                $this->form_identitas_pasangan = [
                    'nama' => $this->pasangan->nama,
                    'nip' => $this->pasangan->nip,
                    'nik' => $this->pasangan->nik,
                    'tanggal_lahir' => $this->pasangan->tanggal_lahir->isoFormat('YYYY-MM-DD'),
                    'telepon' => $this->pasangan->telepon,
                    'pekerjaan' => $this->pasangan->pekerjaan,
                    'nomor_akta' => $this->pasangan->nomor_akta,
                    'mempunyai_anak' => $this->pasangan->mempunyai_anak,
                    'tanggal_akta' => $this->pasangan->tanggal_akta->isoFormat('YYYY-MM-DD'),
                    // 'file_akta' => $this->pasangan->file_akta,
                    'pegawai_id' => $this->pasangan->pegawai_id,
                ];
                if ($this->pasangan->mempunyai_anak) {
                    $this->list_anak = $this->pasangan->anak;
                }
            }
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
            'form_identitas_diri.telepon' => 'required|numeric|digits_between:11,15',
            'form_identitas_diri.alamat_pensiun' => 'required|string',
            'form_identitas_diri.mempunyai_pasangan' => 'required|in:1,0',
            'form_identitas_diri.status_pasangan' => 'required_if:form_identitas_diri.mempunyai_pasangan,1',
        ]);
        $item_value = array_merge($this->data_mapping, $validated['form_identitas_diri'] ?? []);
        $pegawai = Pegawai::updateOrCreate(['user_id' => auth()->id()], $item_value);
        $pegawai->dokumenPensiun()->updateOrCreate(['pegawai_id' => $pegawai->id], []);
        $this->pegawai = $pegawai;
        if ($pegawai->mempunyai_pasangan) {
            $this->step = 2;
        } else {
            $pegawai->update(['status_pasangan' => null]);
            $this->step = 4;
        }
    }

    //berada pada view step-2-form-identitas-pasangan
    public function saveIdentitasPasangan()
    {
        $this->form_identitas_pasangan['pegawai_id'] = $this->pegawai->id;

        $hasPasangan = $this->pegawai->pasangan;
        $isPensiunJandaDuda = $this->pegawai->jenis_pensiun_id == 3;

        // Aturan validasi dinamis untuk file akta
        $ruleAkta = $hasPasangan ? 'sometimes' : 'required';

        // Aturan validasi dinamis untuk suket kematian & suket janda/duda
        // Wajib diisi jika jenis_pensiun_id == 3 dan belum ada file sebelumnya di database
        $ruleSuketKematian = $isPensiunJandaDuda ? ($hasPasangan && $hasPasangan->suket_kematian ? 'sometimes|file|mimes:pdf|max:750' : 'required|file|mimes:pdf|max:750') : 'nullable|file|mimes:pdf|max:750';

        $ruleSuketJandaDuda = $isPensiunJandaDuda ? ($hasPasangan && $hasPasangan->suket_janda_duda ? 'sometimes|file|mimes:pdf|max:750' : 'required|file|mimes:pdf|max:750') : 'nullable|file|mimes:pdf|max:750';

        $validated = $this->validate([
            'form_identitas_pasangan.nama' => 'required|string',
            'form_identitas_pasangan.nip' => 'nullable|numeric|digits:18',
            'form_identitas_pasangan.nik' => 'required|numeric|digits:16',
            'form_identitas_pasangan.tanggal_lahir' => 'required|date',
            'form_identitas_pasangan.telepon' => 'required|numeric|digits_between:11,15',
            'form_identitas_pasangan.pekerjaan' => 'required|string',
            'form_identitas_pasangan.nomor_akta' => 'required|string',
            'form_identitas_pasangan.tanggal_akta' => 'required|date',
            'form_identitas_pasangan.mempunyai_anak' => 'required|in:1,0',
            'form_identitas_pasangan.pegawai_id' => 'required|exists:pegawai,id',
            'form_identitas_pasangan.file_akta' => $ruleAkta . '|file|mimes:pdf|max:750',
            'form_identitas_pasangan.suket_kematian' => $ruleSuketKematian,
            'form_identitas_pasangan.suket_janda_duda' => $ruleSuketJandaDuda,
        ]);

        // 1. Handle File Akta
        if (isset($this->form_identitas_pasangan['file_akta']) && is_object($this->form_identitas_pasangan['file_akta'])) {
            if ($hasPasangan && $hasPasangan->file_akta) {
                Storage::disk('public')->delete('dokumen-pensiun/dokumen-akta/' . $hasPasangan->file_akta);
            }
            $file = $this->form_identitas_pasangan['file_akta'];
            $fileName = $file->hashName();
            $file->storeAs('dokumen-pensiun/dokumen-akta', $fileName, 'public');
            $validated['form_identitas_pasangan']['file_akta'] = $fileName;
        }

        // 2. Handle Suket Kematian
        if (isset($this->form_identitas_pasangan['suket_kematian']) && is_object($this->form_identitas_pasangan['suket_kematian'])) {
            if ($hasPasangan && $hasPasangan->suket_kematian) {
                Storage::disk('public')->delete('dokumen-pensiun/suket-kematian/' . $hasPasangan->suket_kematian);
            }
            $file = $this->form_identitas_pasangan['suket_kematian'];
            $fileName = $file->hashName();
            $file->storeAs('dokumen-pensiun/suket-kematian', $fileName, 'public');
            $validated['form_identitas_pasangan']['suket_kematian'] = $fileName;
        }

        // 3. Handle Suket Janda Duda
        if (isset($this->form_identitas_pasangan['suket_janda_duda']) && is_object($this->form_identitas_pasangan['suket_janda_duda'])) {
            if ($hasPasangan && $hasPasangan->suket_janda_duda) {
                Storage::disk('public')->delete('dokumen-pensiun/suket-janda-duda/' . $hasPasangan->suket_janda_duda);
            }
            $file = $this->form_identitas_pasangan['suket_janda_duda'];
            $fileName = $file->hashName();
            $file->storeAs('dokumen-pensiun/suket-janda-duda', $fileName, 'public');
            $validated['form_identitas_pasangan']['suket_janda_duda'] = $fileName;
        }

        // Simpan ke database
        $pasangan = Pasangan::updateOrCreate(['pegawai_id' => $this->pegawai->id], $validated['form_identitas_pasangan']);

        $this->pasangan = $pasangan;

        // Alur navigasi step berikutnya
        if ($pasangan->mempunyai_anak) {
            $this->reset(['form_identitas_anak', 'anak_id']);
            $this->step = 3;
        } else {
            $this->step = 4;
        }
    }

    //berada pada view step-3-form-identitas-anak
    public function addIdentitasAnak()
    {
        $this->form_identitas_anak['pasangan_id'] = $this->pasangan->id;
        $rule = $this->anak_id ? 'sometimes' : 'required';
        $validated = $this->validate([
            'form_identitas_anak.nama' => 'required|string',
            'form_identitas_anak.nik' => 'required|numeric|digits:16',
            'form_identitas_anak.jenis_kelamin' => 'required|in:L,P',
            'form_identitas_anak.tanggal_lahir' => 'required|date',
            'form_identitas_anak.telepon' => 'required|numeric|digits_between:11,15',
            'form_identitas_anak.nomor_akta' => 'required|string',
            'form_identitas_anak.tanggal_akta' => 'required|date',
            'form_identitas_anak.file_akta' => $rule . '|file|mimes:pdf|max:750',
            'form_identitas_anak.pasangan_id' => 'required|exists:pasangan,id',
            'form_identitas_anak.keterangan' => 'required|string',
        ]);
        if (isset($this->form_identitas_anak['file_akta']) && is_object($this->form_identitas_anak['file_akta'])) {
            if ($this->anak_id) {
                Storage::disk('public')->delete('dokumen-pensiun/akta-kelahiran/' . $this->pasangan->file_akta);
            }
            $file = $this->form_identitas_anak['file_akta'];
            $fileName = $file->hashName();
            $file->storeAs('dokumen-pensiun/akta-kelahiran', $fileName, 'public');
            $validated['form_identitas_anak']['file_akta'] = $fileName;
        }
        Anak::updateOrCreate(['id' => $this->anak_id], $validated['form_identitas_anak']);
        session()->flash('message', 'Data identitas anak berhasil disimpan!');
        $this->reset(['form_identitas_anak', 'anak_id']);
        $this->list_anak = Anak::all();
    }

    public function editIdentitasAnak(Anak $anak)
    {
        $this->anak_id = $anak->id;
        $this->form_identitas_anak = [
            'nama' => $anak->nama,
            'nik' => $anak->nik,
            'jenis_kelamin' => $anak->jenis_kelamin,
            'tanggal_lahir' => $anak->tanggal_lahir->isoFormat('YYYY-MM-DD'),
            'telepon' => $anak->telepon,
            'nomor_akta' => $anak->nomor_akta,
            'tanggal_akta' => $anak->tanggal_akta->isoFormat('YYYY-MM-DD'),
            // 'file_akta' => $anak->file_akta,
            'pasangan_id' => $anak->id,
            'keterangan' => $anak->keterangan,
        ];
    }

    public function deleteIdentitasAnak(Anak $anak)
    {
        Storage::disk('public')->delete('dokumen-pensiun/akta-kelahiran/' . $anak->file_akta);
        $anak->delete();
        $this->list_anak = Anak::all();
        session()->flash('message', 'Data identitas anak berhasil dihapus!');
        $this->reset(['form_identitas_anak', 'anak_id']);
    }

    //berada pada view step-3-form-identitas-anak untuk next step upload dokumen
    public function nextStepUploadDokumen()
    {
        if (count($this->list_anak) > 0) {
            $this->step = 4;
        } else {
            session()->flash('warning', 'Data identitas anak wajib diisi!');
        }
    }

    public function uploadFile($field)
    {
        // / Konfigurasi dinamis untuk setiap jenis dokumen
        $config = [
            'supeng_instansi' => ['folder' => 'supeng-instansi', 'rules' => 'required|file|mimes:pdf|max:750'],
            'super_pemohon' => ['folder' => 'super-pemohon', 'rules' => 'required|file|mimes:pdf|max:750'],
            'super_disiplin' => ['folder' => 'super-disiplin', 'rules' => 'required|file|mimes:pdf|max:750'],
            'super_pidana' => ['folder' => 'super-pidana', 'rules' => 'required|file|mimes:pdf|max:750'],
            'sk_cpns' => ['folder' => 'sk-cpns', 'rules' => 'required|file|mimes:pdf|max:750'],
            'sk_pns' => ['folder' => 'sk-pns', 'rules' => 'required|file|mimes:pdf|max:750'],
            'sk_pangkat_akhir' => ['folder' => 'sk-pangkat-akhir', 'rules' => 'required|file|mimes:pdf|max:750'],
            'sk_pmk' => ['folder' => 'sk-pmk', 'rules' => 'required|file|mimes:pdf|max:750'],
            'skp_tahunan' => ['folder' => 'skp-tahunan', 'rules' => 'required|file|mimes:pdf|max:750'],
            'foto_ktp' => ['folder' => 'foto-ktp', 'rules' => 'required|file|mimes:pdf|max:750'],
            'foto_kk' => ['folder' => 'foto-kk', 'rules' => 'required|file|mimes:pdf|max:750'],
            'pas_foto' => ['folder' => 'pas-foto', 'rules' => 'required|file|mimes:jpg,jpeg,png|max:750'], // Khusus gambar
            'pertek_pensiun' => ['folder' => 'pertek-pensiun', 'rules' => 'required|file|mimes:pdf|max:750'],
            'sk_pensiun' => ['folder' => 'sk-pensiun', 'rules' => 'required|file|mimes:pdf|max:750'],
        ];

        if (!array_key_exists($field, $config)) {
            return;
        }

        $currentConfig = $config[$field];
        // 1. Validasi dinamis berdasarkan konfigurasi
        $this->validate([
            "form_upload_dokumen.{$field}" => $currentConfig['rules'],
        ]);

        $dokumen_pensiun = $this->pegawai->dokumenPensiun;

        // 2. Hapus file fisik lama jika ada di storage
        if ($dokumen_pensiun && $dokumen_pensiun->{$field}) {
            Storage::disk('public')->delete('dokumen-pensiun/' . $currentConfig['folder'] . '/' . $dokumen_pensiun->{$field});
        }

        // 2. Hapus file fisik lama jika ada (pastikan dicek dulu apakah $dokumen_pensiun ada)
        if ($dokumen_pensiun && $dokumen_pensiun->supeng_instansi) {
            Storage::disk('public')->delete('dokumen-pensiun/supeng-instansi/' . $dokumen_pensiun->supeng_instansi);
        }

        // 3. Simpan file baru
        $file = $this->form_upload_dokumen[$field];
        $fileName = $file->hashName();
        $file->storeAs('dokumen-pensiun/' . $currentConfig['folder'], $fileName, 'public');

        // 4. Update database via relasi
        $this->pegawai->dokumenPensiun()->updateOrCreate(['pegawai_id' => $this->pegawai->id], [$field => $fileName]);

        // 5. Refresh memori relasi & reset input form
        $this->pegawai->load('dokumenPensiun');
        $this->form_upload_dokumen[$field] = null;

        // 6. Flash session khusus untuk field ini agar pesannya tidak tertukar
        session()->flash('upload_success_' . $field, 'File berhasil diupload');
    }

    //berada pada view step-4-form-upload-dokumen
    public function saveFinalData()
    {
        $dokumen = $this->pegawai->dokumenPensiun;
        // 1. Daftar 11 kolom yang WAJIB diisi oleh pemohon/pegawai
        $kolomWajib = ['supeng_instansi', 'super_pemohon', 'super_disiplin', 'super_pidana', 'sk_cpns', 'sk_pns', 'sk_pangkat_akhir', 'skp_tahunan', 'foto_ktp', 'foto_kk', 'pas_foto'];
        // 2. Cek apakah semua kolom wajib terisi (tidak ada yang null / kosong)
        $semuaLengkap = collect($kolomWajib)->every(fn($kolom) => !empty($dokumen->{$kolom}));
        if (!$semuaLengkap) {
            session()->flash('warning', 'Data dokumen pensiun tidak lengkap, silakan upload dokumen!');
            return;
        }
        // 3. Jika lolos (11 dokumen wajib terisi), lanjutkan proses finalisasi
        $this->pegawai->update([
            'progres_usul_id' => 1,
            'status_usul' => 1,
            'keterangan_usul' => 'Menunggu verifikasi admin.',
            'tanggal_usul' => now(),
        ]);
        session()->flash('success', 'Usulan pensiun berhasil difinalisasi!');
        return to_route('usul-pensiun.detail_usulan', ['pegawai' => $this->pegawai->nip]);
    }

    public function previousStepFromFinal()
    {
        if ($this->pegawai->mempunyai_pasangan && $this->pasangan->mempunyai_anak) {
            $this->step = 3;
        } elseif ($this->pegawai->mempunyai_pasangan && !$this->pasangan->mempunyai_anak) {
            $this->step = 2;
        } else {
            $this->step = 1;
        }
    }

    public function previewFile($folder, $fileName, $titleDokumen)
    {
        $this->titleDokumen = $titleDokumen;
        $this->pathFileAkses = 'storage/dokumen-pensiun/' . $folder . '/' . $fileName;
        $this->dispatch('open-modal-previewModalDokumen');
    }

    public function resetForm()
    {
        $this->resetValidation();
    }

    protected function validationAttributes()
    {
        return config('propertiUsulPensiun.attributes');
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

    <x-partials.display.preview-file-modal id="previewModalDokumen" title="{{ $titleDokumen }}"
        path="{{ $pathFileAkses }}" />

</div>
