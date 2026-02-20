@extends('admin.layout')

@section('title', 'Kategori')

@push('styles')
<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-header h4 {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    .page-header p {
        font-size: 13px;
        color: #64748b;
        margin: 2px 0 0;
    }

    /* ── Alert ── */
    .alert-custom {
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 500;
        border: none;
        padding: 12px 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .alert-success-custom { background: #f0fdf4; color: #166534; }
    .alert-danger-custom  { background: #fef2f2; color: #991b1b; }

    /* ── Card Table ── */
    .card-table {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e8edf2;
        overflow: hidden;
    }
    .card-table-header {
        padding: 18px 22px;
        background: #f8fafc;
        border-bottom: 1px solid #e8edf2;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }
    .card-table-header h6 {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    /* ── Search ── */
    .search-box {
        position: relative;
    }
    .search-box input {
        padding-left: 36px;
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
        font-size: 13px;
        height: 36px;
        width: 220px;
        color: #1e293b;
        transition: border-color 0.2s;
    }
    .search-box input:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }
    .search-box i {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    /* ── Table ── */
    .table-categories {
        margin: 0;
        font-size: 13.5px;
    }
    .table-categories thead th {
        background: #f1f5f9;
        color: #475569;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 11px 18px;
        border: none;
    }
    .table-categories tbody td {
        padding: 13px 18px;
        border-color: #f1f5f9;
        vertical-align: middle;
        color: #1e293b;
    }
    .table-categories tbody tr:hover {
        background: #f8faff;
    }
    .badge-count {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
    }

    /* ── Buttons ── */
    .btn-edit {
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 7px;
        background: #eff6ff;
        color: #2563eb;
        border: none;
        transition: all 0.15s;
    }
    .btn-edit:hover { background: #dbeafe; color: #1d4ed8; }
    .btn-delete {
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 7px;
        background: #fef2f2;
        color: #dc2626;
        border: none;
        transition: all 0.15s;
    }
    .btn-delete:hover { background: #fee2e2; color: #b91c1c; }
    .btn-primary-custom {
        background: #6366f1;
        color: #fff;
        border: none;
        border-radius: 9px;
        padding: 9px 18px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: background 0.15s;
        cursor: pointer;
    }
    .btn-primary-custom:hover { background: #4f46e5; color: #fff; }

    /* ── Modal ── */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }
    .modal-header {
        padding: 18px 22px;
        border-bottom: 1px solid #f1f5f9;
    }
    .modal-title { font-size: 15px; font-weight: 700; color: #1e293b; }
    .modal-body { padding: 22px; }
    .modal-footer {
        padding: 14px 22px;
        border-top: 1px solid #f1f5f9;
    }
    .form-label-custom {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
        display: block;
    }
    .form-input-custom {
        width: 100%;
        padding: 9px 13px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13.5px;
        color: #1e293b;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-input-custom:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }
    .form-input-custom.is-invalid {
        border-color: #ef4444;
    }
    .text-danger-custom {
        font-size: 12px;
        color: #ef4444;
        margin-top: 4px;
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }
    .empty-state i { font-size: 48px; margin-bottom: 12px; display: block; }
    .empty-state p { font-size: 14px; margin: 0; }
</style>
@endpush

@section('content')

{{-- ── Page Header ── --}}
<div class="page-header">
    <div>
        <h4><i class="bi bi-tags me-2" style="color:#6366f1"></i>Kategori Buku</h4>
        <p>Kelola kategori untuk mengorganisir koleksi buku digital.</p>
    </div>
    <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Kategori
    </button>
</div>

{{-- ── Flash Message ── --}}
@if(session('success'))
<div class="alert-custom alert-success-custom">
    <i class="bi bi-check-circle-fill"></i>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert-custom alert-danger-custom">
    <i class="bi bi-exclamation-circle-fill"></i>
    {{ session('error') }}
</div>
@endif

{{-- ── Table Card ── --}}
<div class="card-table">
    <div class="card-table-header">
        <h6>
            <i class="bi bi-list-ul me-1" style="color:#6366f1"></i>
            Semua Kategori
            <span class="badge bg-secondary ms-2" style="font-size:11px;">{{ $categories->total() }}</span>
        </h6>
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Cari kategori...">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-categories" id="categoryTable">
            <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Jumlah Buku</th>
                    <th style="width:120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $i => $cat)
                <tr>
                    <td class="text-muted" style="font-size:12px;">{{ $categories->firstItem() + $i }}</td>
                    <td>
                        <span style="font-weight:600;">{{ $cat->name }}</span>
                    </td>
                    <td>
                        <code style="font-size:12px;color:#64748b;">{{ $cat->slug }}</code>
                    </td>
                    <td>
                        <span class="badge-count">
                            <i class="bi bi-book-fill" style="font-size:10px;"></i>
                            {{ $cat->books_count }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            {{-- Tombol Edit --}}
                            <button class="btn-edit"
                                    onclick="openEdit({{ $cat->id }}, '{{ addslashes($cat->name) }}')"
                                    title="Edit">
                                <i class="bi bi-pencil"></i> Edit
                            </button>

                            {{-- Tombol Hapus --}}
                            <button class="btn-delete"
                                    onclick="openDelete({{ $cat->id }}, '{{ addslashes($cat->name) }}', {{ $cat->books_count }})"
                                    title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <i class="bi bi-tags text-muted"></i>
                            <p>Belum ada kategori. Klik <strong>Tambah Kategori</strong> untuk memulai.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
    <div style="padding:14px 18px; border-top:1px solid #f1f5f9;">
        {{ $categories->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>


{{-- ════════════════════════════════════════
    MODAL: TAMBAH KATEGORI
════════════════════════════════════════ --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px">
        <div class="modal-content">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">
                        <i class="bi bi-plus-circle me-2" style="color:#6366f1"></i>Tambah Kategori
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label-custom">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-input-custom {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           placeholder="Contoh: Cerita Rakyat"
                           value="{{ old('name') }}" autofocus>
                    @error('name')
                        <p class="text-danger-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                    <p style="font-size:12px;color:#94a3b8;margin-top:8px;">
                        <i class="bi bi-info-circle"></i> Slug akan dibuat otomatis dari nama kategori.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-custom" style="padding:8px 20px;font-size:13px;">
                        <i class="bi bi-check-lg"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ════════════════════════════════════════
    MODAL: EDIT KATEGORI
════════════════════════════════════════ --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px">
        <div class="modal-content">
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">
                        <i class="bi bi-pencil-square me-2" style="color:#2563eb"></i>Edit Kategori
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label-custom">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="editName" class="form-input-custom" required>
                    <p style="font-size:12px;color:#94a3b8;margin-top:8px;">
                        <i class="bi bi-info-circle"></i> Slug akan diperbarui otomatis sesuai nama baru.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-custom" style="padding:8px 20px;font-size:13px;background:#2563eb;">
                        <i class="bi bi-check-lg"></i> Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ════════════════════════════════════════
    MODAL: HAPUS KONFIRMASI
════════════════════════════════════════ --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px">
        <div class="modal-content">
            <form id="formHapus" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusLabel">
                        <i class="bi bi-exclamation-triangle me-2" style="color:#dc2626"></i>Hapus Kategori
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="text-align:center; padding:30px 22px;">
                    <div style="width:64px;height:64px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                        <i class="bi bi-trash" style="font-size:28px;color:#dc2626;"></i>
                    </div>
                    <p style="font-size:14px;color:#1e293b;font-weight:600;margin-bottom:6px;">
                        Hapus "<span id="deleteNameDisplay"></span>"?
                    </p>
                    <p id="deleteWarning" style="font-size:13px;color:#64748b;margin:0;"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm"
                            style="background:#dc2626;color:#fff;border-radius:8px;padding:7px 18px;font-size:13px;font-weight:600;border:none;">
                        <i class="bi bi-trash"></i> Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Buka modal Edit ──
function openEdit(id, name) {
    document.getElementById('editName').value = name;
    document.getElementById('formEdit').action = '/admin/categories/' + id;
    const modal = new bootstrap.Modal(document.getElementById('modalEdit'));
    modal.show();
}

// ── Buka modal Hapus ──
function openDelete(id, name, bookCount) {
    document.getElementById('deleteNameDisplay').textContent = name;
    document.getElementById('formHapus').action = '/admin/categories/' + id;

    const warning = document.getElementById('deleteWarning');
    if (bookCount > 0) {
        warning.innerHTML = '<strong style="color:#dc2626">' + bookCount + ' buku</strong> terhubung ke kategori ini. ' +
            'Relasi buku akan dilepas, tapi data buku <strong>tidak</strong> dihapus.';
    } else {
        warning.textContent = 'Tindakan ini tidak dapat dibatalkan.';
    }

    const modal = new bootstrap.Modal(document.getElementById('modalHapus'));
    modal.show();
}

// ── Live search di tabel ──
document.getElementById('searchInput').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#categoryTable tbody tr').forEach(function (row) {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(q) ? '' : 'none';
    });
});

// ── Buka modal Tambah otomatis jika ada error validasi ──
@if($errors->any())
    document.addEventListener('DOMContentLoaded', function () {
        new bootstrap.Modal(document.getElementById('modalTambah')).show();
    });
@endif
</script>
@endpush
