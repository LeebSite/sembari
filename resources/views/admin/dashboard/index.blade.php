@extends('admin.layout')

@section('title', 'Dashboard')

@push('styles')
<style>
/* Dashboard page styles */
.dash-hero {
    background: linear-gradient(135deg, #63a3f1ff 0%, #4f46e5 50%, #eba818ff 100%);
    border-radius: 20px;
    padding: 32px 36px;
    color: #fff;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
}
.dash-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 260px; height: 260px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%;
    pointer-events: none;
}
.dash-hero::after {
    content: '';
    position: absolute;
    bottom: -80px; right: 80px;
    width: 180px; height: 180px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
    pointer-events: none;
}
.dash-hero .hero-icon {
    font-size: 80px;
    opacity: 0.1;
    position: absolute;
    right: 32px; top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
}
.dash-hero h2 {
    font-size: 24px; font-weight: 800;
    margin: 0 0 6px;
    position: relative; z-index: 1;
}
.dash-hero p {
    font-size: 14px; margin: 0;
    opacity: 0.8; position: relative; z-index: 1;
}
.dash-hero .hero-date {
    font-size: 12px; opacity: 0.6;
    margin-top: 6px; position: relative; z-index: 1;
}

/* Stat Cards */
.stat-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e8edf2;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all 0.25s;
    cursor: default;
    height: 100%;
}
.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.09);
}
.stat-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: #fff; flex-shrink: 0;
}
.stat-info p {
    font-size: 11px; font-weight: 700;
    color: #94a3b8; margin: 0 0 4px;
    text-transform: uppercase; letter-spacing: 0.6px;
}
.stat-info h3 {
    font-size: 26px; font-weight: 800;
    margin: 0; line-height: 1;
}
.stat-info small {
    font-size: 11px; color: #94a3b8;
    margin-top: 4px; display: block;
}

