<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sembari — @yield('title', 'Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Admin Global CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ \Illuminate\Support\Str::random(8) }}">

    {{-- Per-page CSS (opsional) --}}
    @stack('styles')
</head>
<body>

<div class="admin-wrapper">

    {{-- ══ SIDEBAR ══ --}}
    <aside class="admin-sidebar">

        {{-- Brand --}}
        <div class="sidebar-brand">
            <img src="{{ asset('img/logobalai.png') }}"
                 alt="Logo Balai Bahasa"
                 class="brand-logo"
                 onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg'">
            <div class="brand-text">
                <h5>Sembari</h5>
                <small>Perpustakaan Digital</small>
            </div>
        </div>

        {{-- Profile --}}
        <div class="admin-profile-card">
            <div class="profile-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="profile-info">
                <h6 class="profile-name">{{ session('admin_username', 'Admin') }}</h6>
                <span class="profile-role">
                    {{ strtolower(session('admin_role')) === 'super_admin' ? 'Super Admin' : 'Admin' }}
                </span>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav">
            <ul class="nav-list">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.books.index') }}"
                       class="nav-link {{ request()->routeIs('admin.books*') ? 'active' : '' }}">
                        <i class="bi bi-book"></i>
                        <span>Buku</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}"
                       class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i>
                        <span>Kategori</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.reading-levels.index') }}"
                       class="nav-link {{ request()->routeIs('admin.reading-levels*') ? 'active' : '' }}">
                        <i class="bi bi-bar-chart-steps"></i>
                        <span>Jenjang Baca</span>
                    </a>
                </li>

                @if(strtolower(session('admin_role')) === 'super_admin')
                <li class="nav-item">
                    <a href="{{ route('admin.pengaturan') }}"
                       class="nav-link {{ request()->routeIs('admin.pengaturan*') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
                @endif

                <li class="nav-item-logout">
                    <a href="#" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Keluar</span>
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
    </aside>

    {{-- ══ MAIN CONTENT ══ --}}
    <main class="admin-content">

        {{-- Top Bar --}}
        <div class="top-bar">
            <button class="mobile-menu-toggle" onclick="toggleSidebar()" aria-label="Toggle menu">
                <i class="bi bi-list"></i>
            </button>
            <div class="top-bar-right">
                <span class="welcome-text">
                    Selamat datang, <strong>{{ session('admin_username', 'Admin') }}</strong>
                </span>
            </div>
        </div>

        {{-- Page Content --}}
        <div class="content-wrapper">
            @yield('content')
        </div>

        {{-- Footer --}}
        <footer class="admin-footer">
            &copy; {{ date('Y') }} Balai Bahasa Provinsi Riau. All rights reserved.
        </footer>

    </main>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSidebar() {
    document.querySelector('.admin-sidebar').classList.toggle('active');
}
document.addEventListener('click', function (e) {
    if (window.innerWidth <= 992) {
        const sidebar = document.querySelector('.admin-sidebar');
        const toggle  = document.querySelector('.mobile-menu-toggle');
        if (sidebar && toggle && !sidebar.contains(e.target) && !toggle.contains(e.target)) {
            sidebar.classList.remove('active');
        }
    }
});
</script>

@stack('scripts')

</body>
</html>
