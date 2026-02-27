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

    {{-- Animate.css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        /* ── Custom Modal Notif ── */
        .modal-notif-header {
            border: none;
            padding-top: 2rem;
            padding-bottom: 0.5rem;
        }
        .icon-box {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin-bottom: 1rem;
        }
        .icon-box-success {
            background-color: #f0fdf4;
            color: #22c55e;
            border: 3px solid #bbf7d0;
        }
        .icon-box-danger {
            background-color: #fef2f2;
            color: #ef4444;
            border: 3px solid #fecaca;
        }
        .modal-notif-title {
            font-weight: 800;
            color: #1e293b;
        }
        .modal-notif-text {
            color: #64748b;
            font-size: 0.95rem;
            padding: 0 20px;
        }
        .btn-notif {
            padding: 10px 30px;
            font-weight: 700;
            border-radius: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
            transition: all 0.2s;
            margin-top: 1rem;
            margin-bottom: 1.5rem;
        }

        /* ── Loading Overlay ── */
        #loading-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(5px);
            z-index: 10000;
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s;
        }
        .spinner-loading {
            width: 60px;
            height: 60px;
            border: 5px solid rgba(255, 255, 255, 0.1);
            border-top: 5px solid #6366f1;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 1.5rem;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

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

{{-- ── LOADING OVERLAY ── --}}
<div id="loading-overlay">
    <div class="spinner-loading"></div>
    <h5 class="fw-bold mb-1">Sedang Memproses...</h5>
    <p class="text-white-50 small">Mohon tunggu sebentar, jangan tutup halaman ini.</p>
</div>

{{-- ── NOTIFICATION MODALS ── --}}

{{-- Modal Sukses --}}
@if(session('success'))
<div class="modal fade" id="modalSuccess" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-body text-center p-4">
                <div class="icon-box icon-box-success animate__animated animate__bounceIn">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <h4 class="modal-notif-title mt-3">Berhasil!</h4>
                <p class="modal-notif-text mt-2">{{ session('success') }}</p>
                <button type="button" class="btn btn-success btn-notif shadow-sm w-100" data-bs-dismiss="modal">OKE, MENGERTI</button>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Modal Error --}}
@if(session('error') || $errors->any())
<div class="modal fade" id="modalError" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-body text-center p-4">
                <div class="icon-box icon-box-danger animate__animated animate__shakeX">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <h4 class="modal-notif-title mt-3">Ups! Ada Kesalahan</h4>
                <div class="modal-notif-text mt-2">
                    @if(session('error'))
                        {{ session('error') }}
                    @endif
                    @if($errors->any())
                        <ul class="list-unstyled mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="bi bi-dot"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <button type="button" class="btn btn-danger btn-notif shadow-sm px-5" data-bs-dismiss="modal">PERBAIKI SEKARANG</button>
            </div>
        </div>
    </div>
</div>
@endif

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

<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        const modalSuccessEle = document.getElementById('modalSuccess');
        if (modalSuccessEle) {
            const modalSuccess = new bootstrap.Modal(modalSuccessEle);
            modalSuccess.show();
        }
    @endif

    @if(session('error') || $errors->any())
        const modalErrorEle = document.getElementById('modalError');
        if (modalErrorEle) {
            const modalError = new bootstrap.Modal(modalErrorEle);
            modalError.show();
        }
    @endif

    // Loading Handler for Forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            // Hanya tampilkan loading jika form valid (untuk native validation)
            if (this.checkValidity()) {
                document.getElementById('loading-overlay').style.display = 'flex';
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
                }
            }
        });
    });
});
</script>

@stack('scripts')

</body>
</html>
