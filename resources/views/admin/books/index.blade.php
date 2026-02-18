@extends('admin.layout')

@section('title', 'Daftar Buku')

@section('content')

<style>
    .page-hero {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 60%, #7c3aed 100%);
        border-radius: 16px;
        padding: 28px 32px;
        color: #fff;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .page-hero::after {
        content: '';
        position: absolute;
        right: -30px; top: -30px;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
    }
    .page-hero::before {
        content: '';
        position: absolute;
        right: 60px; bottom: -50px;
        width: 150px; height: 150px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }
    .page-hero h2 { font-size: 22px; font-weight: 700; margin: 0 0 4px; }
    .page-hero p  { font-size: 13px; margin: 0; opacity: 0.8; }
    .btn-add {
        background: rgba(255,255,255,0.2);
        color: #fff;
        border: 1.5px solid rgba(255,255,255,0.35);
        border-radius: 10px;
        padding: 9px 20px;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 7px;
        backdrop-filter: blur(4px);
        transition: all 0.2s;
        white-space: nowrap;
        position: relative;
        z-index: 1;
    }
    .btn-add:hover {
        background: rgba(255,255,255,0.3);
        color: #fff;
        transform: translateY(-1px);
    }

    /* Table card */
    .books-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e8edf2;
        overflow: hidden;
    }
    .books-card table thead tr {
        background: #f8fafc;
    }
    .books-card table thead th {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border-bottom: 1px solid #e8edf2;
        border-top: none;
    }
    .books-card table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
    }
    .books-card table tbody tr:last-child td { border-bottom: none; }
    .books-card table tbody tr:hover { background: #fafbff; }

    /* Cover thumbnail */
    .book-cover {
        width: 52px;
        height: 70px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .book-cover-placeholder {
        width: 52px;
        height: 70px;
        border-radius: 6px;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 20px;
    }

    /* Book title */
    .book-title {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 3px;
        line-height: 1.3;
    }
    .book-desc {
        font-size: 12px;
        color: #94a3b8;
        line-height: 1.4;
    }
    .book-contributors {
        font-size: 12px;
        color: #64748b;
        margin-top: 4px;
    }

    /* Badge lisensi */
    .badge-terbatas {
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fed7aa;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
    }
    .badge-umum {
        background: #f0fdf4;
        color: #15803d;
        border: 1px solid #bbf7d0;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
    }
    .badge-none {
        background: #f8fafc;
        color: #94a3b8;
        border: 1px solid #e2e8f0;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 20px;
    }

    /* Action buttons */
    .action-btns {
        display: flex;
        gap: 6px;
        align-items: center;
    }
    .btn-action {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.18s;
        text-decoration: none;
    }
    .btn-action:hover { transform: translateY(-1px); }
    .btn-view  { background: #eff6ff; color: #3b82f6; }
    .btn-view:hover  { background: #3b82f6; color: #fff; }
    .btn-edit  { background: #f0fdf4; color: #16a34a; }
    .btn-edit:hover  { background: #16a34a; color: #fff; }
    .btn-delete { background: #fef2f2; color: #ef4444; }
    .btn-delete:hover { background: #ef4444; color: #fff; }

    /* Empty state */
    .empty-state {
        padding: 60px 20px;
        text-align: center;
    }
    .empty-state .empty-icon {
        width: 80px; height: 80px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 32px;
        color: #94a3b8;
    }
    .empty-state h5 { font-size: 16px; font-weight: 600; color: #374151; margin-bottom: 6px; }
    .empty-state p  { font-size: 13px; color: #94a3b8; margin-bottom: 20px; }

    /* Alert */
    .alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #15803d;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 13.5px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .alert-success .btn-close { margin-left: auto; }
</style>

<!-- Page Hero -->
<div class="page-hero">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="bi bi-book-half me-2"></i>Daftar Buku</h2>
            <p>Kelola koleksi buku perpustakaan digital Sembari</p>
        </div>
        <a href="{{ route('admin.books.create') }}" class="btn-add">
            <i class="bi bi-plus-circle-fill"></i> Tambah Buku
        </a>
    </div>
</div>

<!-- Alert -->
@if(session('success'))
<div class="alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill"></i>
    {{ session('success') }}
    <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" style="font-size:11px;"></button>
</div>
@endif

<!-- Books Table -->
<div class="books-card">
    @if($books->count() > 0)
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th width="70">Cover</th>
                    <th>Judul Buku</th>
                    <th width="160">Lisensi</th>
                    <th width="130" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                <tr>
                    <td>
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                 alt="{{ $book->title }}"
                                 class="book-cover">
                        @else
                            <div class="book-cover-placeholder">
                                <i class="bi bi-book"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="book-title">{{ $book->title }}</div>
                        @if($book->description)
                            <div class="book-desc">{{ Str::limit($book->description, 90) }}</div>
                        @endif
                        @if($book->contributors)
                            <div class="book-contributors">
                                <i class="bi bi-people me-1" style="color:#6366f1;"></i>
                                {{ Str::limit(str_replace("\n", " · ", $book->contributors), 70) }}
                            </div>
                        @endif
                    </td>
                    <td>
                        @if($book->license == 'Buku Edisi Terbatas')
                            <span class="badge-terbatas">
                                <i class="bi bi-lock-fill me-1"></i>Edisi Terbatas
                            </span>
                        @elseif($book->license == 'Buku Edisi Umum')
                            <span class="badge-umum">
                                <i class="bi bi-globe me-1"></i>Edisi Umum
                            </span>
                        @else
                            <span class="badge-none">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-btns justify-content-center">
                            <a href="{{ route('admin.books.show', $book->id) }}"
                               class="btn-action btn-view"
                               title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.books.edit', $book->id) }}"
                               class="btn-action btn-edit"
                               title="Edit Buku">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.books.destroy', $book->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin hapus buku \'{{ addslashes($book->title) }}\'?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus Buku">
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
    @if($books->hasPages())
    <div class="d-flex justify-content-center py-3 border-top">
        {{ $books->links() }}
    </div>
    @endif

    @else
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-icon"><i class="bi bi-inbox"></i></div>
        <h5>Belum Ada Buku</h5>
        <p>Mulai tambahkan buku ke perpustakaan digital Sembari</p>
        <a href="{{ route('admin.books.create') }}" class="btn-add d-inline-flex" style="background:#6366f1; border-color:#6366f1;">
            <i class="bi bi-plus-circle-fill"></i> Tambah Buku Pertama
        </a>
    </div>
    @endif
</div>

@endsection
