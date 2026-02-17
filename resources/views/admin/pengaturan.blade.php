@extends('admin.layout')

@section('content')
<!-- =================  SECTION LAYOUT ATAS ================= -->
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1" style="color:#ffffff;">Pengaturan</h3>
        <p class="mb-0" style="color:#ffffff;">
            Pengaturan hak akses admin
        </p>
    </div>

    <div class="header-logo">
        <img src="{{ asset('img/logobalai.png') }}" alt="Logo Balai Bahasa" class="brand-logo"
             class="img-fluid header-logo">
    </div>
</div>

<!-- =================  ISI MAIN CONTENT ================= -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0 text-white">
        Total Admin: {{ $totalAdmin }}
    </h5>

    <!-- TOMBOL TAMBAH ADMIN -->
    <button class="btn btn-add-article d-flex align-items-center ms-2"
            data-bs-toggle="modal"
            data-bs-target="#modalTambahAdmin">
        <span class="icon-plus">+</span> Admin
    </button>
</div>

<!-- WRAPPER ABU-ABU -->
<div class="admin-table-wrapper mb-4">
    <div class="card border-0 shadow-sm admin-table-card">
        <div class="card-body p-0">

            <table class="table mb-0 align-middle">
                <thead style="background:#f9fafb;">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($admin as $item)
                    <tr>
                        <td class="ps-4">{{ $loop->iteration }}</td>

                        <td class="fw-medium">
                            {{ $item->email }}
                        </td>

                        <td>
                            {{ $item->username }}
                        </td>

                        <td class="text-muted">
                            ••••••••
                        </td>

                        <td>
                            <span class="badge
                                {{ strtolower($item->role) === 'super admin' ? 'badge-super-admin' : 'badge-admin' }}">
                                {{ $item->role }}
                            </span>
                        </td>

                        <td class="text-center pe-4">
                            <div class="d-flex justify-content-center gap-2">

                                <!-- EDIT -->
                                <button class="btn btn-link text-secondary p-1 btn-edit-admin"
                                    data-email="{{ $item->email }}"
                                    data-username="{{ $item->username }}"
                                    data-role="{{ $item->role }}">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <!-- HAPUS -->
                                <form action="{{ route('admin.pengaturan.destroy') }}"
                                      method="POST"
                                      onsubmit="return confirmDeleteAdmin('{{ $item->email }}', this)">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ $item->email }}">
                                    <button class="btn btn-link text-danger p-1">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Belum ada data admin
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>

        </div>
    </div>
</div>

<!-- ================= MODAL TAMBAH ADMIN ================= -->
<div class="modal fade" id="modalTambahAdmin" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">
                    Tambah Admin Baru
                </h5>
                <button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4">
                <form action="{{ route('admin.pengaturan.store') }}" method="POST">
                 @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"
                               class="form-control"
                               placeholder="admin@example.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                    
                        <div class="input-group">
                            <input type="password"
                                   name="password"
                                   id="addPassword"
                                   class="form-control"
                                   required>
                    
                            <button type="button"
                                    class="btn btn-outline-secondary"
                                    id="toggleAddPassword">
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
                    <button type="submit" class="btn btn-dark w-100 btn-submit-tokoh">
                        Tambah Admin
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ================= MODAL EDIT ADMIN ================= -->
<div class="modal fade" id="modalEditAdmin" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Edit Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4">
             <form id="formEditAdmin" method="POST" action="{{ route('admin.pengaturan.update') }}">
                    @csrf
                    <input type="hidden" name="email" id="editEmailHidden">

                    <!-- EMAIL (PK, TIDAK BOLEH DIUBAH) -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               id="editEmail"
                               class="form-control"
                               readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text"
                               name="username"
                               id="editUsername"
                               class="form-control"
                               required>
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-3">
                        <label class="form-label">Password</label>

                        <div class="input-group">
                            <input type="password"
                                   name="password"
                                   id="editPassword"
                                   class="form-control"
                                   placeholder="Kosongkan jika tidak diubah">

                            <button type="button"
                                    class="btn btn-outline-secondary"
                                    id="toggleEditPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>

                        <small class="text-muted">
                            Kosongkan jika tidak ingin mengubah password
                        </small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Role</label>
                        <select name="role"
                                id="editRole"
                                class="form-select"
                                required>
                            <option value="admin">Admin</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                    </div>

                    <button type="submit"
                            class="btn btn-dark w-100 btn-submit-tokoh">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
document.querySelectorAll('.btn-edit-admin').forEach(btn => {
    btn.addEventListener('click', function () {

        const email = this.dataset.email;

        document.getElementById('editEmail').value = email;
        document.getElementById('editUsername').value = this.dataset.username;
        document.getElementById('editRole').value = this.dataset.role;
        document.getElementById('editPassword').value = '';

        // set action form (EMAIL sebagai PK)
        document.getElementById('editEmailHidden').value = email;

        new bootstrap.Modal(
            document.getElementById('modalEditAdmin')
        ).show();
    });
});

// toggle password (ikon mata)
document.getElementById('toggleEditPassword').addEventListener('click', function () {
    const input = document.getElementById('editPassword');
    const icon = this.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
});
</script>

<form id="formDeleteAdmin" method="POST" style="display:none;">
    @csrf
</form>

<script>
document.addEventListener("DOMContentLoaded", function () {

    let deleteFormTarget = null;

    window.confirmDeleteAdmin = function (email, formEl) {
        event.preventDefault();
        deleteFormTarget = formEl;

        document.getElementById("deleteText").innerHTML =
            "<span class='fw-light'>Apakah anda yakin ingin menghapus Admin </span>" +
            "<span class='fw-bold'>" + email + "</span><span class='fw-light'>?</span>";

        const modal = document.getElementById("deleteModal");
        modal.style.display = "block";

        setTimeout(() => modal.classList.add("show"), 60);
        return false;
    };

    document.getElementById("btnYes").addEventListener("click", function () {
        if (deleteFormTarget) deleteFormTarget.submit();
    });

    document.getElementById("btnNo").addEventListener("click", function () {
        const modal = document.getElementById("deleteModal");
        modal.classList.remove("show");

        setTimeout(() => {
            modal.style.display = "none";
            deleteFormTarget = null;
        }, 600);
    });

});
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    let notif = document.getElementById("notif-top");
    if (notif) {
        notif.classList.add("show");

        setTimeout(() => {
            notif.classList.add("fade-out");
        }, 2500);

        setTimeout(() => {
            notif.remove();
        }, 3000);
    }
});
</script>

<script>
document.getElementById('toggleAddPassword').addEventListener('click', function () {
    const input = document.getElementById('addPassword');
    const icon = this.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
});
</script>


{{-- NOTIFIKASI SLIDE-DOWN --}}
@if(session('success') || session('error'))
@php
    $msg = strtolower(session('success') ?? session('error'));
    $status = str_contains($msg, 'hapus') ? 'delete'
            : (str_contains($msg, 'tambah') ? 'terbit' : 'draf');
@endphp
<div id="notif-top" class="notif-top notif-{{ $status }}">
    {{ session('success') ?? session('error') }}
</div>
@endif

{{-- MODAL KONFIRMASI DELETE --}}
<div id="deleteModal" class="delete-modal">
    <p id="deleteText"></p>
    <div class="d-flex justify-content-center gap-3 mt-4">
        <button id="btnYes" class="btn-yes">Ya</button>
        <button id="btnNo" class="btn-no">Tidak</button>
    </div>
</div>


@endsection
