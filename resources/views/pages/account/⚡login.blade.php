<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.guest')] class extends Component {
    public $username = '';
    public $password = '';

    public function authenticate()
    {
        $this->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        $user = User::where('username', $this->username)->first();
        if ($user && Hash::check($this->password, $user->password)) {
            session()->regenerate();
            Auth::login($user);
            return redirect()->route('beranda');
        }
        $this->addError('username', 'Username atau password yang Anda masukkan salah.');
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
                <p class="eyebrow text-muted small fw-semibold tracking-wider mb-2">MASUK KE APLIKASI</p>
                <hr class="w-25 mx-auto text-primary opacity-75">
            </div>

            <!-- Informasi / Bantuan Akun & Lupa Password -->
            <div class="alert alert-light border text-start small text-secondary rounded-3 p-3 mb-4 shadow-xs">
                <div class="mb-1">
                    <i class="bi bi-info-circle-fill text-primary me-1"></i> Belum punya akun?
                    <a href="{{ route('register') }}" class="fw-semibold text-decoration-none text-primary">Klik daftar
                        di sini</a>.
                </div>
                <div>
                    <i class="bi bi-headset text-success me-1"></i> Lupa password? Hubungi admin via
                    <a href="https://wa.me/6285821022127?text=Halo%20Admin,%20saya%20lupa%20password%20untuk%20akun%20SIUPIN%20saya."
                        target="_blank"
                        class="fw-semibold text-success text-decoration-none d-inline-flex align-items-center gap-1">
                        <i class="bi bi-whatsapp"></i> WhatsApp : 0858-2102-2127
                    </a>.
                </div>
            </div>

            <!-- Form Login (Livewire) -->
            <form wire:submit="authenticate" class="needs-validation text-start" novalidate>

                <!-- Input Username (NIP) -->
                <div class="mb-3">
                    <label for="username" class="form-label fw-semibold small">Username (Nomor Induk Pegawai)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-person-badge"></i></span>
                        <input type="text" class="form-control" id="username" wire:model="username"
                            placeholder="Masukkan NIP" required>
                    </div>
                    @error('username')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input Password -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold small">Password</label>
                    <div class="position-relative">
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="passwordInput" wire:model="password"
                                placeholder="*******" required>
                        </div>
                        <button type="button"
                            class="btn position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent text-muted px-3"
                            id="togglePassword" style="z-index: 10;">
                            <i class="bi bi-eye fs-5" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button
                    class="btn btn-primary w-100 py-2 fw-semibold shadow-sm d-flex align-items-center justify-content-center gap-2"
                    type="submit">
                    <i class="bi bi-box-arrow-in-right fs-5" aria-hidden="true"></i> Masuk ke Sistem
                </button>
            </form>

        </section>
    </main>

    @push('scripts')
        <script>
            document.getElementById('togglePassword').addEventListener('click', function() {
                const passwordInput = document.getElementById('passwordInput');
                const toggleIcon = document.getElementById('toggleIcon');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('bi-eye');
                    toggleIcon.classList.add('bi-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('bi-eye-slash');
                    toggleIcon.classList.add('bi-eye');
                }
            });
        </script>
    @endpush
</div>
