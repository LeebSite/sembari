@extends('admin.layout')

@section('title', 'Tambah Buku')

@push('styles')
<style>
    .form-section {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e8edf2;
        margin-bottom: 20px;
        overflow: hidden;
    }
    .form-section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 16px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e8edf2;
    }
    .form-section-header .section-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        color: #fff;
        flex-shrink: 0;
    }
    .form-section-header h6 {
        margin: 0;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }
    .form-section-header p {
        margin: 0;
        font-size: 12px;
        color: #94a3b8;
    }
    .form-section-body {
        padding: 20px;
    }
    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }
    .form-control, .form-select {
        font-size: 13.5px;
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
        padding: 9px 13px;
        color: #1e293b;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }
    .form-control::placeholder {
        color: #b0bec5;
        font-size: 13px;
    }

    /* Radio & Checkbox custom */
    .license-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
        flex: 1;
    }
    .license-option:hover {
        border-color: #6366f1;
        background: #f5f3ff;
    }
    .license-option input[type="radio"] {
        accent-color: #6366f1;
        width: 16px;
        height: 16px;
    }
    .license-option input[type="radio"]:checked + .license-label {
        color: #6366f1;
        font-weight: 600;
    }
    .license-option:has(input:checked) {
        border-color: #6366f1;
        background: #f5f3ff;
    }
    .license-label {
        font-size: 13.5px;
        font-weight: 500;
        color: #374151;
        cursor: pointer;
    }
    .license-desc {
        font-size: 11.5px;
        color: #94a3b8;
    }

    /* Checkbox grid */
    .check-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }
    .check-item {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 9px 13px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .check-item:hover {
        border-color: #6366f1;
        background: #f5f3ff;
    }
    .check-item:has(input:checked) {
        border-color: #6366f1;
        background: #f5f3ff;
    }
    .check-item input[type="checkbox"] {
        accent-color: #6366f1;
        width: 15px;
        height: 15px;
        flex-shrink: 0;
    }
    .check-item label {
        font-size: 13px;
        font-weight: 500;
        color: #374151;
        cursor: pointer;
        margin: 0;
    }
    .check-item:has(input:checked) label {
        color: #6366f1;
    }

    /* Upload area */
    .upload-area {
        border: 2px dashed #e2e8f0;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }
    .upload-area:hover {
        border-color: #6366f1;
        background: #f5f3ff;
    }
    .upload-area input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }
    .upload-icon {
        font-size: 28px;
        color: #cbd5e1;
        margin-bottom: 8px;
    }
    .upload-text {
        font-size: 13px;
        font-weight: 500;
        color: #64748b;
    }
    .upload-hint {
        font-size: 11.5px;
        color: #b0bec5;
        margin-top: 3px;
    }

    /* Cover preview */
    #coverPreviewBox {
        display: none;
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        position: relative;
    }
    #coverPreviewBox img {
        width: 100%;
        max-height: 220px;
        object-fit: cover;
        display: block;
    }
    #coverPreviewBox .remove-btn {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(0,0,0,0.5);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* PDF preview */
    #pdfPreviewBox {
        display: none;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        background: #fef2f2;
        border: 1.5px solid #fecaca;
        border-radius: 10px;
        margin-top: 10px;
    }
    #pdfPreviewBox .pdf-icon {
        font-size: 28px;
        color: #ef4444;
        flex-shrink: 0;
    }
    #pdfPreviewBox .pdf-name {
        font-size: 13px;
        font-weight: 500;
        color: #374151;
        word-break: break-all;
    }
    #pdfPreviewBox .pdf-size {
        font-size: 11.5px;
        color: #94a3b8;
    }

    /* Submit bar */
    .submit-bar {
        background: #fff;
        border: 1px solid #e8edf2;
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .btn-submit {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 10px 28px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(99,102,241,0.35);
    }
    .btn-cancel {
        background: #f1f5f9;
        color: #64748b;
        border: none;
        border-radius: 10px;
        padding: 10px 24px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    .btn-cancel:hover {
        background: #e2e8f0;
        color: #374151;
    }
    .page-header {
        margin-bottom: 20px;
    }
    .page-header h3 {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px;
    }
    .page-header p {
        font-size: 13px;
        color: #94a3b8;
        margin: 0;
    }
    .badge-required {
        font-size: 11px;
        color: #ef4444;
        font-weight: 600;
        margin-left: 3px;
    }
</style>
@endpush

@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3><i class="bi bi-plus-circle me-2" style="color:#6366f1;"></i>Tambah Buku Baru</h3>
            <p>Isi informasi buku dengan lengkap untuk ditambahkan ke perpustakaan digital</p>
        </div>
        <a href="{{ route('admin.books.index') }}" class="btn-cancel">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" id="bookForm">
    @csrf

    <div class="row g-4">

        <!-- ===== LEFT COLUMN ===== -->
        <div class="col-lg-8">

            <!-- SECTION: Informasi Utama -->
            <div class="form-section">
                <div class="form-section-header">
                    <div class="section-icon" style="background: linear-gradient(135deg,#6366f1,#4f46e5);">
                        <i class="bi bi-book"></i>
                    </div>
                    <div>
                        <h6>Informasi Utama</h6>
                        <p>Judul dan deskripsi buku</p>
                    </div>
                </div>
                <div class="form-section-body">
                    <!-- Judul -->
                    <div class="mb-4">
                        <label class="form-label">Judul Buku <span class="badge-required">*</span></label>
                        <input type="text"
                               class="form-control @error('title') is-invalid @enderror"
                               name="title"
                               value="{{ old('title') }}"
                               placeholder="Masukkan judul buku..."
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-0">
                        <label class="form-label">Deskripsi / Sinopsis</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  name="description"
                                  rows="4"
                                  placeholder="Tulis sinopsis atau deskripsi singkat buku...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SECTION: Kontributor -->
            <div class="form-section">
                <div class="form-section-header">
                    <div class="section-icon" style="background: linear-gradient(135deg,#0ea5e9,#0284c7);">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <h6>Kontributor</h6>
                        <p>Penulis, ilustrator, penerjemah, dll.</p>
                    </div>
                </div>
                <div class="form-section-body">
                    <div class="mb-0">
                        <label class="form-label">Daftar Kontributor</label>
                        <textarea class="form-control @error('contributors') is-invalid @enderror"
                                  name="contributors"
                                  rows="3"
                                  placeholder="Contoh:&#10;Penulis: John Doe&#10;Ilustrator: Jane Smith&#10;Penerjemah: Bob Wilson">{{ old('contributors') }}</textarea>
                        <small class="text-muted mt-1 d-block">
                            <i class="bi bi-info-circle me-1"></i>
                            Tulis satu kontributor per baris
                        </small>
                        @error('contributors')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SECTION: Lisensi & Tingkat Pembaca -->
            <div class="form-section">
                <div class="form-section-header">
                    <div class="section-icon" style="background: linear-gradient(135deg,#f59e0b,#d97706);">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <h6>Lisensi & Tingkat Pembaca</h6>
                        <p>Jenis edisi dan target pembaca</p>
                    </div>
                </div>
                <div class="form-section-body">
                    <!-- Lisensi -->
                    <div class="mb-4">
                        <label class="form-label">Lisensi Buku</label>
                        <div class="d-flex gap-3">
                            <label class="license-option">
                                <input type="radio" name="license" value="Buku Edisi Terbatas"
                                       {{ old('license') == 'Buku Edisi Terbatas' ? 'checked' : '' }}>
                                <div>
                                    <div class="license-label">Edisi Terbatas</div>
                                    <div class="license-desc">Distribusi terbatas</div>
                                </div>
                            </label>
                            <label class="license-option">
                                <input type="radio" name="license" value="Buku Edisi Umum"
                                       {{ old('license') == 'Buku Edisi Umum' ? 'checked' : '' }}>
                                <div>
                                    <div class="license-label">Edisi Umum</div>
                                    <div class="license-desc">Tersedia untuk publik</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Tingkat Pembaca -->
                    <div class="mb-0">
                        <label class="form-label">Tingkat Pembaca <span class="text-muted fw-normal">(Opsional)</span></label>
                        <select class="form-select @error('reading_level_id') is-invalid @enderror"
                                name="reading_level_id">
                            <option value="">— Pilih tingkat pembaca —</option>
                            @foreach($readingLevels as $level)
                                <option value="{{ $level->id }}" {{ old('reading_level_id') == $level->id ? 'selected' : '' }}>
                                    {{ $level->name ?? $level->label }}
                                </option>
                            @endforeach
                        </select>
                        @error('reading_level_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SECTION: Jenis & Kategori -->
            <div class="form-section">
                <div class="form-section-header">
                    <div class="section-icon" style="background: linear-gradient(135deg,#10b981,#059669);">
                        <i class="bi bi-tags"></i>
                    </div>
                    <div>
                        <h6>Jenis & Kategori</h6>
                        <p>Klasifikasi buku (bisa pilih lebih dari satu)</p>
                    </div>
                </div>
                <div class="form-section-body">
                    <!-- Jenis Buku -->
                    <div class="mb-4">
                        <label class="form-label">Jenis Buku</label>
                        <div class="check-grid">
                            @foreach($bookTypes as $type)
                            <label class="check-item">
                                <input type="checkbox"
                                       name="book_types[]"
                                       value="{{ $type->id }}"
                                       {{ in_array($type->id, old('book_types', [])) ? 'checked' : '' }}>
                                <label style="pointer-events:none;">{{ $type->name }}</label>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-0">
                        <label class="form-label">Kategori</label>
                        <div class="check-grid">
                            @foreach($categories as $category)
                            <label class="check-item">
                                <input type="checkbox"
                                       name="categories[]"
                                       value="{{ $category->id }}"
                                       {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                <label style="pointer-events:none;">{{ $category->name }}</label>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ===== RIGHT COLUMN ===== -->
        <div class="col-lg-4">

            <!-- SECTION: Cover Buku -->
            <div class="form-section">
                <div class="form-section-header">
                    <div class="section-icon" style="background: linear-gradient(135deg,#ec4899,#db2777);">
                        <i class="bi bi-image"></i>
                    </div>
                    <div>
                        <h6>Cover Buku</h6>
                        <p>Gambar sampul buku</p>
                    </div>
                </div>
                <div class="form-section-body">
                    <!-- Preview -->
                    <div id="coverPreviewBox" class="mb-3">
                        <img id="coverPreview" src="" alt="Preview">
                        <button type="button" class="remove-btn" onclick="removeCover()">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>

                    <!-- Upload area -->
                    <div class="upload-area" id="coverUploadArea">
                        <input type="file" name="cover_image" id="cover_image"
                               accept="image/*" onchange="previewCover(event)">
                        <div class="upload-icon"><i class="bi bi-cloud-arrow-up"></i></div>
                        <div class="upload-text">Klik atau drag & drop</div>
                        <div class="upload-hint">JPG, PNG — Maks. 2MB</div>
                    </div>
                    @error('cover_image')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- SECTION: File PDF -->
            <div class="form-section">
                <div class="form-section-header">
                    <div class="section-icon" style="background: linear-gradient(135deg,#ef4444,#dc2626);">
                        <i class="bi bi-file-pdf"></i>
                    </div>
                    <div>
                        <h6>File PDF</h6>
                        <p>Isi buku untuk flipbook reader</p>
                    </div>
                </div>
                <div class="form-section-body">
                    <div class="upload-area" id="pdfUploadArea">
                        <input type="file" name="pdf_file" id="pdf_file"
                               accept=".pdf" onchange="previewPdf(event)">
                        <div class="upload-icon"><i class="bi bi-file-earmark-pdf"></i></div>
                        <div class="upload-text">Klik atau drag & drop</div>
                        <div class="upload-hint">PDF — Maks. 50MB</div>
                    </div>

                    <!-- PDF info -->
                    <div id="pdfPreviewBox">
                        <i class="bi bi-file-pdf-fill pdf-icon"></i>
                        <div>
                            <div class="pdf-name" id="pdfName">—</div>
                            <div class="pdf-size" id="pdfSize">—</div>
                        </div>
                    </div>

                    @error('pdf_file')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Tips -->
            <div class="form-section">
                <div class="form-section-body">
                    <div style="font-size:13px; color:#64748b;">
                        <div class="fw-semibold mb-2" style="color:#374151;">
                            <i class="bi bi-lightbulb me-1" style="color:#f59e0b;"></i> Tips Pengisian
                        </div>
                        <ul class="mb-0 ps-3" style="line-height:1.9;">
                            <li>Cover digunakan sebagai thumbnail di halaman utama</li>
                            <li>PDF adalah isi buku yang bisa dibaca via flipbook</li>
                            <li>Tingkat pembaca membantu filter pencarian</li>
                            <li>Pilih kategori yang paling sesuai isi buku</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Submit Bar -->
    <div class="submit-bar mt-2">
        <div style="font-size:13px; color:#94a3b8;">
            <i class="bi bi-asterisk me-1" style="color:#ef4444; font-size:10px;"></i>
            Kolom bertanda wajib diisi
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.books.index') }}" class="btn-cancel">
                <i class="bi bi-x-circle"></i> Batal
            </a>
            <button type="submit" class="btn-submit">
                <i class="bi bi-check-circle"></i> Simpan Buku
            </button>
        </div>
    </div>

</form>

<script>
function previewCover(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('coverPreview').src = e.target.result;
        document.getElementById('coverPreviewBox').style.display = 'block';
        document.getElementById('coverUploadArea').style.display = 'none';
    };
    reader.readAsDataURL(file);
}

function removeCover() {
    document.getElementById('cover_image').value = '';
    document.getElementById('coverPreviewBox').style.display = 'none';
    document.getElementById('coverUploadArea').style.display = 'block';
}

function previewPdf(event) {
    const file = event.target.files[0];
    if (!file) return;
    const size = (file.size / 1024 / 1024).toFixed(2);
    document.getElementById('pdfName').textContent = file.name;
    document.getElementById('pdfSize').textContent = size + ' MB';
    document.getElementById('pdfPreviewBox').style.display = 'flex';
}
</script>

@endsection
