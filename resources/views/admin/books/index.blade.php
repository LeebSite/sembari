@extends('admin.layout')

@section('title', 'Daftar Buku')

@push('styles')
<style>
    /* ══════════════════════════════════
       PAGE HERO — Buku (Ungu)
    ══════════════════════════════════ */
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
        pointer-events: none;
    }
    .page-hero::before {
        content: '';
        position: absolute;
        right: 60px; bottom: -50px;
        width: 150px; height: 150px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
        pointer-events: none;
    }
    .page-hero h2 { font-size: 22px; font-weight: 700; margin: 0 0 4px; position: relative; z-index: 1; }
    .page-hero p  { font-size: 13px; margin: 0; opacity: 0.8; position: relative; z-index: 1; }
    .btn-add {
        background: rgba(255,255,255,0.2);
        color: #fff;
        border: 1.5px solid rgba(255,255,255,0.35);
        border-radius: 10px;
        padding: 9px 20px;
        font-size: 13.5px; font-weight: 600;
        text-decoration: none;
        display: flex; align-items: center; gap: 7px;
        backdrop-filter: blur(4px);
        transition: all 0.2s;
        white-space: nowrap;
        position: relative; z-index: 1;
    }
    .btn-add:hover {
        background: rgba(255,255,255,0.3);
        color: #fff;
        transform: translateY(-1px);
    }

    /* ══════════════════════════════════
       FILTER BAR
    ══════════════════════════════════ */
    .filter-bar {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e8edf2;
        padding: 16px 20px;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    /* Search input */
    .search-group {
        position: relative;
        flex: 1;
        min-width: 200px;
    }
    .search-group i {
        position: absolute; left: 11px; top: 50%;
        transform: translateY(-50%);
        color: #94a3b8; font-size: 14px; pointer-events: none;
    }
    .search-group input {
        width: 100%;
        padding: 9px 12px 9px 34px;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        font-size: 13px; color: #1e293b;
        transition: all 0.2s;
    }
    .search-group input:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }

    /* Filter selects */
    .filter-select {
        padding: 9px 12px;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        font-size: 13px; color: #374151;
        background: #fff;
        cursor: pointer;
        min-width: 150px;
        transition: border-color 0.2s;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        padding-right: 30px;
    }
    .filter-select:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }

    /* Lisensi pill toggle */
    .lisensi-pills {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    .pill {
        padding: 7px 14px;
        border-radius: 20px;
        font-size: 12.5px; font-weight: 600;
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s;
        white-space: nowrap;
    }
    .pill:hover { border-color: #6366f1; color: #6366f1; background: #f5f3ff; }
    .pill.active-all  { background: #6366f1; color: #fff; border-color: #6366f1; }
    .pill.active-umum { background: #dcfce7; color: #15803d; border-color: #86efac; }
    .pill.active-tbts { background: #fff7ed; color: #c2410c; border-color: #fdba74; }

    /* Reset filter link */
    .btn-reset {
        font-size: 12px; color: #94a3b8;
        text-decoration: none;
        display: flex; align-items: center; gap: 4px;
        white-space: nowrap;
        transition: color 0.15s;
    }
    .btn-reset:hover { color: #ef4444; }

    /* ══════════════════════════════════
       TABLE CARD
    ══════════════════════════════════ */
    .books-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e8edf2;
        overflow: hidden;
    }
    .books-card-header {
        padding: 14px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e8edf2;
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; flex-wrap: wrap;
    }
    .books-card-header h6 {
        font-size: 13.5px; font-weight: 700; color: #1e293b; margin: 0;
        display: flex; align-items: center; gap: 8px;
    }
    .result-info {
        font-size: 12px; color: #94a3b8;
    }
    .result-info strong { color: #6366f1; }

    .books-card table thead tr { background: #f8fafc; }
    .books-card table thead th {
        font-size: 11px; font-weight: 700; color: #64748b;
        text-transform: uppercase; letter-spacing: 0.5px;
        padding: 13px 16px;
        border-bottom: 1px solid #e8edf2; border-top: none;
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
        width: 52px; height: 70px;
        border-radius: 6px; object-fit: cover;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .book-cover-placeholder {
        width: 52px; height: 70px;
        border-radius: 6px;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        border: 1px solid #e2e8f0;
        display: flex; align-items: center; justify-content: center;
        color: #94a3b8; font-size: 20px;
    }

    /* Book title */
    .book-title {
        font-size: 14px; font-weight: 600; color: #1e293b;
        margin-bottom: 3px; line-height: 1.3;
    }
    .book-desc { font-size: 12px; color: #94a3b8; line-height: 1.4; }
    .book-contributors { font-size: 12px; color: #64748b; margin-top: 4px; }

    /* Badge lisensi */
    .badge-terbatas {
        background: #fff7ed; color: #c2410c;
        border: 1px solid #fed7aa;
        font-size: 11px; font-weight: 600;
        padding: 4px 10px; border-radius: 20px;
    }
    .badge-umum {
        background: #f0fdf4; color: #15803d;
        border: 1px solid #bbf7d0;
        font-size: 11px; font-weight: 600;
        padding: 4px 10px; border-radius: 20px;
    }
    .badge-none {
        background: #f8fafc; color: #94a3b8;
        border: 1px solid #e2e8f0;
        font-size: 11px;
        padding: 4px 10px; border-radius: 20px;
    }

    /* Sort select */
    .sort-select {
        padding: 6px 28px 6px 10px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 12px; font-weight: 600; color: #374151;
        appearance: none;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 8px center;
        cursor: pointer;
    }
    .sort-select:focus { outline: none; border-color: #6366f1; }

    /* Action buttons */
    .action-btns { display: flex; gap: 6px; align-items: center; }
    .btn-action {
        width: 34px; height: 34px;
        border-radius: 8px; border: none;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; cursor: pointer;
        transition: all 0.18s; text-decoration: none;
    }
    .btn-action:hover { transform: translateY(-1px); }
    .btn-view   { background: #eff6ff; color: #3b82f6; }
    .btn-view:hover   { background: #3b82f6; color: #fff; }
    .btn-edit-g { background: #f0fdf4; color: #16a34a; }
    .btn-edit-g:hover { background: #16a34a; color: #fff; }
    .btn-delete { background: #fef2f2; color: #ef4444; }
    .btn-delete:hover { background: #ef4444; color: #fff; }

    /* Empty state */
    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-state .empty-icon {
        width: 80px; height: 80px; background: #f1f5f9;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px; font-size: 32px; color: #94a3b8;
    }
    .empty-state h5 { font-size: 16px; font-weight: 600; color: #374151; margin-bottom: 6px; }
    .empty-state p  { font-size: 13px; color: #94a3b8; margin-bottom: 20px; }

    /* Alert */
    .alert-success {
        background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d;
        border-radius: 10px; padding: 12px 16px;
        font-size: 13.5px; margin-bottom: 16px;
        display: flex; align-items: center; gap: 8px;
    }

    /* Modal hapus */
    .modal-content { border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15); }
    .modal-header  { padding: 18px 22px; border-bottom: 1px solid #f1f5f9; }
    .modal-title   { font-size: 15px; font-weight: 700; color: #1e293b; }
    .modal-body    { padding: 28px 22px; }
    .modal-footer  { padding: 14px 22px; border-top: 1px solid #f1f5f9; }
    .btn-hapus-confirm {
        background: #ef4444; color: #fff; border: none;
        border-radius: 8px; padding: 9px 22px;
        font-size: 13px; font-weight: 600;
        display: inline-flex; align-items: center; gap: 6px;
        cursor: pointer; transition: background 0.15s;
    }
    .btn-hapus-confirm:hover { background: #dc2626; }
</style>
@endpush

@section('content')

{{-- ══ PAGE HERO ══ --}}
<div class="page-hero">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="bi bi-book-half me-2"></i>Daftar Buku</h2>
            <p>Kelola koleksi buku perpustakaan digital Sembari &mdash;
               <strong style="opacity:1;">{{ $totalAll }}</strong> buku tersedia</p>
        </div>
        <a href="{{ route('admin.books.create') }}" class="btn-add">
            <i class="bi bi-plus-circle-fill"></i> Tambah Buku
        </a>
    </div>
</div>

{{-- ══ ALERT ══ --}}
@if(session('success'))
<div class="alert-success">
    <i class="bi bi-check-circle-fill"></i>
    {{ session('success') }}
    <button type="button" class="btn-close ms-auto btn-close-sm" onclick="this.parentElement.remove()"></button>
</div>
@endif

{{-- ══ FILTER BAR ══ --}}
<form method="GET" action="{{ route('admin.books.index') }}" id="filterForm">

    <div class="filter-bar">

        {{-- Search --}}
        <div class="search-group">
            <i class="bi bi-search"></i>
            <input type="text" name="search" id="searchInput"
                   value="{{ $search }}"
                   placeholder="Cari judul atau kontributor..."
                   autocomplete="off">
        </div>

        {{-- Filter Kategori --}}
        <select name="kategori" class="filter-select" onchange="this.form.submit()">
            <option value="">🏷 Semua Kategori</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ $kategori == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
            @endforeach
        </select>

        {{-- Sort --}}
        <select name="sort" class="sort-select" onchange="this.form.submit()">
            <option value="terbaru"    {{ $sort === 'terbaru'     ? 'selected' : '' }}>⏱ Terbaru</option>
            <option value="az"         {{ $sort === 'az'          ? 'selected' : '' }}>🔤 A → Z</option>
            <option value="za"         {{ $sort === 'za'          ? 'selected' : '' }}>🔤 Z → A</option>
            <option value="terpopuler" {{ $sort === 'terpopuler'  ? 'selected' : '' }}>🔥 Terpopuler</option>
        </select>

        {{-- Reset (muncul jika ada filter aktif) --}}
        @if($search || $kategori || $lisensi || $sort !== 'terbaru')
        <a href="{{ route('admin.books.index') }}" class="btn-reset">
            <i class="bi bi-x-circle"></i> Reset
        </a>
        @endif

    </div>

    {{-- Pill Filter Lisensi --}}
    <div class="lisensi-pills mb-3">
        <a href="{{ route('admin.books.index', array_merge(request()->except(['lisensi', 'page']), ['search' => $search, 'kategori' => $kategori, 'sort' => $sort])) }}"
           class="pill {{ !$lisensi ? 'active-all' : '' }}">
            <i class="bi bi-grid me-1"></i> Semua
        </a>
        <a href="{{ route('admin.books.index', array_merge(request()->except(['lisensi', 'page']), ['lisensi' => 'Buku Edisi Umum', 'search' => $search, 'kategori' => $kategori, 'sort' => $sort])) }}"
           class="pill {{ $lisensi === 'Buku Edisi Umum' ? 'active-umum' : '' }}">
            <i class="bi bi-globe me-1"></i> Edisi Umum
        </a>
        <a href="{{ route('admin.books.index', array_merge(request()->except(['lisensi', 'page']), ['lisensi' => 'Buku Edisi Terbatas', 'search' => $search, 'kategori' => $kategori, 'sort' => $sort])) }}"
           class="pill {{ $lisensi === 'Buku Edisi Terbatas' ? 'active-tbts' : '' }}">
            <i class="bi bi-lock-fill me-1"></i> Edisi Terbatas
        </a>
    </div>

</form>

{{-- ══ TABLE CARD ══ --}}
<div class="books-card">
    <div class="books-card-header">
        <h6>
            <span style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#6366f1,#4f46e5);display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:13px;">
                <i class="bi bi-book-fill"></i>
            </span>
            Koleksi Buku
        </h6>
        <div class="result-info">
            Menampilkan <strong>{{ $books->firstItem() ?? 0 }}–{{ $books->lastItem() ?? 0 }}</strong>
            dari <strong>{{ $books->total() }}</strong> buku
            @if($search || $kategori || $lisensi)
                &mdash; <span style="color:#6366f1;">filter aktif</span>
            @endif
        </div>
    </div>

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
                               class="btn-action btn-edit-g"
                               title="Edit Buku">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button"
                                    class="btn-action btn-delete"
                                    title="Hapus Buku"
                                    onclick="openDeleteModal({{ $book->id }}, '{{ addslashes($book->title) }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($books->hasPages())
    <div class="d-flex justify-content-center py-3 border-top">
        {{ $books->links('pagination::bootstrap-5') }}
    </div>
    @endif

    @else
    <div class="empty-state">
        <div class="empty-icon"><i class="bi bi-inbox"></i></div>
        @if($search || $kategori || $lisensi)
            <h5>Tidak Ada Hasil</h5>
            <p>Tidak ada buku yang cocok dengan filter yang dipilih.</p>
            <a href="{{ route('admin.books.index') }}" class="btn-add d-inline-flex" style="background:#6366f1;border-color:#6366f1;">
                <i class="bi bi-x-circle"></i> Hapus Filter
            </a>
        @else
            <h5>Belum Ada Buku</h5>
            <p>Mulai tambahkan buku ke perpustakaan digital Sembari</p>
            <a href="{{ route('admin.books.create') }}" class="btn-add d-inline-flex" style="background:#6366f1;border-color:#6366f1;">
                <i class="bi bi-plus-circle-fill"></i> Tambah Buku Pertama
            </a>
        @endif
    </div>
    @endif
</div>


{{-- ══ MODAL HAPUS ══ --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px">
        <div class="modal-content">
            <form id="formHapus" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle me-2" style="color:#ef4444"></i>Hapus Buku
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div style="width:64px;height:64px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                        <i class="bi bi-trash-fill" style="font-size:26px;color:#ef4444;"></i>
                    </div>
                    <p style="font-size:14px;font-weight:600;color:#1e293b;margin-bottom:8px;">
                        Hapus buku ini?
                    </p>
                    <p id="deleteBookTitle" style="font-size:13px;color:#6366f1;font-weight:700;margin-bottom:8px;"></p>
                    <p style="font-size:13px;color:#64748b;margin:0;">
                        Cover, PDF, dan semua data buku akan dihapus permanen.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-hapus-confirm">
                        <i class="bi bi-trash-fill"></i> Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Modal hapus ──
function openDeleteModal(id, title) {
    document.getElementById('deleteBookTitle').textContent = '"' + title + '"';
    document.getElementById('formHapus').action = '/admin/books/' + id;
    new bootstrap.Modal(document.getElementById('modalHapus')).show();
}

// ── Auto-submit search saat user berhenti mengetik (debounce 500ms) ──
let debounceTimer;
document.getElementById('searchInput').addEventListener('input', function () {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        document.getElementById('filterForm').submit();
    }, 500);
});
</script>
@endpush
