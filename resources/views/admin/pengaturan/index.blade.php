@extends('admin.layout')

@section('title', 'Pengaturan')

@push('styles')
<style>
/* ── Pengaturan page styles ── */
.pg-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #334155 100%);
    border-radius: 20px;
    padding: 28px 32px;
    color: #fff;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}
.pg-hero::before {
    content: '';
    position: absolute;
    top: -50px; right: -50px;
    width: 200px; height: 200px;
    background: rgba(255,255,255,0.04);
    border-radius: 50%;
    pointer-events: none;
}
.pg-hero-left { position: relative; z-index: 1; }
.pg-hero h2 {
    font-size: 22px; font-weight: 800;
    margin: 0 0 5px; color: #fff;
}
.pg-hero p {
    font-size: 13.5px; margin: 0;
    opacity: 0.7; color: #fff;
}
.btn-add-admin {
    display: inline-flex; align-items: center; gap: 7px;
    background: rgba(255,255,255,0.12);
    color: #fff;
    border: 1.5px solid rgba(255,255,255,0.25);
    border-radius: 8px;
    padding: 9px 18px;
    font-size: 13px; font-weight: 600;
    cursor: pointer; transition: all 0.2s;
    backdrop-filter: blur(4px);
    position: relative; z-index: 1;
    white-space: nowrap;
    text-decoration: none;
}
.btn-add-admin:hover {
    background: rgba(255,255,255,0.22);
    color: #fff;
}

/* Table card */
.pg-table-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e8edf2;
    overflow: hidden;
}
.pg-table-card table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
}
.pg-table-card table thead th {
    background: #f8fafc;
    font-size: 11px; font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase; letter-spacing: 0.5px;
    padding: 13px 18px;
    border-bottom: 1px solid #e8edf2;
    border-top: none;
    white-space: nowrap;
}
.pg-table-card table tbody td {
    padding: 14px 18px;
    vertical-align: middle;
    font-size: 13.5px;
    border-bottom: 1px solid #f8fafc;
    color: #0f172a;
}
.pg-table-card table tbody tr:last-child td {
    border-bottom: none;
}
.pg-table-card table tbody tr:hover {
    background: #fafbff;
}

/* Role badges */
.badge-super-admin {
    background: #f5f3ff; color: #6d28d9;
    border: 1px solid #e9d5ff;
    font-size: 11px; font-weight: 600;
    padding: 3px 10px; border-radius: 20px;
    display: inline-block;
}
.badge-admin {
    background: #eff6ff; color: #1d4ed8;
    border: 1px solid #bfdbfe;
    font-size: 11px; font-weight: 600;
    padding: 3px 10px; border-radius: 20px;
    display: inline-block;
}

/* Table action buttons */
.tbl-btn {
    width: 32px; height: 32px;
    border-radius: 7px; border: none;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 14px; cursor: pointer;
    transition: all 0.18s; text-decoration: none;
    background: transparent;
}
.tbl-btn-edit  { color: #94a3b8; }
.tbl-btn-edit:hover  { background: #eff6ff; color: #3b82f6; }
.tbl-btn-del   { color: #fca5a5; }
.tbl-btn-del:hover   { background: #fef2f2; color: #ef4444; }

/* Notif */
.notif-top {
    position: fixed;
    top: -80px; left: 50%;
    transform: translateX(-50%);
    background: #1e293b;
    color: #fff;
    padding: 12px 28px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 500;
    z-index: 9999;
    transition: top 0.4s ease;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    white-space: nowrap;
}
.notif-top.show { top: 20px; }
.notif-top.fade-out { top: -80px; }

/* Delete modal */
.delete-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15,23,42,0.6);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(4px);
}
.delete-modal.show { display: flex; }
.delete-modal-box {
    background: #fff;
    border-radius: 16px;
    padding: 32px 28px;
    max-width: 380px;
    width: 90%;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
}
.delete-modal-box .del-icon {
    width: 56px; height: 56px;
    background: #fef2f2;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; color: #ef4444;
    margin: 0 auto 16px;
}
.delete-modal-box h5 {
    font-size: 16px; font-weight: 700;
    margin-bottom: 8px; color: #0f172a;
}
.delete-modal-box p {
    font-size: 13.5px; color: #64748b;
    margin-bottom: 24px;
}
.btn-yes {
    background: #ef4444; color: #fff;
    border: none; border-radius: 8px;
    padding: 9px 24px; font-size: 13.5px; font-weight: 600;
    cursor: pointer; transition: all 0.2s;
}
.btn-yes:hover { background: #dc2626; }
.btn-no {
    background: #f1f5f9; color: #64748b;
    border: none; border-radius: 8px;
    padding: 9px 24px; font-size: 13.5px; font-weight: 600;
    cursor: pointer; transition: all 0.2s;
}
.btn-no:hover { background: #e2e8f0; }
</style>
@endpush

@section('content')

{{-- ── HERO ── --}}
<div class="pg-hero">
    <div class="pg-hero-left">
        <h2><i class="bi bi-gear-fill me-2"></i>Pengaturan</h2>
        <p>Kelola hak akses dan akun admin &nbsp;·&nbsp; Total: {{ $totalAdmin }} admin</p>
    </div>
    <button class="btn-add-admin"
            data-bs-toggle="modal"
            data-bs-target="#modalTambahAdmin">
        <i class="bi bi-person-plus-fill"></i> Tambah Admin
    </button>
</div>

{{-- ── TABLE ── --}}
<div class="pg-table-card">
    <table>
        <thead>
            <tr>
                <th style="width:50px;">No</th>
                <th>Email</th>
                <th>Username</th>
                <th>Password</th>
                <th>Role</th>
                <th style="text-align:center; width:100px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($admin as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td style="font-weight:500;">{{ $item->email }}</td>
                <td>{{ $item->username }}</td>
                <td style="letter-spacing:2px; color:#94a3b8;">••••••••</td>
                <td>
                    @php
                        $role = strtolower($item->role);
                        $isSuperAdmin = $role === 'super admin' || $role === 'super_admin';
                    @endphp
                    <span class="{{ $isSuperAdmin ? 'badge-super-admin' : 'badge-admin' }}">
                        {{ $item->role }}
                    </span>
                </td>
                <td>
                    <div style="display:flex; justify-content:center; gap:4px;">
                        <button class="tbl-btn tbl-btn-edit btn-edit-admin"
                                data-email="{{ $item->email }}"
                                data-username="{{ $item->username }}"
                                data-role="{{ $item->role }}"
                                title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('admin.pengaturan.destroy') }}"
                              method="POST"
                              onsubmit="return confirmDeleteAdmin('{{ $item->email }}', this)">
                            @csrf
                            <input type="hidden" name="email" value="{{ $item->email }}">
                            <button type="submit" class="tbl-btn tbl-btn-del" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:48px 20px; color:#94a3b8;">
                    <i class="bi bi-people" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                    Belum ada data admin
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ── MODAL TAMBAH ── --}}
<div class="modal fade" id="modalTambahAdmin" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Admin Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <form action="{{ route('admin.pengaturan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               placeholder="admin@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="addPassword"
                                   class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary" id="toggleAddPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="" disabled selected>Pilih role</option>
                            <option value="admin">Admin</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Tambah Admin</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ── MODAL EDIT ── --}}
