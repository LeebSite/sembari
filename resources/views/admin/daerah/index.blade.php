@extends('admin.layout')

@section('title', 'Daerah')

@push('styles')
<style>
    .page-hero {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 60%, #0369a1 100%);
        border-radius: 16px; padding: 28px 32px;
        color: #fff; margin-bottom: 24px;
        position: relative; overflow: hidden;
    }
    .page-hero::after {
        content: ''; position: absolute;
        right: -30px; top: -30px;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%; pointer-events: none;
    }
    .page-hero h2 { font-size: 22px; font-weight: 700; margin: 0 0 4px; position: relative; z-index: 1; }
    .page-hero p  { font-size: 13px; margin: 0; opacity: 0.8; position: relative; z-index: 1; }
    .btn-add {
        background: rgba(255,255,255,0.2); color: #fff;
        border: 1.5px solid rgba(255,255,255,0.35);
        border-radius: 10px; padding: 9px 20px;
        font-size: 13.5px; font-weight: 600;
        text-decoration: none; display: flex;
        align-items: center; gap: 7px;
        backdrop-filter: blur(4px); transition: all 0.2s;
        white-space: nowrap; position: relative; z-index: 1; cursor: pointer;
    }
    .btn-add:hover { background: rgba(255,255,255,0.3); color: #fff; transform: translateY(-1px); }

    .alert-success {
        background: #f0fdf4; border: 1px solid #bbf7d0;
        color: #15803d; border-radius: 10px;
        padding: 12px 16px; font-size: 13.5px;
        margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
    }

    .books-card { background: #fff; border-radius: 14px; border: 1px solid #e8edf2; overflow: hidden; }
    .books-card-header {
        padding: 16px 20px; background: #f8fafc;
        border-bottom: 1px solid #e8edf2;
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; flex-wrap: wrap;
    }
    .books-card-header h6 { font-size: 14px; font-weight: 700; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 8px; }

    .search-wrap { position: relative; }
    .search-wrap i { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px; pointer-events: none; }
    .search-wrap input {
        padding: 7px 12px 7px 32px; border: 1.5px solid #e2e8f0;
        border-radius: 8px; font-size: 13px; color: #1e293b; width: 210px; transition: border-color 0.2s;
    }
    .search-wrap input:focus { outline: none; border-color: #0ea5e9; box-shadow: 0 0 0 3px rgba(14,165,233,0.1); }

    .books-card table thead tr { background: #f8fafc; }
    .books-card table thead th {
        font-size: 11px; font-weight: 700; color: #64748b;
        text-transform: uppercase; letter-spacing: 0.5px;
        padding: 13px 16px; border-bottom: 1px solid #e8edf2; border-top: none;
    }
    .books-card table tbody td {
        padding: 14px 16px; vertical-align: middle;
        border-bottom: 1px solid #f1f5f9; font-size: 13.5px;
    }
    .books-card table tbody tr:last-child td { border-bottom: none; }
    .books-card table tbody tr:hover { background: #f0f9ff; }

    .badge-count {
        display: inline-flex; align-items: center; gap: 5px;
        background: #e0f2fe; color: #0369a1;
        font-size: 12px; font-weight: 700;
        padding: 3px 10px; border-radius: 20px;
        border: 1px solid #bae6fd;
    }
    .action-btns { display: flex; gap: 6px; align-items: center; }
    .btn-action {
        width: 34px; height: 34px; border-radius: 8px; border: none;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; cursor: pointer; transition: all 0.18s; text-decoration: none;
    }
    .btn-action:hover { transform: translateY(-1px); }
    .btn-edit   { background: #eff6ff; color: #3b82f6; }
    .btn-edit:hover   { background: #3b82f6; color: #fff; }
    .btn-delete { background: #fef2f2; color: #ef4444; }
    .btn-delete:hover { background: #ef4444; color: #fff; }

    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-state .empty-icon {
        width: 80px; height: 80px; background: #f1f5f9; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px; font-size: 32px; color: #94a3b8;
    }
    .empty-state h5 { font-size: 16px; font-weight: 600; color: #374151; margin-bottom: 6px; }
    .empty-state p  { font-size: 13px; color: #94a3b8; margin-bottom: 20px; }

    .modal-content { border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15); }
    .modal-header { padding: 18px 22px; border-bottom: 1px solid #f1f5f9; }
    .modal-title  { font-size: 15px; font-weight: 700; color: #1e293b; }
    .modal-body   { padding: 22px; }
    .modal-footer { padding: 14px 22px; border-top: 1px solid #f1f5f9; }

    .form-label-m { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; display: block; }
    .form-input-m {
        width: 100%; padding: 9px 13px; border: 1.5px solid #e2e8f0;
        border-radius: 8px; font-size: 13.5px; color: #1e293b;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-input-m:focus { outline: none; border-color: #0ea5e9; box-shadow: 0 0 0 3px rgba(14,165,233,0.1); }
    .field-error { font-size: 12px; color: #ef4444; margin-top: 5px; }

    .btn-modal-save {
        background: #0ea5e9; color: #fff; border: none;
        border-radius: 9px; padding: 9px 22px;
        font-size: 13px; font-weight: 600;
        display: inline-flex; align-items: center; gap: 7px;
        transition: background 0.15s; cursor: pointer;
    }
    .btn-modal-save:hover { background: #0284c7; }
    .btn-modal-save.red   { background: #ef4444; }
    .btn-modal-save.red:hover  { background: #dc2626; }
</style>
@endpush

@section('content')

{{-- PAGE HERO --}}
<div class="page-hero">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="bi bi-geo-alt-fill me-2"></i>Daerah</h2>
            <p>Kelola daerah asal buku untuk memfilter koleksi berdasarkan wilayah kabupaten/kota di Riau</p>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle-fill"></i> Tambah Daerah
        </button>
    </div>
</div>

{{-- FLASH --}}
@if(session('success'))
<div class="alert-success">
    <i class="bi bi-check-circle-fill"></i>
    {{ session('success') }}
    <button type="button" class="btn-close ms-auto" onclick="this.parentElement.remove()"></button>
</div>
@endif

{{-- TABLE --}}
<div class="books-card">
    <div class="books-card-header">
        <h6>
            <span style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#0ea5e9,#0369a1);display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:13px;">
                <i class="bi bi-geo-alt-fill"></i>
            </span>
            Semua Daerah
            <span class="badge bg-secondary" style="font-size:11px;font-weight:600;">{{ $daerahList->total() }}</span>
        </h6>
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Cari daerah...">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table mb-0" id="daerahTable">
            <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th>Nama Daerah</th>
                    <th>Slug</th>
                    <th>Jumlah Buku</th>
                    <th style="width:110px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($daerahList as $i => $daerah)
                <tr>
                    <td class="text-muted">{{ $daerahList->firstItem() + $i }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <span style="width:8px;height:8px;background:#0ea5e9;border-radius:50%;display:inline-block;flex-shrink:0;"></span>
                            <span style="font-weight:600;color:#1e293b;">{{ $daerah->name }}</span>
                        </div>
                    </td>
                    <td><code style="font-size:12px;color:#64748b;background:#f8fafc;padding:2px 8px;border-radius:5px;">{{ $daerah->slug }}</code></td>
                    <td>
                        <span class="badge-count">
                            <i class="bi bi-book-fill" style="font-size:10px;"></i>
                            {{ $daerah->books_count ?? 0 }}
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-action btn-edit"
                                onclick="openEdit({{ $daerah->id }}, '{{ addslashes($daerah->name) }}')">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button class="btn-action btn-delete"
                                onclick="openDelete({{ $daerah->id }}, '{{ addslashes($daerah->name) }}', {{ $daerah->books_count ?? 0 }})">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="bi bi-geo-alt"></i></div>
                            <h5>Belum ada daerah</h5>
                            <p>Tambahkan daerah asal buku dari kabupaten/kota di Riau.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($daerahList->hasPages())
    <div style="padding:14px 18px;border-top:1px solid #f1f5f9;">
        {{ $daerahList->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px">
        <div class="modal-content">
            <form action="{{ route('admin.daerah.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-geo-alt-fill text-primary me-2"></i>Tambah Daerah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label-m">Nama Daerah <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-input-m {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           placeholder="Contoh: Pekanbaru" value="{{ old('name') }}" required>
                    @error('name')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save"><i class="bi bi-check-lg"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px">
        <div class="modal-content">
            <form id="formEdit" method="POST">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Daerah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label-m">Nama Daerah <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="editName" class="form-input-m" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save" style="background:#3b82f6">
                        <i class="bi bi-save"></i> Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL HAPUS --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px">
        <div class="modal-content">
            <form id="formHapus" method="POST">
                @csrf @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Hapus Daerah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Hapus daerah "<span id="deleteNameDisplay" class="fw-bold"></span>"?</p>
                    <p id="deleteWarning" class="small text-muted"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save red"><i class="bi bi-trash"></i> Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openEdit(id, name) {
    document.getElementById('editName').value = name;
    document.getElementById('formEdit').action = '/admin/daerah/' + id;
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
}
function openDelete(id, name, bookCount) {
    document.getElementById('deleteNameDisplay').textContent = name;
    document.getElementById('formHapus').action = '/admin/daerah/' + id;
    document.getElementById('deleteWarning').textContent =
        bookCount > 0 ? bookCount + ' buku terhubung ke daerah ini akan terlepas.' : '';
    new bootstrap.Modal(document.getElementById('modalHapus')).show();
}
document.getElementById('searchInput').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#daerahTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endpush
