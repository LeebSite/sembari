@extends('admin.layout')

@section('title', 'Jenjang Baca')

@push('styles')
<style>
    /* ══════════════════════════════════
       PAGE HERO — Jenjang Baca (Biru Indigo)
    ══════════════════════════════════ */
    .page-hero {
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 55%, #06b6d4 100%);
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
        display: inline-flex; align-items: center; gap: 7px;
        backdrop-filter: blur(4px);
        transition: all 0.2s;
        cursor: pointer;
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
        background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d;
        border-radius: 10px; padding: 12px 16px; font-size: 13.5px;
        margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
    }
    .alert-danger {
        background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;
        border-radius: 10px; padding: 12px 16px; font-size: 13.5px;
        margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
    }

    /* ══════════════════════════════════
       TABLE CARD
    ══════════════════════════════════ */
    .books-card {
        background: #fff; border-radius: 14px; border: 1px solid #e8edf2;
        overflow: hidden;
    }
    .books-card-header {
        padding: 16px 20px; background: #f8fafc; border-bottom: 1px solid #e8edf2;
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; flex-wrap: wrap;
    }
    .books-card-header h6 {
        font-size: 14px; font-weight: 700; color: #1e293b; margin: 0;
        display: flex; align-items: center; gap: 8px;
    }

    .books-card table thead tr { background: #f8fafc; }
    .books-card table thead th {
        font-size: 11px; font-weight: 700; color: #64748b;
        text-transform: uppercase; letter-spacing: 0.5px;
        padding: 13px 16px; border-bottom: 1px solid #e8edf2;
    }
    .books-card table tbody td {
        padding: 14px 16px; vertical-align: middle;
        border-bottom: 1px solid #f1f5f9; font-size: 13.5px;
    }
    .books-card table tbody tr:hover { background: #f8fafc; }

    .action-btns { display: flex; gap: 6px; align-items: center; }
    .btn-action {
        width: 32px; height: 32px; border-radius: 8px; border: none;
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; cursor: pointer; transition: all 0.18s;
        text-decoration: none;
    }
    .btn-edit   { background: #eff6ff; color: #3b82f6; }
    .btn-edit:hover   { background: #3b82f6; color: #fff; }
    .btn-delete { background: #fef2f2; color: #ef4444; }
    .btn-delete:hover { background: #ef4444; color: #fff; }

    /* ══════════════════════════════════
       MODAL
    ══════════════════════════════════ */
    .modal-content { border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15); }
    .modal-header { padding: 18px 22px; border-bottom: 1px solid #f1f5f9; }
    .modal-body   { padding: 22px; }
    .modal-footer { padding: 14px 22px; border-top: 1px solid #f1f5f9; }

    .form-label-m { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; display: block; }
    .form-input-m {
        width: 100%; padding: 9px 13px; border: 1.5px solid #e2e8f0; border-radius: 8px;
        font-size: 13.5px; color: #1e293b; transition: all 0.2s;
    }
    .form-input-m:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
</style>
@endpush

@section('content')

{{-- ══ PAGE HERO ══ --}}
<div class="page-hero">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2><i class="bi bi-bar-chart-fill me-2"></i>Jenjang Baca</h2>
            <p>Atur tingkatan membaca untuk menyesuaikan target audiens buku</p>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle-fill"></i> Tambah Jenjang
        </button>
    </div>
</div>

{{-- ══ FLASH ══ --}}
@if(session('success'))
<div class="alert-success">
    <i class="bi bi-check-circle-fill"></i>
    <span>{{ session('success') }}</span>
</div>
@endif
@if(session('error'))
<div class="alert-danger">
    <i class="bi bi-exclamation-circle-fill"></i>
    <span>{{ session('error') }}</span>
</div>
@endif

{{-- ══ TABLE CARD ══ --}}
<div class="books-card">
    <div class="books-card-header">
        <h6><i class="bi bi-list-ol me-2"></i>Daftar Jenjang Baca</h6>
    </div>

    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width:70px">Urutan</th>
                    <th style="width:80px">Icon</th>
                    <th>Nama Jenjang</th>
                    <th>Deskripsi</th>
                    <th style="width:100px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($readingLevels as $level)
                <tr>
                    <td class="text-center">
                        <span class="badge bg-light text-dark border">{{ $level->order }}</span>
                    </td>
                    <td>
                        @if($level->icon)
                            <img src="{{ asset('storage/' . $level->icon) }}" 
                                 alt="Icon" 
                                 class="rounded border border-gray-200"
                                 style="width:48px; height:48px; object-fit:cover;">
                        @else
                            <div class="rounded bg-gray-100 flex items-center justify-center border border-dashed border-gray-300"
                                 style="width:48px; height:48px;">
                                <i class="bi bi-image text-gray-400"></i>
                            </div>
                        @endif
                    </td>
                    <td><span style="font-weight:700;color:#1e293b;">{{ $level->name }}</span></td>
                    <td class="text-muted" style="font-size:12px;">{{ $level->description ?: '-' }}</td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-action btn-edit" 
                                onclick="openEdit({{ $level->id }}, '{{ addslashes($level->name) }}', {{ $level->order }}, '{{ addslashes($level->description) }}', '{{ $level->icon ? asset('storage/' . $level->icon) : '' }}')"
                                title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button class="btn-action btn-delete" 
                                onclick="openDelete({{ $level->id }}, '{{ addslashes($level->name) }}')"
                                title="Hapus">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada data jenjang baca.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ══ MODAL TAMBAH ══ --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:450px">
        <div class="modal-content">
            <form action="{{ route('admin.reading-levels.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-bold text-lg text-gray-800">Tambah Jenjang Baca</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body space-y-4">
                    <div>
                        <label class="form-label-m">Nama Jenjang</label>
                        <input type="text" name="name" class="form-input-m" placeholder="Contoh: Pembaca Awal" required>
                    </div>
                    <div>
                        <label class="form-label-m">Ikon Jenjang (Persegi)</label>
                        <input type="file" name="icon" class="form-input-m @error('icon') is-invalid @enderror" accept="image/*">
                        @error('icon')
                            <p class="text-danger mt-1" style="font-size: 11px;">{{ $message }}</p>
                        @enderror
                        <small class="text-muted" style="font-size:11px;">Unggah gambar persegi (PNG/JPG/SVG) maks 2MB.</small>
                    </div>
                    <div>
                        <label class="form-label-m">Urutan (Angka)</label>
                        <input type="number" name="order" class="form-input-m" value="{{ ($readingLevels->max('order') ?? 0) + 1 }}" required>
                    </div>
                    <div>
                        <label class="form-label-m">Deskripsi</label>
                        <textarea name="description" class="form-input-m" rows="3" placeholder="Penjelasan singkat mengenai jenjang ini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══ MODAL EDIT ══ --}}
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:450px">
        <div class="modal-content">
            <form id="formEdit" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title font-bold text-lg text-gray-800">Edit Jenjang Baca</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body space-y-4">
                    <div>
                        <label class="form-label-m">Nama Jenjang</label>
                        <input type="text" name="name" id="editName" class="form-input-m" required>
                    </div>
                    <div class="flex items-start gap-4">
                        <div id="iconPreview" class="hidden mb-2">
                             <img src="" alt="Icon Current" class="rounded border" style="width:60px; height:60px; object-fit:cover;">
                        </div>
                        <div class="flex-1">
                            <label class="form-label-m">Ganti Ikon Jenjang</label>
                            <input type="file" name="icon" class="form-input-m @error('icon') is-invalid @enderror" accept="image/*">
                            @error('icon')
                                <p class="text-danger mt-1" style="font-size: 11px;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label class="form-label-m">Urutan</label>
                        <input type="number" name="order" id="editOrder" class="form-input-m" required>
                    </div>
                    <div>
                        <label class="form-label-m">Deskripsi</label>
                        <textarea name="description" id="editDesc" class="form-input-m" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══ MODAL HAPUS ══ --}}
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px">
        <div class="modal-content">
            <form id="formHapus" method="POST">
                @csrf @method('DELETE')
                <div class="modal-body text-center py-5">
                    <i class="bi bi-exclamation-triangle-fill text-danger text-5xl mb-4"></i>
                    <h5 class="font-bold text-xl text-gray-800 mb-2">Hapus Jenjang Baca?</h5>
                    <p class="text-gray-500 text-sm px-4">Apakah Anda yakin ingin menghapus <strong id="delNameDisplay"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer bg-gray-50">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const baseUrl = "{{ url('admin/reading-levels') }}";

    function openEdit(id, name, order, desc, iconUrl) {
        const form = document.getElementById('formEdit');
        form.action = `${baseUrl}/${id}`;
        document.getElementById('editName').value = name;
        document.getElementById('editOrder').value = order;
        document.getElementById('editDesc').value = desc;
        
        const previewContainer = document.getElementById('iconPreview');
        if (iconUrl) {
            previewContainer.classList.remove('hidden');
            previewContainer.querySelector('img').src = iconUrl;
        } else {
            previewContainer.classList.add('hidden');
        }
        
        new bootstrap.Modal(document.getElementById('modalEdit')).show();
    }

    function openDelete(id, name) {
        const form = document.getElementById('formHapus');
        form.action = `${baseUrl}/${id}`;
        document.getElementById('delNameDisplay').textContent = name;
        new bootstrap.Modal(document.getElementById('modalHapus')).show();
    }
</script>
@endpush
