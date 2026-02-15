@extends('admin.layout')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1" style="color:#1e3a8a;">Dashboard</h3>
        <p class="mb-0 text-muted">
            Selamat datang di Panel Admin Perpustakaan Digital Sembari
        </p>
    </div>

    <div class="header-logo">
        <img src="https://ppidbbpriau.kemendikdasmen.go.id/bbpr/img/logobbpr4.png"
             alt="Logo Balai Bahasa Provinsi Riau"
             class="img-fluid header-logo">
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Total Buku</p>
                        <h3 class="mb-0 fw-bold" style="color: #2563eb;">
                            {{ DB::table('books')->count() }}
                        </h3>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="bi bi-book-fill text-primary" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Kategori</p>
                        <h3 class="mb-0 fw-bold" style="color: #059669;">
                            {{ DB::table('categories')->count() }}
                        </h3>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                        <i class="bi bi-tags-fill text-success" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Penulis</p>
                        <h3 class="mb-0 fw-bold" style="color: #7c3aed;">
                            {{ DB::table('authors')->count() }}
                        </h3>
                    </div>
                    <div class="rounded-circle bg-purple bg-opacity-10 p-3">
                        <i class="bi bi-person-fill text-purple" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Total Baca</p>
                        <h3 class="mb-0 fw-bold" style="color: #ea580c;">
                            {{ DB::table('book_stats')->sum('reads_count') }}
                        </h3>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="bi bi-eye-fill text-warning" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Books -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Buku Terbaru</h5>
                    <a href="{{ route('admin.books.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
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
                        <div class="list-group-item px-0">
                            <div class="d-flex align-items-center">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                         alt="{{ $book->title }}" 
                                         class="rounded me-3" 
                                         style="width: 50px; height: 70px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 70px;">
                                        <i class="bi bi-book text-muted"></i>
                                    </div>
                                @endif
                                
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $book->title }}</h6>
                                    <small class="text-muted">
                                        {{ $book->created_at ? \Carbon\Carbon::parse($book->created_at)->diffForHumans() : '-' }}
                                        @if($book->reading_level)
                                            · <span class="badge bg-info text-dark">{{ $book->reading_level }}</span>
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
                    <div class="text-center py-4">
                        <i class="bi bi-inbox" style="font-size: 48px; color: #ccc;"></i>
                        <p class="text-muted mt-2">Belum ada buku yang ditambahkan.</p>
                        <a href="{{ route('admin.books.create') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Buku Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0">Aktivitas Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item mb-3">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-2">
                                    <i class="bi bi-book text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1 small">Buku baru ditambahkan</p>
                                <small class="text-muted">2 jam yang lalu</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item mb-3">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-success bg-opacity-10 p-2">
                                    <i class="bi bi-tags text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1 small">Kategori diperbarui</p>
                                <small class="text-muted">5 jam yang lalu</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.text-purple {
    color: #7c3aed !important;
}
.bg-purple {
    background-color: #7c3aed !important;
}
</style>
@endsection
