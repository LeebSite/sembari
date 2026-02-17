@extends('admin.layout')

@section('title', 'Daftar Buku')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3>Daftar Buku</h3>
            <p class="mb-0">Kelola koleksi buku perpustakaan digital</p>
        </div>
        <div>
            <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Buku
            </a>
        </div>
    </div>
</div>

<!-- Success Message -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Books Table -->
<div class="card">
    <div class="card-body">
        @if($books->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="80">Cover</th>
                        <th>Judul Buku</th>
                        <th width="150">Lisensi</th>
                        <th width="150">Aksi</th>
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
                                     style="width: 60px; height: 80px; border-radius: 4px; border: 2px solid #e2e8f0;">
                                    <i class="bi bi-book text-muted" style="font-size: 24px;"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold text-primary">{{ $book->title }}</div>
                            <small class="text-muted">{{ Str::limit($book->description ?? '-', 80) }}</small>
                            @if($book->contributors)
                            <div class="mt-1">
                                <small class="text-muted">
                                    <i class="bi bi-people-fill me-1"></i>
                                    {{ str_replace("\n", ", ", Str::limit($book->contributors, 60)) }}
                                </small>
                            </div>
                            @endif
                        </td>
                        <td>
                            @if($book->license)
                                <span class="badge" 
                                      style="background: {{ $book->license == 'Buku Edisi Terbatas' ? '#f59e0b' : '#10b981' }}; color: white;">
                                    {{ $book->license }}
                                </span>
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
                                    <button type="submit" 
                                            class="btn btn-outline-danger" 
                                            title="Hapus">
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

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $books->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size: 64px; color: #cbd5e1;"></i>
            <h5 class="mt-3 text-muted">Belum Ada Buku</h5>
            <p class="text-muted mb-4">Mulai tambahkan buku ke perpustakaan digital Anda</p>
            <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Buku Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
