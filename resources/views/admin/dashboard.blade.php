@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3>Dashboard</h3>
            <p class="mb-0">Selamat datang di Panel Admin Perpustakaan Digital Sembari</p>
        </div>
        <div class="header-logo">
            <img src="{{ asset('img/logobalai.png') }}" alt="Logo Balai Bahasa" class="brand-logo" class="img-fluid">
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    @php
        $totalBooks = DB::table('books')->count();
        $totalCategories = DB::table('categories')->count();
        $totalAuthors = DB::table('authors')->count();
        $totalReads = DB::table('book_stats')->sum('reads_count');
    @endphp

    <div class="col-md-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Total Buku</p>
                        <h2 class="mb-0 fw-bold" style="color: #3b82f6;">{{ $totalBooks }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 56px; height: 56px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                        <i class="bi bi-book-fill text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Kategori</p>
                        <h2 class="mb-0 fw-bold" style="color: #10b981;">{{ $totalCategories }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 56px; height: 56px; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="bi bi-tags-fill text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Penulis</p>
                        <h2 class="mb-0 fw-bold" style="color: #8b5cf6;">{{ $totalAuthors }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 56px; height: 56px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                        <i class="bi bi-people-fill text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Total Pembaca</p>
                        <h2 class="mb-0 fw-bold" style="color: #f59e0b;">{{ number_format($totalReads) }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 56px; height: 56px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="bi bi-eye-fill text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row g-3">
    <!-- Recent Books -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Buku Terbaru</h5>
                    <a href="{{ route('admin.books.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @php
                    $recentBooks = DB::table('books')
                        ->leftJoin('reading_levels', 'books.reading_level_id', '=', 'reading_levels.id')
                        ->select('books.*', 'reading_levels.label as reading_level')
                        ->orderBy('books.created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp

                @if($recentBooks->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentBooks as $book)
                        <div class="list-group-item border-0 px-0 py-3">
                            <div class="d-flex align-items-center gap-3">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                         alt="{{ $book->title }}" 
                                         class="rounded" 
                                         style="width: 50px; height: 70px; object-fit: cover; border: 2px solid #e2e8f0;">
                                @else
                                    <div class="rounded d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 70px; background: #f1f5f9; border: 2px solid #e2e8f0;">
                                        <i class="bi bi-book text-muted" style="font-size: 20px;"></i>
                                    </div>
                                @endif
                                
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">{{ $book->title }}</h6>
                                    <small class="text-muted">
                                        <i class="bi bi-clock"></i>
                                        {{ $book->created_at ? \Carbon\Carbon::parse($book->created_at)->diffForHumans() : 'Baru ditambahkan' }}
                                        @if($book->reading_level)
                                            <span class="badge bg-info ms-2">{{ $book->reading_level }}</span>
                                        @endif
                                    </small>
                                </div>
                                
                                <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 64px; color: #cbd5e1;"></i>
                        <p class="text-muted mt-3 mb-3">Belum ada buku yang ditambahkan</p>
                        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Buku Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Buku Baru
                    </a>
                    <a href="{{ route('admin.books.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-list-ul"></i> Kelola Buku
                    </a>
                    @if(strtolower(session('admin_role')) === 'super_admin')
                    <a href="{{ route('admin.pengaturan') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-gear"></i> Pengaturan
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Library Stats -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Statistik Perpustakaan</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 40px; height: 40px; background: rgba(59, 130, 246, 0.1);">
                            <i class="bi bi-eye-fill" style="color: #3b82f6;"></i>
                        </div>
                        <span>Total Views</span>
                    </div>
                    <strong>{{ number_format(DB::table('book_stats')->sum('views_count')) }}</strong>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 40px; height: 40px; background: rgba(239, 68, 68, 0.1);">
                            <i class="bi bi-heart-fill" style="color: #ef4444;"></i>
                        </div>
                        <span>Total Likes</span>
                    </div>
                    <strong>{{ number_format(DB::table('book_stats')->sum('likes_count')) }}</strong>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1);">
                            <i class="bi bi-book-fill" style="color: #10b981;"></i>
                        </div>
                        <span>Total Reads</span>
                    </div>
                    <strong>{{ number_format($totalReads) }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
