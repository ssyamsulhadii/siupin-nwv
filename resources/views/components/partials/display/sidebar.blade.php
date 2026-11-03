        <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
            <div class="sidebar-header">
                <a class="brand-mark" href="{{ route('beranda') }}" aria-label="adminHMD dashboard">
                    <div class="brand-logo-wrapper">
                        <img src="{{ asset('assets/images/brand/logo-siupin.webp') }}" alt="Logo SIUPIN">
                    </div>
                    <span class="brand-copy">
                        <span class="brand-title"
                            style="background: linear-gradient(135deg, #22c55e 0%, #111827 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 800;">SIUPIN</span>
                        <span class="brand-subtitle">Admin <i class="bi bi-robot"></i></span>
                    </span>
                </a>
            </div>
            <nav class="sidebar-nav">
                <a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}" href="{{ route('beranda') }}"
                    aria-current="page">
                    <span class="nav-icon"><i class="bi bi-house"></i></span>
                    <span class="nav-text">Beranda</span>
                </a>

                @guest
                    <a class="nav-link" href="{{ route('login') }}" aria-current="page">
                        <span class="nav-icon"><i class="bi bi-box-arrow-in-right"></i></span>
                        <span class="nav-text">Masuk</span>
                    </a>
                    <a class="nav-link" href="{{ route('register') }}" aria-current="page">
                        <span class="nav-icon"><i class="bi bi-person-plus"></i></span>
                        <span class="nav-text">Daftar</span>
                    </a>
                @endguest
                {{-- <a class="nav-link {{ request()->routeIs('instansi') ? 'active' : '' }}" href="{{ route('instansi') }}">
                    <span class="nav-icon"><i class="bi bi-bank" aria-hidden="true"></i></span>
                    <span class="nav-text">Instansi</span>
                </a> --}}

                @auth
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start text-danger"
                            style="cursor: pointer;">
                            <span class="nav-icon"><i class="bi bi-box-arrow-right text-danger"></i></span>
                            <span class="nav-text">Keluar</span>
                        </button>
                    </form>
                @endauth
            </nav>

            @auth
                <div class="sidebar-user-profile">
                    <!-- Avatar -->
                    <div class="sidebar-profile-avatar">
                        <img src="{{ asset('assets/images/avatar/account-profile.png') }}" alt="Avatar Pengguna">
                        <span class="sidebar-profile-status"></span>
                    </div>
                    <!-- Informasi Pengguna -->
                    <div class="sidebar-profile-info">
                        <h6 class="text-wrap">{{ Auth::user()->nama }}</h6>
                        <span>@ASN-PNS</span>
                    </div>
                </div>
            @endauth
        </aside>
