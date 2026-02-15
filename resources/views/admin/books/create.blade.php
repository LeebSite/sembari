@extends('admin.layout')

@section('content')
<div class="page-header mb-4">
    <h3 class="mb-1" style="color:#1e3a8a;">Tambah Buku Baru</h3>
    <p class="mb-0 text-muted">Lengkapi form di bawah untuk menambahkan buku ke perpustakaan digital</p>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <strong>Terdapat kesalahan:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informasi Buku</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}" 
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="5">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="reading_level_id" class="form-label">Tingkat Pembaca</label>
                            <select class="form-select" id="reading_level_id" name="reading_level_id">
                                <option value="">-- Pilih Tingkat --</option>
                                @foreach($readingLevels as $level)
                                    <option value="{{ $level->id }}" {{ old('reading_level_id') == $level->id ? 'selected' : '' }}>
                                        {{ $level->code }} - {{ $level->label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="license_id" class="form-label">Lisensi</label>
                            <select class="form-select" id="license_id" name="license_id">
                                <option value="">-- Pilih Lisensi --</option>
                                @foreach($licenses as $license)
                                    <option value="{{ $license->id }}" {{ old('license_id') == $license->id ? 'selected' : '' }}>
                                        {{ $license->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Kategori Buku</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($categories as $category)
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="categories[]" 
                                       value="{{ $category->id }}" 
                                       id="cat{{ $category->id }}"
                                       {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cat{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Kontributor</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Penulis</label>
                        @foreach($authors as $author)
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="penulis[]" 
                                   value="{{ $author->id }}" 
                                   id="penulis{{ $author->id }}">
                            <label class="form-check-label" for="penulis{{ $author->id }}">
                                {{ $author->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Penerjemah</label>
                        @foreach($authors as $author)
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="penerjemah[]" 
                                   value="{{ $author->id }}" 
                                   id="penerjemah{{ $author->id }}">
                            <label class="form-check-label" for="penerjemah{{ $author->id }}">
                                {{ $author->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold">Ilustrator</label>
                        @foreach($authors as $author)
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="ilustrator[]" 
                                   value="{{ $author->id }}" 
                                   id="ilustrator{{ $author->id }}">
                            <label class="form-check-label" for="ilustrator{{ $author->id }}">
                                {{ $author->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Cover Buku</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="cover_image" class="form-label">Upload Cover</label>
                        <input type="file" 
                               class="form-control @error('cover_image') is-invalid @enderror" 
                               id="cover_image" 
                               name="cover_image" 
                               accept="image/*"
                               onchange="previewImage(event)">
                        <small class="text-muted">Format: JPG, PNG. Max 2MB</small>
                        @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="imagePreview" class="mt-3" style="display:none;">
                        <p class="text-muted mb-2">Preview:</p>
                        <img id="preview" src="" class="img-fluid rounded" style="max-height: 300px;">
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Simpan Buku
                </button>
                <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
            </div>
        </div>
    </div>
</form>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewDiv = document.getElementById('imagePreview');
    
    if (event.target.files && event.target.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.style.display = 'block';
        }
        
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>
@endsection
