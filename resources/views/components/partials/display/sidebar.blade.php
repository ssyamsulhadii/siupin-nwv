        <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
            <div class="sidebar-header">
                <a class="brand-mark" href="{{ route('beranda') }}" aria-label="adminHMD dashboard">
                    <div class="brand-logo-wrapper">
                        <img src="{{ asset('assets/images/brand/logo-siupin.png') }}" alt="Logo SIUPIN">
                    </div>
                    <span class="brand-copy">
                        <span class="brand-title">SIUPIN</span>
                        <span class="brand-subtitle">Admin Template</span>
                    </span>
                </a>
            </div>
            <nav class="sidebar-nav">
                <a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}" href="{{ route('beranda') }}"
                    aria-current="page">
                    <span class="nav-icon"><i class="bi bi-house"></i></span>
                    <span class="nav-text">Beranda</span>
                </a>
                {{-- <a class="nav-link {{ request()->routeIs('instansi') ? 'active' : '' }}" href="{{ route('instansi') }}">
                    <span class="nav-icon"><i class="bi bi-bank" aria-hidden="true"></i></span>
                    <span class="nav-text">Instansi</span>
                </a> --}}
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start text-danger"
                        style="cursor: pointer;">
                        <span class="nav-icon"><i class="bi bi-box-arrow-right text-danger"></i></span>
                        <span class="nav-text">Keluar</span>
                    </button>
                </form>
            </nav>
            <div class="sidebar-user d-flex align-items-center gap-3 px-3 py-3 border-bottom border-light-subtle">
                <!-- Avatar Pengguna dengan efek border/shadow tipis -->
                <div class="flex-shrink-0">
                    <img class="avatar-img avatar-md sidebar-user-avatar rounded-circle shadow-sm object-fit-cover"
                        src="{{ asset('assets/images/avatar/account-profile.png') }}" alt="Avatar"
                        style="width: 45px; height: 45px;">
                </div>

                <!-- Informasi Nama dan Username -->
                <div class="flex-grow-1 overflow-hidden">
                    <h6 class="mb-0 text-truncate fw-semibold text-dark" style="font-size: 0.95rem;">
                        I'm not robot
                    </h6>
                    <div class="text-muted text-truncate d-block" style="font-size: 0.8rem;">
                        @ASN-PNS
                    </div>
                </div>
            </div>
        </aside>