/* Section Cards */
.dash-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e8edf2;
    overflow: hidden;
}
.dash-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
}
.dash-card-header h5 {
    font-size: 14px; font-weight: 700;
    color: #0f172a; margin: 0;
    display: flex; align-items: center; gap: 9px;
}
.dash-card-header h5 .hdr-icon {
    width: 28px; height: 28px;
    border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; color: #fff; flex-shrink: 0;
}
.btn-see-all {
    font-size: 12px; font-weight: 600;
    color: #6366f1; text-decoration: none;
    display: flex; align-items: center; gap: 4px;
    padding: 5px 12px;
    border-radius: 8px;
    background: #f5f3ff;
    transition: all 0.2s;
    white-space: nowrap;
}
.btn-see-all:hover { background: #6366f1; color: #fff; }

/* Book list */
.book-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 13px 20px;
    border-bottom: 1px solid #f8fafc;
    transition: background 0.15s;
}
.book-item:last-child { border-bottom: none; }
.book-item:hover { background: #fafbff; }
.book-thumb {
    width: 42px; height: 58px;
    border-radius: 7px;
    object-fit: cover;
    border: 1px solid #e8edf2;
    flex-shrink: 0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}
.book-thumb-ph {
    width: 42px; height: 58px;
    border-radius: 7px;
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    display: flex; align-items: center; justify-content: center;
    color: #94a3b8; font-size: 17px; flex-shrink: 0;
}
.book-meta { flex: 1; min-width: 0; }
.book-meta h6 {
    font-size: 13px; font-weight: 600;
    color: #0f172a; margin: 0 0 3px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.book-meta span {
    font-size: 11.5px; color: #94a3b8;
    display: flex; align-items: center; gap: 5px;
}
.book-level {
    font-size: 10.5px; font-weight: 600;
    padding: 2px 8px; border-radius: 20px;
    background: #f5f3ff; color: #7c3aed;
    border: 1px solid #e9d5ff;
}
.btn-edit-sm {
    width: 30px; height: 30px;
    border-radius: 7px;
    background: #f1f5f9; color: #64748b;
    border: none; display: flex;
    align-items: center; justify-content: center;
    font-size: 13px; text-decoration: none;
    transition: all 0.2s; flex-shrink: 0;
}
.btn-edit-sm:hover { background: #6366f1; color: #fff; }

/* Quick Actions */
.qa-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 16px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 13px; font-weight: 600;
    transition: all 0.2s;
    border: 1.5px solid transparent;
    margin-bottom: 8px;
}
.qa-btn:last-child { margin-bottom: 0; }
.qa-btn .qa-icon {
    width: 34px; height: 34px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; flex-shrink: 0;
}
.qa-btn .qa-text small {
    font-size: 11px; opacity: 0.6; font-weight: 400; display: block;
}

.qa-purple { background: #f5f3ff; color: #4f46e5; border-color: #e0e7ff; }
.qa-purple .qa-icon { background: #e0e7ff; color: #6366f1; }
.qa-purple:hover { background: #6366f1; color: #fff; border-color: #6366f1; }
.qa-purple:hover .qa-icon { background: rgba(255,255,255,0.2); color: #fff; }

.qa-green { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
.qa-green .qa-icon { background: #dcfce7; color: #16a34a; }
.qa-green:hover { background: #16a34a; color: #fff; border-color: #16a34a; }
.qa-green:hover .qa-icon { background: rgba(255,255,255,0.2); color: #fff; }

.qa-slate { background: #f8fafc; color: #475569; border-color: #e2e8f0; }
.qa-slate .qa-icon { background: #e2e8f0; color: #475569; }
.qa-slate:hover { background: #475569; color: #fff; border-color: #475569; }
.qa-slate:hover .qa-icon { background: rgba(255,255,255,0.2); color: #fff; }

/* Stat rows */
.lib-stat-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
    border-bottom: 1px solid #f1f5f9;
}
.lib-stat-row:last-child { border-bottom: none; }
.lib-stat-row .stat-label {
    display: flex; align-items: center; gap: 10px;
    font-size: 13px; color: #374151; font-weight: 500;
}
.lib-stat-row .dot {
    width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
}
.lib-stat-row .stat-val {
    font-size: 14px; font-weight: 700; color: #0f172a;
}

/* Empty state */
.empty-dash {
    padding: 40px 20px; text-align: center;
}
.empty-dash i { font-size: 38px; color: #cbd5e1; display: block; margin-bottom: 10px; }
.empty-dash p { font-size: 13px; color: #94a3b8; margin: 0 0 16px; }
</style>
@endpush

@section('content')

@php
    $totalBooks      = DB::table('books')->count();
    $totalCategories = DB::table('categories')->count();
    $totalBookTypes  = DB::table('book_types')->count();
    $totalViews      = DB::table('book_stats')->sum('views_count');
    $totalLikes      = DB::table('book_stats')->sum('likes_count');
    $totalReads      = DB::table('book_stats')->sum('reads_count');

    $recentBooks = DB::table('books')
        ->leftJoin('reading_levels', 'books.reading_level_id', '=', 'reading_levels.id')
        ->select('books.*', 'reading_levels.name as reading_level')
        ->orderBy('books.created_at', 'desc')
        ->limit(5)
        ->get();

    $now      = \Carbon\Carbon::now('Asia/Jakarta');
    $hour     = $now->hour;
    $greeting = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
@endphp

{{-- GREETING HERO --}}
<div class="dash-hero">
    <i class="bi bi-book-half hero-icon"></i>
    <h2>{{ $greeting }}, {{ session('admin_username', 'Admin') }}! 👋</h2>
    <p>Selamat datang di Panel Admin Perpustakaan Digital Sembari</p>
    <div class="hero-date">
        <i class="bi bi-calendar3 me-1"></i>
        {{ $now->translatedFormat('l, d F Y') }}
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#6366f1,#4f46e5);">
                <i class="bi bi-book-fill"></i>
            </div>
            <div class="stat-info">
                <p>Total Buku</p>
                <h3 style="color:#6366f1;">{{ $totalBooks }}</h3>
                <small>Koleksi digital</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#10b981,#059669);">
                <i class="bi bi-tags-fill"></i>
            </div>
            <div class="stat-info">
                <p>Kategori</p>
                <h3 style="color:#10b981;">{{ $totalCategories }}</h3>
                <small>Jenis konten</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                <i class="bi bi-eye-fill"></i>
            </div>
            <div class="stat-info">
                <p>Total Views</p>
                <h3 style="color:#f59e0b;">{{ number_format($totalViews) }}</h3>
                <small>Kunjungan buku</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#ef4444,#dc2626);">
                <i class="bi bi-heart-fill"></i>
            </div>
            <div class="stat-info">
                <p>Total Likes</p>
                <h3 style="color:#ef4444;">{{ number_format($totalLikes) }}</h3>
                <small>Disukai pembaca</small>
            </div>
        </div>
    </div>
</div>

{{-- MAIN ROW --}}
<div class="row g-3">

    {{-- Buku Terbaru --}}
    <div class="col-lg-8">
        <div class="dash-card">
            <div class="dash-card-header">
                <h5>
                    <span class="hdr-icon" style="background:linear-gradient(135deg,#6366f1,#4f46e5);">
                        <i class="bi bi-clock-history"></i>
                    </span>
                    Buku Terbaru
                </h5>
                <a href="{{ route('admin.books.index') }}" class="btn-see-all">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            @if($recentBooks->count() > 0)
                @foreach($recentBooks as $book)
                <div class="book-item">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                             alt="{{ $book->title }}" class="book-thumb">
                    @else
                        <div class="book-thumb-ph"><i class="bi bi-book"></i></div>
                    @endif
                    <div class="book-meta">
                        <h6>{{ $book->title }}</h6>
                        <span>
                            <i class="bi bi-clock"></i>
                            {{ $book->created_at ? \Carbon\Carbon::parse($book->created_at)->diffForHumans() : '—' }}
                            @if($book->reading_level)
                                <span class="book-level">{{ $book->reading_level }}</span>
                            @endif
                        </span>
                    </div>
                    <a href="{{ route('admin.books.edit', $book->id) }}" class="btn-edit-sm" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                </div>
                @endforeach
            @else
                <div class="empty-dash">
                    <i class="bi bi-inbox"></i>
                    <p>Belum ada buku yang ditambahkan</p>
                    <a href="{{ route('admin.books.create') }}" class="btn-primary-custom">
                        <i class="bi bi-plus-circle-fill"></i> Tambah Buku Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Sidebar Kanan --}}
    <div class="col-lg-4">

        {{-- Quick Actions --}}
        <div class="dash-card mb-3">
            <div class="dash-card-header">
                <h5>
                    <span class="hdr-icon" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                        <i class="bi bi-lightning-fill"></i>
                    </span>
                    Aksi Cepat
                </h5>
            </div>
            <div style="padding:14px;">
                <a href="{{ route('admin.books.create') }}" class="qa-btn qa-purple">
                    <div class="qa-icon"><i class="bi bi-plus-circle-fill"></i></div>
                    <div class="qa-text">
                        Tambah Buku Baru
                        <small>Upload buku ke perpustakaan</small>
                    </div>
                </a>
                <a href="{{ route('admin.books.index') }}" class="qa-btn qa-green">
                    <div class="qa-icon"><i class="bi bi-list-ul"></i></div>
                    <div class="qa-text">
                        Kelola Buku
                        <small>Lihat & edit semua buku</small>
                    </div>
                </a>
                @if(strtolower(session('admin_role')) === 'super_admin')
                <a href="{{ route('admin.pengaturan') }}" class="qa-btn qa-slate">
                    <div class="qa-icon"><i class="bi bi-gear-fill"></i></div>
                    <div class="qa-text">
                        Pengaturan
                        <small>Kelola akun admin</small>
                    </div>
                </a>
                @endif
            </div>
        </div>

        {{-- Statistik --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <h5>
                    <span class="hdr-icon" style="background:linear-gradient(135deg,#10b981,#059669);">
                        <i class="bi bi-bar-chart-fill"></i>
                    </span>
                    Statistik
                </h5>
            </div>
            <div class="lib-stat-row">
                <div class="stat-label"><span class="dot" style="background:#6366f1;"></span>Total Views</div>
                <div class="stat-val">{{ number_format($totalViews) }}</div>
            </div>
            <div class="lib-stat-row">
                <div class="stat-label"><span class="dot" style="background:#ef4444;"></span>Total Likes</div>
                <div class="stat-val">{{ number_format($totalLikes) }}</div>
            </div>
            <div class="lib-stat-row">
                <div class="stat-label"><span class="dot" style="background:#10b981;"></span>Total Reads</div>
                <div class="stat-val">{{ number_format($totalReads) }}</div>
            </div>
            <div class="lib-stat-row">
                <div class="stat-label"><span class="dot" style="background:#f59e0b;"></span>Jenis Buku</div>
                <div class="stat-val">{{ $totalBookTypes }}</div>
            </div>
            <div class="lib-stat-row">
                <div class="stat-label"><span class="dot" style="background:#0ea5e9;"></span>Kategori</div>
                <div class="stat-val">{{ $totalCategories }}</div>
            </div>
        </div>

    </div>
</div>

@endsection
