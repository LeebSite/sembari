@extends('admin.layout')

@section('title', 'Kategori')

@push('styles')
<style>
    /* ══════════════════════════════════
       PAGE HERO — Kategori (Hijau Teal)
    ══════════════════════════════════ */
    .page-hero {
        background: linear-gradient(135deg, #eaaf0eff 0%, #e07706ff 55%, #4d6ce8ff 100%);
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
    .page-hero h2 {
        font-size: 22px; font-weight: 700;
        margin: 0 0 4px;
        position: relative; z-index: 1;
    }
    .page-hero p {
        font-size: 13px; margin: 0;
        opacity: 0.8;
        position: relative; z-index: 1;
    }
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
        cursor: pointer;
        border: 1.5px solid rgba(255,255,255,0.35);
    }
    .btn-add:hover {
        background: rgba(255,255,255,0.3);
        color: #fff;
        transform: translateY(-1px);
    }

    /* ══════════════════════════════════
       ALERT
    ══════════════════════════════════ */
    .alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #15803d;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 13.5px;
        margin-bottom: 16px;
        display: flex; align-items: center; gap: 8px;
    }
    .alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 13.5px;
        margin-bottom: 16px;
        display: flex; align-items: center; gap: 8px;
    }

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
        padding: 16px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e8edf2;
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; flex-wrap: wrap;
    }
    .books-card-header h6 {
        font-size: 14px; font-weight: 700; color: #1e293b; margin: 0;
        display: flex; align-items: center; gap: 8px;
    }

    /* search */
    .search-wrap { position: relative; }
    .search-wrap i {
        position: absolute; left: 10px; top: 50%;
        transform: translateY(-50%);
        color: #94a3b8; font-size: 14px; pointer-events: none;
    }
    .search-wrap input {
        padding: 7px 12px 7px 32px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px; font-size: 13px;
        color: #1e293b; width: 210px;
        transition: border-color 0.2s;
    }
    .search-wrap input:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
    }

    /* table */
    .books-card table thead tr { background: #f8fafc; }
    .books-card table thead th {
        font-size: 11px; font-weight: 700;
        color: #64748b;
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
    .books-card table tbody tr:hover { background: #f9fffe; }

    .badge-count {
        display: inline-flex; align-items: center; gap: 5px;
        background: #f0fdf4; color: #15803d;
        font-size: 12px; font-weight: 700;
        padding: 3px 10px; border-radius: 20px;
        border: 1px solid #bbf7d0;
    }

    /* action buttons */
    .action-btns { display: flex; gap: 6px; align-items: center; }
    .btn-action {
        width: 34px; height: 34px;
        border-radius: 8px; border: none;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; cursor: pointer;
        transition: all 0.18s; text-decoration: none;
    }
    .btn-action:hover { transform: translateY(-1px); }
    .btn-edit   { background: #eff6ff; color: #3b82f6; }
    .btn-edit:hover   { background: #3b82f6; color: #fff; }
    .btn-delete { background: #fef2f2; color: #ef4444; }
    .btn-delete:hover { background: #ef4444; color: #fff; }

    /* empty state */
    .empty-state {
        padding: 60px 20px; text-align: center;
    }
    .empty-state .empty-icon {
        width: 80px; height: 80px;
        background: #f1f5f9; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
        font-size: 32px; color: #94a3b8;
    }
    .empty-state h5 { font-size: 16px; font-weight: 600; color: #374151; margin-bottom: 6px; }
    .empty-state p  { font-size: 13px; color: #94a3b8; margin-bottom: 20px; }

    /* ══════════════════════════════════
       MODAL
    ══════════════════════════════════ */
    .modal-content {
        border-radius: 16px; border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }
    .modal-header { padding: 18px 22px; border-bottom: 1px solid #f1f5f9; }
    .modal-title  { font-size: 15px; font-weight: 700; color: #1e293b; }
    .modal-body   { padding: 22px; }
    .modal-footer { padding: 14px 22px; border-top: 1px solid #f1f5f9; }

    .form-label-m {
        font-size: 13px; font-weight: 600;
        color: #374151; margin-bottom: 6px; display: block;
    }
    .form-input-m {
        width: 100%; padding: 9px 13px;
        border: 1.5px solid #e2e8f0; border-radius: 8px;
        font-size: 13.5px; color: #1e293b;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-input-m:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
    }
    .form-input-m.is-invalid { border-color: #ef4444; }
    .field-error { font-size: 12px; color: #ef4444; margin-top: 5px; }

    .btn-modal-save {
        background: #10b981; color: #fff; border: none;
        border-radius: 9px; padding: 9px 22px;
        font-size: 13px; font-weight: 600;
        display: inline-flex; align-items: center; gap: 7px;
        transition: background 0.15s; cursor: pointer;
    }
    .btn-modal-save:hover { background: #059669; }
    .btn-modal-save.blue  { background: #3b82f6; }
    .btn-modal-save.blue:hover { background: #2563eb; }
    .btn-modal-save.red   { background: #ef4444; }
    .btn-modal-save.red:hover  { background: #dc2626; }
</style>
@endpush

@section('content')

{{-- ══ PAGE HERO ══ --}}
<div class="page-hero">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="bi bi-tags-fill me-2"></i>Kategori Buku</h2>
            <p>Kelola kategori untuk mengorganisir koleksi buku digital</p>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle-fill"></i> Tambah Kategori
        </button>
    </div>
</div>

{{-- ══ FLASH ══ --}}
@if(session('success'))
<div class="alert-success">
    <i class="bi bi-check-circle-fill"></i>
    {{ session('success') }}
    <button type="button" class="btn-close ms-auto" onclick="this.parentElement.remove()"></button>
</div>
@endif
@if(session('error'))
<div class="alert-danger">
    <i class="bi bi-exclamation-circle-fill"></i>
    {{ session('error') }}
    <button type="button" class="btn-close ms-auto" onclick="this.parentElement.remove()"></button>
</div>
@endif

{{-- ══ TABLE CARD ══ --}}
<div class="books-card">
    <div class="books-card-header">
        <h6>
            <span style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#10b981,#059669);display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:13px;">
                <i class="bi bi-tags-fill"></i>
            </span>
            Semua Kategori
            <span class="badge bg-secondary" style="font-size:11px;font-weight:600;">{{ $categories->total() }}</span>
        </h6>
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Cari kategori...">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table mb-0" id="categoryTable">
            <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Jumlah Buku</th>
                    <th style="width:110px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $i => $cat)
                <tr>
                    <td class="text-muted" style="font-size:12px;">{{ $categories->firstItem() + $i }}</td>
                    <td>
                        <span style="font-weight:600;color:#1e293b;">{{ $cat->name }}</span>
                    </td>
                    <td>
                        <code style="font-size:12px;color:#64748b;background:#f8fafc;padding:2px 8px;border-radius:5px;">{{ $cat->slug }}</code>
                    </td>
                    <td>
                        <span class="badge-count">
                            <i class="bi bi-book-fill" style="font-size:10px;"></i>
                            {{ $cat->books_count }}
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-action btn-edit"
                                    onclick="openEdit({{ $cat->id }}, '{{ addslashes($cat->name) }}')"
                                    title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button class="btn-action btn-delete"
                                    onclick="openDelete({{ $cat->id }}, '{{ addslashes($cat->name) }}', {{ $cat->books_count }})"
                                    title="Hapus">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="bi bi-tags"></i></div>
                            <h5>Belum Ada Kategori</h5>
                            <p>Tambahkan kategori pertama untuk mengorganisir koleksi buku.</p>
                            <button class="btn-add" style="margin:0 auto;background:#10b981;border-color:transparent;"
                                    data-bs-toggle="modal" data-bs-target="#modalTambah">
                                <i class="bi bi-plus-circle-fill"></i> Tambah Kategori
                            </button>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
    <div style="padding:14px 18px;border-top:1px solid #f1f5f9;">
        {{ $categories->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>


{{-- ══════════════════════════════════
    MODAL: TAMBAH
══════════════════════════════════ --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px">
        <div class="modal-content">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2" style="color:#10b981"></i>Tambah Kategori
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label-m">
                        Nama Kategori <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="name"
                           class="form-input-m {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           placeholder="Contoh: Cerita Rakyat"
                           value="{{ old('name') }}" autofocus>
                    @error('name')
                        <p class="field-error"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</p>
                    @enderror
                    <p style="font-size:12px;color:#94a3b8;margin-top:8px;">
                        <i class="bi bi-info-circle me-1"></i>Slug dibuat otomatis dari nama kategori.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">
                        <i class="bi bi-check-lg"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ══════════════════════════════════
    MODAL: EDIT
══════════════════════════════════ --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px">
        <div class="modal-content">
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2" style="color:#3b82f6"></i>Edit Kategori
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label-m">
                        Nama Kategori <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="name" id="editName" class="form-input-m" required>
                    <p style="font-size:12px;color:#94a3b8;margin-top:8px;">
                        <i class="bi bi-info-circle me-1"></i>Slug diperbarui otomatis sesuai nama baru.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save blue">
                        <i class="bi bi-check-lg"></i> Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ══════════════════════════════════
    MODAL: HAPUS
══════════════════════════════════ --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px">
        <div class="modal-content">
            <form id="formHapus" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle me-2" style="color:#ef4444"></i>Hapus Kategori
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center" style="padding:30px 22px;">
                    <div style="width:64px;height:64px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                        <i class="bi bi-trash-fill" style="font-size:26px;color:#ef4444;"></i>
                    </div>
                    <p style="font-size:14px;font-weight:600;color:#1e293b;margin-bottom:8px;">
                        Hapus "<span id="deleteNameDisplay" style="color:#ef4444;"></span>"?
                    </p>
                    <p id="deleteWarning" style="font-size:13px;color:#64748b;margin:0;"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save red">
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
// ── Prefill & buka modal Edit ──
function openEdit(id, name) {
    document.getElementById('editName').value = name;
    document.getElementById('formEdit').action = '/admin/categories/' + id;
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
}

// ── Prefill & buka modal Hapus ──
function openDelete(id, name, bookCount) {
    document.getElementById('deleteNameDisplay').textContent = name;
    document.getElementById('formHapus').action = '/admin/categories/' + id;

    const warn = document.getElementById('deleteWarning');
    warn.innerHTML = bookCount > 0
        ? '<strong style="color:#ef4444;">' + bookCount + ' buku</strong> terhubung ke kategori ini. Relasi buku akan dilepas, data buku <strong>tidak</strong> dihapus.'
        : 'Tindakan ini tidak dapat dibatalkan.';

    new bootstrap.Modal(document.getElementById('modalHapus')).show();
}

// ── Live search tabel ──
document.getElementById('searchInput').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#categoryTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});

// ── Auto-buka modal Tambah jika ada validation error ──
@if($errors->any())
    document.addEventListener('DOMContentLoaded', () => {
        new bootstrap.Modal(document.getElementById('modalTambah')).show();
    });
@endif
</script>
@endpush
