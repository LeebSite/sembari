<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Admin CSS</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <style>
        /* Debug CSS - remove after testing */
        .debug-info {
            position: fixed;
            bottom: 10px;
            right: 10px;
            background: #000;
            color: #0f0;
            padding: 10px;
            font-family: monospace;
            font-size: 12px;
            z-index: 9999;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="debug-info">
    CSS Loaded: admin.css<br>
    Bootstrap: v5.3.3<br>
    Icons: Bootstrap Icons
</div>

<div class="admin-wrapper">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('img/logo/logobalai.png') }}" alt="Logo" class="brand-logo">
            <div class="brand-text">
                <h5 class="mb-0">Sembari</h5>
                <small>Perpustakaan Digital</small>
            </div>
        </div>

        <div class="admin-profile-card">
            <div class="profile-avatar">
                <i class="bi bi-person-circle"></i>
            </div>
            <div class="profile-info">
                <h6 class="profile-name">Admin Test</h6>
                <span class="profile-role">Super Admin</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-book"></i>
                        <span>Buku</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-gear"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
                <li class="nav-item-logout">
                    <a href="#" class="nav-link">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Keluar</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="admin-content">
        <div class="top-bar">
            <button class="mobile-menu-toggle">
                <i class="bi bi-list"></i>
            </button>
            <div class="top-bar-right">
                <span class="welcome-text">Selamat datang, <strong>Admin</strong></span>
            </div>
        </div>

        <div class="content-wrapper">
            <div class="page-header">
                <h3>Test Page</h3>
                <p>Jika Anda melihat sidebar gelap di kiri dan header biru ini, maka CSS berhasil dimuat!</p>
            </div>

            <div class="row g-3">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Card Test</h5>
                            <p class="text-muted">This is a test card</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Table Test</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Column 1</th>
                                        <th>Column 2</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Row 1</td>
                                        <td>Data 1</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="admin-footer">
            <p class="mb-0">&copy; 2026 Test Footer</p>
        </footer>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
