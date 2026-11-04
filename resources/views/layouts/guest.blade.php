<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="adminHMD professional admin dashboard template">
    <title>SIUPIN | P3I-BKPSDM Kabupaten Kapuas</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/brand/logo-siupin.webp') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @livewireStyles
    @stack('styles')
    <style>
        /* Mengunci tombol agar tetap diam dan tidak berubah warna background saat di-hover */
        .no-hover-effect:hover {
            background-color: transparent !important;
            transform: none !important;
            box-shadow: none !important;
            /* Warna teks dan border akan tetap mempertahankan kondisi aslinya (normal / error) */
        }
    </style>
</head>

<body>
    <div class="auth-body">

        {{ $slot }}
    </div>

    @livewireScripts
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
    <script>
        document.addEventListener('click', function(event) {
            const toggleBtn = event.target.closest('.toggle-password-btn');
            if (!toggleBtn) return;

            const targetId = toggleBtn.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId);
            const toggleIcon = toggleBtn.querySelector('.toggle-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    </script>
</body>

</html>