<div class="modal fade" id="modalEditAdmin" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <form id="formEditAdmin" method="POST" action="{{ route('admin.pengaturan.update') }}">
                    @csrf
                    <input type="hidden" name="email" id="editEmailHidden">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="editEmail"
                               class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" id="editUsername"
                               class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="editPassword"
                                   class="form-control"
                                   placeholder="Kosongkan jika tidak diubah">
                            <button type="button" class="btn btn-outline-secondary" id="toggleEditPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Role</label>
                        <select name="role" id="editRole" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ── DELETE CONFIRM ── --}}
<div id="deleteModal" class="delete-modal">
    <div class="delete-modal-box">
        <div class="del-icon"><i class="bi bi-trash3-fill"></i></div>
        <h5>Hapus Admin?</h5>
        <p id="deleteText">Apakah Anda yakin ingin menghapus admin ini?</p>
        <div style="display:flex; justify-content:center; gap:12px;">
            <button id="btnNo" class="btn-no">Batal</button>
            <button id="btnYes" class="btn-yes">Ya, Hapus</button>
        </div>
    </div>
</div>

{{-- ── NOTIF ── --}}
@if(session('success') || session('error'))
<div id="notif-top" class="notif-top">
    <i class="bi bi-check-circle-fill me-2"></i>
    {{ session('success') ?? session('error') }}
</div>
@endif

@push('scripts')
<script>
// Edit admin modal
document.querySelectorAll('.btn-edit-admin').forEach(function(btn) {
    btn.addEventListener('click', function () {
        document.getElementById('editEmail').value       = this.dataset.email;
        document.getElementById('editUsername').value    = this.dataset.username;
        document.getElementById('editRole').value        = this.dataset.role;
        document.getElementById('editPassword').value    = '';
        document.getElementById('editEmailHidden').value = this.dataset.email;
        new bootstrap.Modal(document.getElementById('modalEditAdmin')).show();
    });
});

// Toggle password
function setupToggle(inputId, btnId) {
    var btn = document.getElementById(btnId);
    if (!btn) return;
    btn.addEventListener('click', function () {
        var input = document.getElementById(inputId);
        var icon  = this.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
}
setupToggle('addPassword', 'toggleAddPassword');
setupToggle('editPassword', 'toggleEditPassword');

// Delete confirm
var deleteFormTarget = null;
window.confirmDeleteAdmin = function (email, formEl) {
    event.preventDefault();
    deleteFormTarget = formEl;
    document.getElementById('deleteText').innerHTML =
        'Apakah Anda yakin ingin menghapus admin <strong>' + email + '</strong>?';
    document.getElementById('deleteModal').classList.add('show');
    return false;
};
document.getElementById('btnYes').addEventListener('click', function () {
    if (deleteFormTarget) deleteFormTarget.submit();
});
document.getElementById('btnNo').addEventListener('click', function () {
    document.getElementById('deleteModal').classList.remove('show');
    deleteFormTarget = null;
});

// Notif auto-hide
var notif = document.getElementById('notif-top');
if (notif) {
    setTimeout(function() { notif.classList.add('show'); }, 100);
    setTimeout(function() { notif.classList.add('fade-out'); }, 2800);
    setTimeout(function() { notif.remove(); }, 3400);
}
</script>
@endpush

@endsection
