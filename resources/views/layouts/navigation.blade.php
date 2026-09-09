<aside class="halo-sidebar flex-shrink-0 d-flex flex-column p-3 p-lg-4">
    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
        class="d-flex align-items-center gap-3 text-decoration-none text-white mb-4">
        <span class="halo-brand-mark rounded-3 d-inline-flex align-items-center justify-content-center fw-bold"
            style="width: 42px; height: 42px;">H</span>
        <span><strong class="d-block fs-5">HALO IT</strong><small class="text-white-50">Pusat bantuan</small></span>
    </a>

    <div class="text-uppercase text-white-50 small fw-semibold mb-2 px-2">Menu utama</div>
    <nav class="nav flex-column gap-1">
        @if (Auth::user()->role === 'admin')
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                href="{{ route('admin.dashboard') }}"><span class="me-2">&#9632;</span> Dasbor</a>
            <a class="nav-link {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}"
                href="{{ route('admin.tickets.index') }}"><span class="me-2">&#9776;</span> Semua tiket</a>
            <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
                href="{{ route('admin.reports.index') }}"><span class="me-2">&#9612;</span> Laporan</a>
        @else
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                href="{{ route('dashboard') }}"><span class="me-2">&#9632;</span> Dasbor</a>
            <a class="nav-link {{ request()->routeIs('tickets.*') ? 'active' : '' }}"
                href="{{ route('tickets.index') }}"><span class="me-2">&#9776;</span> Tiket saya</a>
            <a class="nav-link {{ request()->routeIs('tickets.create') ? 'active' : '' }}"
                href="{{ route('tickets.create') }}"><span class="me-2">&#43;</span> Buat tiket</a>
        @endif
    </nav>

    <div class="mt-auto pt-4">
        <div class="rounded-4 bg-white bg-opacity-10 p-3 mb-3">
            <small class="text-white-50 d-block mb-1">Need help?</small>
            <span class="text-white small">Tim IT siap membantu.</span>
        </div>
        <div class="d-flex align-items-center gap-2 border-top border-white border-opacity-10 pt-3">
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-semibold"
                style="width: 38px; height: 38px;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div class="flex-grow-1 overflow-hidden"><strong
                    class="text-white d-block text-truncate small">{{ Auth::user()->name }}</strong><small
                    class="text-white-50">{{ Auth::user()->role === 'admin' ? 'Administrator' : 'Employee' }}</small>
            </div>
            <div class="dropdown">
                <button class="btn btn-sm text-white-50" data-bs-toggle="dropdown"
                    aria-label="Account menu">&#8942;</button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">@csrf<button
                                class="dropdown-item text-danger">Log out</button></form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>
