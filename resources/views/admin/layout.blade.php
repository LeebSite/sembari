<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Laman BBPR</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/adminpengaturan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admintokoh.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminprofil.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

@php
    $profilOpen = request()->routeIs('admin.profil.*');
    $akuntabilitasOpen = request()->routeIs('admin.akuntabilitas.*');
    $ziwbkOpen = request()->routeIs('admin.ziwbk.*');
@endphp

<div class="d-flex min-vh-100">
    <aside class="sidebar d-flex flex-column">

        <!-- PROFIL ADMIN -->
        <div class="admin-profile px-2 py-1">
            <div class="d-flex align-items-center">
                <img src="https://ppidbbpriau.kemendikdasmen.go.id/bbpr/img/AkunLogo.png" alt="Foto Profil Admin" class="avatar-circle me-1">
                <div class="admin-info">
                    @php
                        $adminLogin = (object) [
                            'username' => session('admin_username'),
                            'role' => session('admin_role'),
                        ];
                    @endphp

                    <div class="fw-bold fs-6" style="color:#1e3a8a;">
                        {{ $adminLogin->username ?? '-' }}
                    </div>
                    <div class="small" style="color:#1e3a8a; font-weight:600;">
                        {{ $adminLogin->role === 'super_admin' ? 'Super Admin' : ucfirst($adminLogin->role) }}
                    </div>
                </div>
            </div>
        </div>

        <hr class="sidebar-hr">

        <ul class="nav flex-column menu-list flex-grow-1">

            <!-- DASHBOARD -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>

            <!-- BUKU -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.books*') ? 'active' : '' }}"
                   href="{{ route('admin.books.index') }}">
                    <i class="bi bi-book me-2"></i>Buku
                </a>
            </li>
                        
            <!-- PUBLIKASI -->
            <!-- PUBLIKASI -->
            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.publikasi*') ? 'active' : '' }}"
                   href="{{ route('admin.publikasi') }}">
                    <i class="bi bi-journal-text me-2"></i>Publikasi
                </a>
            </li> --}}
            
            <!-- TOKOH -->
            <!-- TOKOH -->
            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.tokoh*') ? 'active' : '' }}"
                    href="{{ route('admin.tokoh') }}">
                    <i class="bi bi-person-badge me-2"></i>Tokoh
                </a>
             </li> --}}

            <!-- GALERI -->
            <!-- GALERI -->
            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.galeri*') ? 'active' : '' }}"
                   href="{{ route('admin.galeri') }}">
                    <i class="bi bi-images me-2"></i>Galeri
                </a>
            </li> --}}

            <!-- PROFIL LAMAN -->
            <!-- PROFIL LAMAN -->
            {{-- <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center"
                   href="#"
                   onclick="toggleSubMenu(this)">
                    <div>
                        <i class="bi bi-building-gear me-2"></i>Profil Laman
                    </div>
                    <i class="bi submenu-arrow {{ $profilOpen ? 'bi-caret-down-fill' : 'bi-caret-right-fill' }}"></i>
                </a>
                <ul id="SubMenu"
                    class="nav flex-column ms-3"
                    @if($profilOpen) style="display:block" @else style="display:none" @endif>
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.profil.visimisi*') ? 'active' : '' }}"
                           href="{{ route('admin.profil.visimisi') }}">
                            <i class="bi bi-bullseye me-2"></i>Visi & Misi
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.profil.tugasfungsi*') ? 'active' : '' }}"
                           href="{{ route('admin.profil.tugasfungsi') }}">
                            <i class="bi bi-list-task me-2"></i>Tugas & Fungsi
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.profil.pegawai') ? 'active' : '' }}"
                        href="{{ route('admin.profil.pegawai') }}">
                            <i class="bi bi-people me-2"></i>Pegawai
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.profil.strukturorganisasi') ? 'active' : '' }}"
                        href="{{ route('admin.profil.strukturorganisasi') }}">
                            <i class="bi bi-diagram-3 me-2"></i>Struktur Organisasi
                        </a>
                    </li>
                </ul>
            </li> --}}

            <!-- AKUNTABILITAS -->
            <!-- AKUNTABILITAS -->
            {{-- <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" href="#" onclick="toggleSubMenu(this)">
                        <div>
                            <i class="bi bi-clipboard-check me-2"></i>Akuntabilitas
                        </div>
                        <i class="bi submenu-arrow {{ $akuntabilitasOpen ? 'bi-caret-down-fill' : 'bi-caret-right-fill' }}"></i>
                    </a>
                    <ul class="nav flex-column ms-3 submenu-list" 
                        style="display: {{ $akuntabilitasOpen ? 'block' : 'none' }}">
                        
                        <li>
                            <a class="nav-link {{ request()->is('admin/akuntabilitas/renstra*') ? 'active' : '' }}"
                               href="{{ route('admin.akuntabilitas.index', 'renstra') }}">
                                <i class="fas fa-arrow-right me-2"></i>Renstra
                            </a>
                        </li>
                
                        <li>
                            <a class="nav-link {{ request()->is('admin/akuntabilitas/dipa*') ? 'active' : '' }}"
                               href="{{ route('admin.akuntabilitas.index', 'dipa') }}">
                                <i class="fas fa-dollar-sign me-2"></i>DIPA
                            </a>
                        </li>
                
                        <li>
                            <a class="nav-link {{ request()->is('admin/akuntabilitas/perjanjian-kinerja*') ? 'active' : '' }}"
                               href="{{ route('admin.akuntabilitas.index', 'perjanjian-kinerja') }}">
                                <i class="fas fa-file-signature me-2"></i>Perjanjian Kinerja
                            </a>
                        </li>
                
                        <li>
                            <a class="nav-link {{ request()->is('admin/akuntabilitas/rencana-aksi*') ? 'active' : '' }}"
                               href="{{ route('admin.akuntabilitas.index', 'rencana-aksi') }}">
                                <i class="fas fa-list-check me-2"></i>Rencana Aksi
                            </a>
                        </li>
                
                        <li>
                            <a class="nav-link {{ request()->is('admin/akuntabilitas/lakin*') ? 'active' : '' }}"
                               href="{{ route('admin.akuntabilitas.index', 'lakin') }}">
                                <i class="fas fa-list-check me-2"></i>Lakin
                            </a>
                        </li>
                
                        <li>
                            <a class="nav-link {{ request()->is('admin/akuntabilitas/sakai*') ? 'active' : '' }}"
                               href="{{ route('admin.akuntabilitas.index', 'sakai') }}">
                                <i class="fas fa-list-check me-2"></i>SAKAI
                            </a>
                        </li>
                    </ul>
                </li> --}}
                 
                 <!-- ZI - WBK -->
                    {{-- <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center"
                           href="#"
                           onclick="toggleSubMenu(this)">
                            <div>
                                <i class="bi bi-shield-check me-2"></i>ZI - WBK
                            </div>
                            <i class="bi submenu-arrow {{ $ziwbkOpen ? 'bi-caret-down-fill' : 'bi-caret-right-fill' }}"></i>
                        </a>
    
                    <ul class="nav flex-column ms-3 submenu-list"
                        style="display: {{ $ziwbkOpen ? 'block' : 'none' }}">
                
                        <li>
                            <a class="nav-link {{ request()->routeIs('admin.ziwbk.index') ? 'active' : '' }}"
                               href="{{ route('admin.ziwbk.index') }}">
                                <i class="bi bi-folder2-open me-2"></i>Daftar Dokumen
                            </a>
                        </li>
    
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.ziwbk.create') ? 'active' : '' }}"
                           href="{{ route('admin.ziwbk.create') }}">
                            <i class="bi bi-upload me-2"></i>Upload Dokumen
                        </a>
                    </li>
            
                </ul>
            </li> --}}
        
            <!-- SEMBARI -->
            <!-- SEMBARI -->
            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.sembari*') ? 'active' : '' }}"
                   href="{{ route('admin.sembari.index') }}">
                    <i class="bi bi-book me-2"></i>Sembari
                </a>
            </li> --}}
             
            <!-- HASIL SURVEI -->
            <!-- HASIL SURVEI -->
            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.hasilsurvei.*') ? 'active' : '' }}"
                   href="{{ route('admin.hasilsurvei.index') }}">
                    <i class="bi bi-bar-chart me-2"></i>Hasil Survei
                </a>
            </li> --}}


            <!-- PENGATURAN -->
            @if(strtolower(session('admin_role')) === 'super_admin')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.pengaturan') ? 'active' : '' }}"
                href="{{ route('admin.pengaturan') }}">
                    <i class="bi bi-gear me-2"></i>Pengaturan
                </a>
            </li>
            @endif

            <li class="nav-item">
                <a href="#" class="nav-link logout-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Keluar
                </a>

                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>

        </ul>
    </aside>

    <main class="flex-fill p-4 bg-content">
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSubMenu(el) {
    const arrow = el.querySelector('.submenu-arrow');
    const submenu = el.nextElementSibling;

    if (!submenu || !arrow) return;

    const isOpen = submenu.style.display === "block";
    submenu.style.display = isOpen ? "none" : "block";

    arrow.classList.toggle("bi-caret-down-fill", !isOpen);
    arrow.classList.toggle("bi-caret-right-fill", isOpen);
}
</script>

</body>
</html>
