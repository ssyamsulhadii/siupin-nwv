<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\DataPns;
use Illuminate\Validation\Rule;
new #[Layout('layouts.guest')] class extends Component {
    public $username = '';
    public $password = '';
    public $password_confirmation = '';
    public $nik = '';
    public $nkk = '';

    public function register()
    {
        $validated = $this->validate(
            [
                'username' => ['required', 'digits:18', Rule::in(DataPns::nipList()), 'unique:users,username'],
                'nik' => 'required|digits:16|unique:users,nik',
                'nkk' => 'required|digits:16',
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ],
            ['username.in' => 'NIP tidak terdaftar dalam sistem'],
        );
        $validated['password'] = bcrypt($validated['password']);
        $validated['nama'] = DataPns::findByNip($validated['username'])->nama;
        User::create($validated);
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan masuk dengan akun Anda.');
    }
};
?>

<div>
    <main class="auth-page d-flex align-items-center justify-content-center min-vh-100 bg-light py-5">
        <section class="auth-card card shadow-lg border-0 rounded-4 p-4 p-md-5 text-center bg-white"
            style="max-width: 480px; width: 100%;">

            <!-- Logo & Brand Header -->
            <div class="mb-4">
                <img src="{{ asset('assets/images/brand/logo-siupin.webp') }}" alt="Logo Siupin" class="img-fluid"
                    style="height: 170px;">
                <h4 class="fw-bold text-dark mb-1">SIUPIN</h4>
                <p class="eyebrow text-muted small fw-semibold tracking-wider mb-2">PENDAFTARAN AKUN BARU</p>
                <hr class="w-25 mx-auto text-primary opacity-75">
            </div>

            <!-- Informasi Panduan Singkat -->
            <div class="alert alert-light border text-start small text-secondary rounded-3 p-3 mb-4 shadow-xs">
                <div class="mb-1">
                    <i class="bi bi-info-circle-fill text-primary me-1"></i> Pastikan data NIP dan NIK yang Anda
                    masukkan sudah benar dan sesuai.
                </div>
                <div>
                    <i class="bi bi-headset text-success me-1"></i> Mengalami kendala pendaftaran? Hubungi admin via
                    <a href="https://wa.me/6285821022127?text=Halo%20Admin,%20saya%20mengalami%20kendala%20saat%20mendaftar%20akun%20SIUPIN."
                        target="_blank"
                        class="fw-semibold text-success text-decoration-none d-inline-flex align-items-center gap-1">
                        <i class="bi bi-whatsapp"></i> WhatsApp : 0858-2102-2127
                    </a>.
                </div>
            </div>

            <!-- Form Register (Livewire) -->
            <form wire:submit="register" class="needs-validation text-start" novalidate>

                <!-- Input Username (NIP) -->
                <x-partials.forms.input-icon name="username" label="NIP (Nomor Induk Pegawai)" type="number"
                    placeholder="Masukkan NIP" icon="bi-person-badge" wireModel="username" />

                <!-- Input NIK -->
                <x-partials.forms.input-icon name="nkk" label="NKK (Nomor Kartu Keluarga)" type="number"
                    placeholder="Masukkan NKK" icon="bi-card-text" wireModel="nkk" />

                <!-- Input NIK -->
                <x-partials.forms.input-icon name="nik" label="NIK (Nomor Induk Kependudukan)" type="number"
                    placeholder="Masukkan NIK" icon="bi-card-text" wireModel="nik" />

                <!-- Password Utama menggunakan Komponen Baru -->
                <x-partials.forms.input-password name="password" label="Password" placeholder="Minimal 6 karakter"
                    wireModel="password" id="passwordInput" />

                <!-- Konfirmasi Password menggunakan Komponen yang Sama dengan ID Berbeda -->
                <x-partials.forms.input-password name="password_confirmation" label="Konfirmasi Password"
                    placeholder="Ulangi password" wireModel="password_confirmation" id="passwordConfirmInput" />

                <!-- Tombol Submit -->
                <button
                    class="btn btn-primary w-100 py-2 fw-semibold shadow-sm d-flex align-items-center justify-content-center gap-2 my-4"
                    type="submit">
                    <i class="bi bi-person-plus-fill fs-5" aria-hidden="true"></i> Daftar Akun
                </button>

                <!-- Navigasi Kembali ke Login -->
                <div class="text-center small text-muted">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="fw-semibold text-decoration-none text-primary">Masuk di
                        sini</a>
                </div>

            </form>

        </section>
    </main>
</div>
