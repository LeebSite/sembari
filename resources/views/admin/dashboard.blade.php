@extends('admin.layout')

@section('content')
<!-- =================  SECTION LAYOUT ATAS ================= -->
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1" style="color:#ffffff;">Dashboard</h3>
        <p class="mb-0" style="color:#ffffff;">
            Selamat datang di Panel Admin Balai Bahasa Provinsi Riau
        </p>
    </div>

    <div class="header-logo">
        <img src="https://ppidbbpriau.kemendikdasmen.go.id/bbpr/img/logobbpr4.png"
             alt="Logo Balai Bahasa Provinsi Riau"
             class="img-fluid header-logo">
    </div>
</div>
<!-- =================  ISI MAIN CONTENT ================= -->
<!-- ================= STAT CARD ================= -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="icon bg-teal">📄</div>
            <div class="text-end">
                <small class="text-success">↗ +12%</small>
            </div>
            <p class="text-muted mb-1">Total Artikel</p>
            <h2>248</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="icon bg-green">📅</div>
            <div class="text-end">
                <small class="text-success">↗ +3</small>
            </div>
            <p class="text-muted mb-1">Kegiatan Bulan Ini</p>
            <h2>8</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="icon bg-blue">📘</div>
            <div class="text-end">
                <small class="text-success">↗ +5%</small>
            </div>
            <p class="text-muted mb-1">Publikasi</p>
            <h2>64</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="icon bg-orange">👥</div>
            <div class="text-end">
                <small class="text-success">↗ +8%</small>
            </div>
            <p class="text-muted mb-1">Pengguna Aktif</p>
            <h2>1,234</h2>
        </div>
    </div>
</div>

<!-- ================= CONTENT ================= -->
<div class="row g-4">
    <!-- ARTIKEL -->
    <div class="col-md-7">
        <div class="content-card">
            <h5 class="mb-3">Artikel Terbaru</h5>

            <div class="item">
                <strong>Pelestarian Bahasa Melayu Riau di Era Digital</strong>
                <div class="text-muted small">Dr. Ahmad Syahid</div>
                <div class="text-muted small">12 Des 2024 · 👁 324</div>
            </div>

            <div class="item">
                <strong>Workshop Penulisan Kreatif untuk Pelajar</strong>
                <div class="text-muted small">Sri Wahyuni, M.Pd</div>
                <div class="text-muted small">10 Des 2024 · 👁 256</div>
            </div>

            <div class="item">
                <strong>Seminar Sastra Nusantara 2024</strong>
                <div class="text-muted small">Prof. Budiman</div>
                <div class="text-muted small">8 Des 2024 · 👁 412</div>
            </div>
        </div>
    </div>

    <!-- KEGIATAN -->
    <div class="col-md-5">
        <div class="content-card">
            <h5 class="mb-3">Kegiatan Mendatang</h5>

            <div class="item">
                <strong>Bulan Bahasa dan Sastra 2025</strong>
                <div class="text-muted small">20 Jan 2025</div>
                <span class="badge bg-secondary">Akan Datang</span>
            </div>

            <div class="item">
                <strong>Lomba Menulis Cerpen Pelajar</strong>
                <div class="text-muted small">15 Jan 2025</div>
                <span class="badge bg-primary">Pendaftaran</span>
            </div>

            <div class="item">
                <strong>Pelatihan UKBI untuk Umum</strong>
                <div class="text-muted small">18 Des 2024</div>
                <span class="badge bg-success">Aktif</span>
            </div>
        </div>
    </div>
</div>
@endsection
