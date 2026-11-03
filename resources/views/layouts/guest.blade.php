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
</head>

<body>
    <div class="auth-body">

        {{ $slot }}
    </div>

    @livewireScripts
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>


    {{-- <script>
        document.addEventListener('click', function(event) {
            if (event.target.closest('#togglePassword')) {
                const passwordInput = document.getElementById('password');
                const toggleIcon = document.getElementById('toggleIcon');

                if (passwordInput) {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    if (type === 'text') {
                        toggleIcon.classList.remove('bi-eye');
                        toggleIcon.classList.add('bi-eye-slash');
                    } else {
                        toggleIcon.classList.remove('bi-eye-slash');
                        toggleIcon.classList.add('bi-eye');
                    }
                }
            }
        });
    </script> --}}

    @stack('scripts')
</body>

</html>
