@extends('admin.layout')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1" style="color:#1e3a8a;">Daftar Buku</h3>
        <p class="mb-0 text-muted">
            Kelola koleksi buku digital Sembari
        </p>
    </div>

    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Buku Baru
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        @if($books->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">Cover</th>
                            <th>Judul Buku</th>
                            <th>Tingkat Baca</th>
                            <th>Lisensi</th>
                            <th style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $book)
                        <tr>
                            <td>
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                         alt="{{ $book->title }}" 
                                         class="img-thumbnail" 
                                         style="width: 60px; height: 80px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 80px; border-radius: 4px;">
                                        <i class="bi bi-book text-muted" style="font-size: 24px;"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $book->title }}</div>
                                <small class="text-muted">{{ Str::limit($book->description, 60) }}</small>
                            </td>
                            <td>
                                @if($book->reading_level)
                                    <span class="badge bg-info">{{ $book->reading_level }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($book->license_name)
                                    <small class="text-muted">{{ $book->license_name }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.books.show', $book->id) }}" 
                                       class="btn btn-outline-info" 
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.books.edit', $book->id) }}" 
                                       class="btn btn-outline-primary" 
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.books.destroy', $book->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $books->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 64px; color: #ccc;"></i>
                <p class="text-muted mt-3">Belum ada buku yang ditambahkan.</p>
                <a href="{{ route('admin.books.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Buku Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
