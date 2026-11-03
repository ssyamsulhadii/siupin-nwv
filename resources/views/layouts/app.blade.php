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
    <div class="admin-shell">
        <div class="sidebar-backdrop" data-sidebar-close></div>

        <x-partials.display.sidebar></x-partials.display.sidebar>

        <div class="admin-main">
            <x-partials.display.navbar></x-partials.display.navbar>


            <main class="dashboard-content">
                {{ $slot }}
            </main>

            <x-partials.display.footer></x-partials.display.footer>
        </div>
    </div>

    @livewireScripts
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>
