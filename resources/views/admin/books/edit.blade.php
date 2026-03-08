@extends('admin.layout')

@section('title', 'Edit Buku')

@push('styles')
<style>
    
    .row.g-4 {
        align-items: flex-start;
        --bs-gutter-y: 0;   /* matikan jarak vertikal bawaan bootstrap */
        padding-top: 0;
        padding-bottom: 0;
    }
    .form-control.description-area {
        height: 135px;
    }
    .form-section {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e8edf2;
        margin-bottom: 16px;
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
        height: 77px; /* ðŸ”¥ samakan tinggi preview */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
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
        font-size: 20px;
        color: #cbd5e1;
        margin-bottom: 0px;
    }
    .upload-text {
        font-size: 10px;
        font-weight: 500;
        color: #64748b;
    }
    .upload-hint {
        font-size: 10px;
        color: #b0bec5;
        margin-top: 3px;
    }
    
    .file-preview-box {
        display: none;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 0 16px;      
        height: 72px;         
        background: #f8fafc;
        border: 2px dashed #e2e8f0; 
        border-radius: 10px;
        margin-bottom: 5px;
        width: 100%;
    }
    
    .file-preview-left {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        min-width: 0;
    }
    
    .file-preview-icon {
        font-size: 22px;
        flex-shrink: 0;
    }
    
    .file-preview-info {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }
    
    .file-preview-name {
        font-size: 13px;
        font-weight: 500;
        color: #374151;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .file-preview-size {
        font-size: 11.5px;
        color: #94a3b8;
    }
    
    .file-remove-btn {
        background: #e2e8f0;
        border: none;
        border-radius: 50%;
        width: 26px;
        height: 26px;
        font-size: 13px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
    }
    
    .file-remove-btn:hover {
        background: #cbd5e1;
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
            <h3><i class="bi bi-pencil-square me-2" style="color:#6366f1;"></i>Edit Buku</h3>
            <p>Perbarui informasi buku: <strong>{{ $book->title }}</strong></p>
        </div>
        <a href="{{ route('admin.books.index') }}" class="btn-cancel">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

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
                    <div class="mb-4">
                        <label class="form-label">Judul Buku <span class="badge-required">*</span></label>
                        <input type="text"
                               class="form-control @error('title') is-invalid @enderror"
                               name="title"
                               value="{{ old('title', $book->title) }}"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Deskripsi / Sinopsis</label>
                        <textarea class="form-control description-area @error('description') is-invalid @enderror"
                                  name="description"
                                  rows="4">{{ old('description', $book->description) }}</textarea>
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
                        <h6>Detail</h6>
                        <p>Penulis, ilustrator, penerjemah, dll.</p>
                    </div>
                </div>
                <div class="form-section-body">
                    <div class="mb-0">
                        <label class="form-label">Detail Buku</label>
                        <textarea class="form-control description-area @error('detail') is-invalid @enderror"
                                  name="detail"
                                  rows="3"
                                  placeholder="Contoh:&#10;Penulis: John Doe&#10;Ilustrator: Jane Smith">{{ old('detail', $book->detail) }}</textarea>
                        <small class="text-muted mt-1 d-block">
                            <i class="bi bi-info-circle me-1"></i>Tulis satu detail per baris
                        </small>
                        @error('detail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
            
                        <div id="coverPreviewBox" class="file-preview-box"
                             style="{{ $book->cover_image ? 'display:flex;' : '' }}">
                        
                            <div class="file-preview-left">
                                <i class="bi bi-image file-preview-icon" style="color:#6366f1;"></i>
                                <div class="file-preview-info">
                                    <div id="coverName" class="file-preview-name">
                                        {{ $book->cover_image ? basename($book->cover_image) : '' }}
                                    </div>
                                    <div id="coverSize" class="file-preview-size">
                                        {{ $book->cover_image ? 'Cover saat ini' : '' }}
                                    </div>
                                </div>
                            </div>
                        
                            <button type="button" class="file-remove-btn" onclick="removeCover()">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        
                        <div class="upload-area"
                             id="coverUploadArea"
                             style="{{ $book->cover_image ? 'display:none;' : '' }}">
                        
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
            
                        <div id="pdfPreviewBox" class="file-preview-box"
                             style="{{ $book->pdf_file ? 'display:flex;' : '' }}">
                        
                            <div class="file-preview-left">
                                <i class="bi bi-file-earmark-pdf file-preview-icon" style="color:#ef4444;"></i>
                                <div class="file-preview-info">
                                    <div id="pdfName" class="file-preview-name">
                                        {{ $book->pdf_file ? basename($book->pdf_file) : '' }}
                                    </div>
                                    <div id="pdfSize" class="file-preview-size">
                                        {{ $book->pdf_file ? 'File saat ini' : '' }}
                                    </div>
                                </div>
                            </div>
                        
                            <button type="button" class="file-remove-btn" onclick="removePdf()">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        
                        <div class="upload-area"
                             id="pdfUploadArea"
                             style="{{ $book->pdf_file ? 'display:none;' : '' }}">
                        
                            <input type="file" name="pdf_file" id="pdf_file"
                                   accept=".pdf" onchange="previewPdf(event)">
                        
                            <div class="upload-icon"><i class="bi bi-file-earmark-pdf"></i></div>
                            <div class="upload-text">Klik atau drag & drop</div>
                            <div class="upload-hint">PDF — Maks. 50MB</div>
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
        <!-- SECTION: Lisensi & Tingkat Pembaca (FULL WIDTH) -->
        <div class="col-12">
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
                    <div class="mb-4">
                        <label class="form-label">Lisensi Buku</label>
                        <div class="d-flex gap-3">
                            <label class="license-option">
                                <input type="radio" name="license" value="Buku Edisi Terbatas"
                                    {{ old('license', $book->license) == 'Buku Edisi Terbatas' ? 'checked' : '' }}>
                                <div>
                                    <div class="license-label">Edisi Terbatas</div>
                                    <div class="license-desc">Distribusi terbatas</div>
                                </div>
                            </label>
                            <label class="license-option">
                                <input type="radio" name="license" value="Buku Edisi Umum"
                                    {{ old('license', $book->license) == 'Buku Edisi Umum' ? 'checked' : '' }}>
                                <div>
                                    <div class="license-label">Edisi Umum</div>
                                    <div class="license-desc">Tersedia untuk publik</div>
                                </div>
                            </label>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Tahun Terbit <span class="text-muted fw-normal">(Opsional)</span></label>
                                <input type="number"
                                    class="form-control"
                                    name="tahun_terbit"
                                    value="{{ old('tahun_terbit', $book->tahun_terbit) }}"
                                    min="1900"
                                    max="{{ date('Y') }}"
                                    placeholder="Contoh: 2023">
                            </div>
                        </div>
        
                        <div class="col-md-6">
                            <label class="form-label">Tingkat Pembaca</label>
                            <select class="form-select"
                                name="reading_level_id">
                                <option value="">— Pilih tingkat pembaca —</option>
                                @foreach($readingLevels as $level)
                                    <option value="{{ $level->id }}"
                                        {{ old('reading_level_id', $book->reading_level_id) == $level->id ? 'selected' : '' }}>
                                        {{ $level->name ?? $level->label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- SECTION: Jenis & Kategori (FULL WIDTH) -->
        <div class="col-12">
            <div class="form-section">
                <div class="form-section-header">
                    <div class="section-icon" style="background: linear-gradient(135deg,#10b981,#059669);">
                        <i class="bi bi-tags"></i>
                    </div>
                    <div>
                        <h6>Daerah & Kategori</h6>
                        <p>Pilih daerah asal buku dan kategori (bisa pilih lebih dari satu)</p>
                    </div>
                </div>
                <div class="form-section-body">

                    {{-- DAERAH — select satu pilihan (1 buku = 1 daerah) --}}
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-geo-alt-fill me-1 text-primary"></i> Daerah Asal
                        </label>
                        <select name="daerah_id" class="form-control" style="border:1.5px solid #e2e8f0;border-radius:8px;padding:9px 12px;font-size:13.5px;">
                            <option value="">-- Pilih Daerah --</option>
                            @foreach($daerahList as $daerah)
                                <option value="{{ $daerah->id }}"
                                    {{ old('daerah_id', $selectedDaerah) == $daerah->id ? 'selected' : '' }}>
                                    {{ $daerah->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- KATEGORI — checkbox banyak pilihan --}}
                    <div class="mb-0">
                        <label class="form-label">Kategori</label>
                        <div class="check-grid">
                            @foreach($categories as $category)
                                <label class="check-item">
                                    <input type="checkbox"
                                        name="categories[]"
                                        value="{{ $category->id }}"
                                        {{ in_array($category->id, old('categories', $selectedCategories)) ? 'checked' : '' }}>
                                    <label style="pointer-events:none;">{{ $category->name }}</label>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Bar -->
    <div class="submit-bar mt-2">
        <div style="font-size:13px; color:#94a3b8;">
            <i class="bi bi-clock-history me-1"></i>
            Terakhir diupdate: {{ \Carbon\Carbon::parse($book->updated_at)->diffForHumans() }}
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.books.index') }}" class="btn-cancel">
                <i class="bi bi-x-circle"></i> Batal
            </a>
            <button type="submit" class="btn-submit">
                <i class="bi bi-check-circle"></i> Simpan Perubahan
            </button>
        </div>
    </div>

</form>

<script>
function previewCover(event) {
    const file = event.target.files[0];
    if (!file) return;

    const size = (file.size / 1024 / 1024).toFixed(2);

    document.getElementById('coverName').textContent = file.name;
    document.getElementById('coverSize').textContent = size + ' MB';

    document.getElementById('coverPreviewBox').style.display = 'flex';
    document.getElementById('coverUploadArea').style.display = 'none';

    const cur = document.getElementById('currentCoverBox');
    if (cur) cur.style.display = 'none';
}

function removeCover() {
    document.getElementById('cover_image').value = '';
    document.getElementById('coverPreviewBox').style.display = 'none';
    document.getElementById('coverUploadArea').style.display = 'flex';

    const cur = document.getElementById('currentCoverBox');
    if (cur) cur.style.display = 'flex';
}

function previewPdf(event) {
    const file = event.target.files[0];
    if (!file) return;

    const size = (file.size / 1024 / 1024).toFixed(2);

    document.getElementById('pdfName').textContent = file.name;
    document.getElementById('pdfSize').textContent = size + ' MB';

    document.getElementById('pdfPreviewBox').style.display = 'flex';
    document.getElementById('pdfUploadArea').style.display = 'none';
}

function removePdf() {
    document.getElementById('pdf_file').value = '';
    document.getElementById('pdfPreviewBox').style.display = 'none';
    document.getElementById('pdfUploadArea').style.display = 'flex';
}
</script>

@endsection
