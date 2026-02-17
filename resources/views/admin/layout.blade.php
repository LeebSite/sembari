<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sembari - @yield('title', 'Dashboard')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Admin Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ time() }}">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

@php
    $profilOpen = request()->routeIs('admin.profil.*');
    $akuntabilitasOpen = request()->routeIs('admin.akuntabilitas.*');
    $ziwbkOpen = request()->routeIs('admin.ziwbk.*');
@endphp

<div class="admin-wrapper">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <!-- Logo & Brand -->
        <div class="sidebar-brand">
            <img src="{{ asset('img/logobalai.png') }}" alt="Logo Balai Bahasa" class="brand-logo">
            <div class="brand-text">
                <h5 class="mb-0">Sembari</h5>
                <small>Perpustakaan Digital</small>
            </div>
        </div>

        <!-- Admin Profile -->
        <div class="admin-profile-card">
            <div class="profile-avatar">
                <i class="bi bi-person-circle"></i>
            </div>
            <div class="profile-info">
                @php
                    $adminLogin = (object) [
                        'username' => session('admin_username', 'Admin'),
                        'role' => session('admin_role', 'admin'),
                    ];
                @endphp
                <h6 class="profile-name">{{ $adminLogin->username }}</h6>
                <span class="profile-role">{{ $adminLogin->role === 'super_admin' ? 'Super Admin' : 'Admin' }}</span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="sidebar-nav">
            <ul class="nav-list">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Buku -->
                <li class="nav-item">
                    <a href="{{ route('admin.books.index') }}" 
                       class="nav-link {{ request()->routeIs('admin.books*') ? 'active' : '' }}">
                        <i class="bi bi-book"></i>
                        <span>Buku</span>
                    </a>
                </li>

                <!-- Pengaturan (Super Admin Only) -->
                @if(strtolower(session('admin_role')) === 'super_admin')
                <li class="nav-item">
                    <a href="{{ route('admin.pengaturan') }}" 
                       class="nav-link {{ request()->routeIs('admin.pengaturan') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
                @endif

                <!-- Logout -->
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

    <!-- Main Content -->
    <main class="admin-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <button class="mobile-menu-toggle" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            
            <div class="top-bar-right">
                <span class="welcome-text">Selamat datang, <strong>{{ session('admin_username', 'Admin') }}</strong></span>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="admin-footer">
            <p class="mb-0">&copy; {{ date('Y') }} Balai Bahasa Provinsi Riau. All rights reserved.</p>
        </footer>
    </main>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Toggle sidebar for mobile
function toggleSidebar() {
    document.querySelector('.admin-sidebar').classList.toggle('active');
}

// Close sidebar when clicking outside (mobile)
document.addEventListener('click', function(event) {
    const sidebar = document.querySelector('.admin-sidebar');
    const toggle = document.querySelector('.mobile-menu-toggle');
    
    if (window.innerWidth <= 992) {
        if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
            sidebar.classList.remove('active');
        }
    }
});
</script>

@stack('scripts')

</body>
</html>
