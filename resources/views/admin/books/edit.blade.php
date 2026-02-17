@extends('admin.layout')

@section('title', 'Edit Buku')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3>Edit Buku</h3>
            <p class="mb-0">Update informasi buku</p>
        </div>
    </div>
</div>

<!-- Form Card -->
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Judul Buku -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $book->title) }}" 
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4">{{ old('description', $book->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kontributor -->
                    <div class="mb-3">
                        <label for="contributors" class="form-label">Kontributor</label>
                        <textarea class="form-control @error('contributors') is-invalid @enderror" 
                                  id="contributors" 
                                  name="contributors" 
                                  rows="3" 
                                  placeholder="Masukkan nama penulis, penerjemah, ilustrator, dll.">{{ old('contributors', $book->contributors) }}</textarea>
                        <small class="text-muted">Pisahkan setiap kontributor dengan enter (baris baru)</small>
                        @error('contributors')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Lisensi Buku -->
                    <div class="mb-3">
                        <label class="form-label">Lisensi Buku</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="license" 
                                       id="license1" 
                                       value="Buku Edisi Terbatas"
                                       {{ old('license', $book->license) == 'Buku Edisi Terbatas' ? 'checked' : '' }}>
                                <label class="form-check-label" for="license1">
                                    Buku Edisi Terbatas
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="license" 
                                       id="license2" 
                                       value="Buku Edisi Umum"
                                       {{ old('license', $book->license) == 'Buku Edisi Umum' ? 'checked' : '' }}>
                                <label class="form-check-label" for="license2">
                                    Buku Edisi Umum
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Buku -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jenis Buku</label>
                        <div class="row">
                            @foreach($bookTypes as $type)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="book_types[]" 
                                           value="{{ $type->id }}" 
                                           id="type{{ $type->id }}" 
                                           {{ in_array($type->id, old('book_types', $selectedBookTypes)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type{{ $type->id }}">
                                        {{ $type->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <div class="row">
                            @foreach($categories as $category)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="categories[]" 
                                           value="{{ $category->id }}" 
                                           id="cat{{ $category->id }}" 
                                           {{ in_array($category->id, old('categories', $selectedCategories)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cat{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Current Cover -->
                    @if($book->cover_image)
                    <div class="mb-3">
                        <label class="form-label">Cover Saat Ini</label>
                        <div class="border rounded p-2" style="background: #f8fafc;">
                            <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                 alt="{{ $book->title }}" 
                                 class="img-fluid rounded"
                                 style="max-height: 200px;">
                        </div>
                    </div>
                    @endif

                    <!-- Upload New Cover -->
                    <div class="mb-3">
                        <label for="cover_image" class="form-label">Ganti Cover Buku</label>
                        <input type="file" 
                               class="form-control @error('cover_image') is-invalid @enderror" 
                               id="cover_image" 
                               name="cover_image" 
                               accept="image/*" 
                               onchange="previewImage(event)">
                        <small class="text-muted d-block mt-1">Kosongkan jika tidak ingin mengubah</small>
                        @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Image Preview -->
                    <div id="imagePreview" class="mt-3" style="display:none;">
                        <p class="text-muted mb-2 small">Preview Cover Baru:</p>
                        <img id="preview" src="" class="img-fluid rounded" style="max-height: 200px; border: 2px solid #e2e8f0;">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Update Buku
                </button>
                <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Preview image before upload
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewDiv = document.getElementById('imagePreview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}
</script>

@endsection
