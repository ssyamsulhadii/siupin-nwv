<nav class="navbar admin-navbar navbar-expand bg-white">
    <div class="container-fluid px-3 px-lg-4">
        <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true"
            aria-label="Toggle sidebar">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="navbar-actions ms-auto">
            <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme"
                title="Switch color theme">
                <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
            </button>

            @auth
                <div class="dropdown">
                    <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img class="avatar-img avatar-sm" src="{{ asset('assets/images/avatar/account-profile.png') }}">
                        <span class="d-none d-sm-inline">
                            {{ Auth::user()->nama }}
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2"
                                    style="cursor: pointer;">
                                    <i class="bi bi-box-arrow-right"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>
</nav>
