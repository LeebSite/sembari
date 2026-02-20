@extends('admin.layout')

@section('title', 'Detail Buku')

@push('styles')
<style>
    .detail-header {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 60%, #7c3aed 100%);
        border-radius: 16px;
        padding: 28px 32px;
        color: #fff;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .detail-header::after {
        content: ''; position: absolute;
        right: -30px; top: -30px;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.06); border-radius: 50%;
    }
    .detail-header h2 { font-size: 22px; font-weight: 700; margin: 0 0 4px; position: relative; z-index: 1; }
    .detail-header p  { font-size: 13px; margin: 0; opacity: 0.75; position: relative; z-index: 1; }

    .btn-back {
        background: rgba(255,255,255,0.2);
        color: #fff;
        border: 1.5px solid rgba(255,255,255,0.35);
        border-radius: 10px;
        padding: 9px 18px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 7px;
        backdrop-filter: blur(4px);
        transition: all 0.2s;
        position: relative; z-index: 1;
    }
    .btn-back:hover { background: rgba(255,255,255,0.3); color: #fff; }

    .info-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e8edf2;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .info-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e8edf2;
    }
    .info-card-header .ic-icon {
        width: 30px; height: 30px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; color: #fff; flex-shrink: 0;
    }
    .info-card-header h6 { margin: 0; font-size: 13.5px; font-weight: 700; color: #1e293b; }
    .info-card-body { padding: 20px; }

    .detail-row {
        display: flex;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
    }
    .detail-row:last-child { border-bottom: none; padding-bottom: 0; }
    .detail-row:first-child { padding-top: 0; }
    .detail-label {
        min-width: 140px;
        font-weight: 600;
        color: #64748b;
        font-size: 12.5px;
    }
    .detail-value { color: #1e293b; flex: 1; }

    /* Cover */
    .cover-box {
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    .cover-box img {
        width: 100%;
        display: block;
        max-height: 360px;
        object-fit: cover;
    }
    .cover-placeholder {
        width: 100%;
        height: 280px;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        gap: 10px;
    }
    .cover-placeholder i { font-size: 48px; }
    .cover-placeholder span { font-size: 13px; }

    /* PDF box */
    .pdf-box {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        background: #fef2f2;
        border: 1.5px solid #fecaca;
        border-radius: 10px;
    }
    .pdf-box .pdf-icon { font-size: 32px; color: #ef4444; flex-shrink: 0; }
    .pdf-box .pdf-name { font-size: 13px; font-weight: 600; color: #374151; word-break: break-all; }
    .pdf-box .pdf-label { font-size: 11.5px; color: #94a3b8; }

    /* Tags */
    .tag-list { display: flex; flex-wrap: wrap; gap: 6px; }
    .tag {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    .tag-cat  { background: #eff6ff; color: #3b82f6; border: 1px solid #bfdbfe; }
    .tag-type { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
    .tag-level { background: #fdf4ff; color: #9333ea; border: 1px solid #e9d5ff; }

    /* Action bar */
    .action-bar {
        background: #fff;
        border: 1px solid #e8edf2;
        border-radius: 12px;
        padding: 14px 20px;
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .btn-edit-main {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        border: none;
        border-radius: 9px;
        padding: 9px 22px;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 7px;
        transition: all 0.2s;
    }
    .btn-edit-main:hover { color: #fff; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(99,102,241,0.3); }
    .btn-delete-main {
        background: #fef2f2;
        color: #ef4444;
        border: 1.5px solid #fecaca;
        border-radius: 9px;
        padding: 9px 18px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 7px;
        transition: all 0.2s;
    }
    .btn-delete-main:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

    .badge-terbatas {
        background: #fff7ed; color: #c2410c;
        border: 1px solid #fed7aa;
        font-size: 12px; font-weight: 600;
        padding: 4px 12px; border-radius: 20px;
        display: inline-flex; align-items: center; gap: 5px;
    }
    .badge-umum {
        background: #f0fdf4; color: #15803d;
        border: 1px solid #bbf7d0;
        font-size: 12px; font-weight: 600;
        padding: 4px 12px; border-radius: 20px;
        display: inline-flex; align-items: center; gap: 5px;
</style>
@endpush

@section('content')

<!-- Header -->
<div class="detail-header">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h2><i class="bi bi-book-open me-2"></i>{{ $book->title }}</h2>
            <p>Detail informasi buku perpustakaan digital</p>
        </div>
        <a href="{{ route('admin.books.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row g-4">

    <!-- LEFT: Cover & File -->
    <div class="col-lg-4">

        <!-- Cover -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="ic-icon" style="background: linear-gradient(135deg,#ec4899,#db2777);">
                    <i class="bi bi-image"></i>
                </div>
                <h6>Cover Buku</h6>
            </div>
            <div class="info-card-body p-0">
                @if($book->cover_image)
                    <div class="cover-box">
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                    </div>
                @else
                    <div class="cover-placeholder">
                        <i class="bi bi-image"></i>
                        <span>Belum ada cover</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- PDF -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="ic-icon" style="background: linear-gradient(135deg,#ef4444,#dc2626);">
                    <i class="bi bi-file-pdf"></i>
                </div>
                <h6>File PDF</h6>
            </div>
            <div class="info-card-body">
                @if($book->pdf_file)
                    <div class="pdf-box">
                        <i class="bi bi-file-pdf-fill pdf-icon"></i>
                        <div>
                            <div class="pdf-name">{{ basename($book->pdf_file) }}</div>
                            <div class="pdf-label">File PDF tersedia</div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-3" style="color:#94a3b8; font-size:13px;">
                        <i class="bi bi-file-earmark-x" style="font-size:28px; display:block; margin-bottom:6px;"></i>
                        Belum ada file PDF
                    </div>
                @endif
            </div>
        </div>

    </div>

    <!-- RIGHT: Info -->
    <div class="col-lg-8">

        <!-- Informasi Utama -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="ic-icon" style="background: linear-gradient(135deg,#6366f1,#4f46e5);">
                    <i class="bi bi-book"></i>
                </div>
                <h6>Informasi Utama</h6>
            </div>
            <div class="info-card-body">
                <div class="detail-row">
                    <span class="detail-label">Judul</span>
                    <span class="detail-value fw-semibold">{{ $book->title }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Deskripsi</span>
                    <span class="detail-value" style="white-space: pre-line; line-height:1.6;">{{ $book->description ?? '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Lisensi</span>
                    <span class="detail-value">
                        @if($book->license == 'Buku Edisi Terbatas')
                            <span class="badge-terbatas"><i class="bi bi-lock-fill"></i>Edisi Terbatas</span>
                        @elseif($book->license == 'Buku Edisi Umum')
                            <span class="badge-umum"><i class="bi bi-globe"></i>Edisi Umum</span>
                        @else
                            <span style="color:#94a3b8;">—</span>
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tahun Terbit</span>
                    <span class="detail-value">
                        @if($book->tahun_terbit)
                            <span style="display:inline-flex;align-items:center;gap:5px;background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;">
                                <i class="bi bi-calendar-check"></i> {{ $book->tahun_terbit }}
                            </span>
                        @else
                            <span style="color:#94a3b8;">—</span>
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tingkat Pembaca</span>
                    <span class="detail-value">
                        @php
                            $level = $book->reading_level_id
                                ? DB::table('reading_levels')->find($book->reading_level_id)
                                : null;
                        @endphp
                        @if($level)
                            <span class="tag tag-level">{{ $level->name }}</span>
                        @else
                            <span style="color:#94a3b8;">—</span>
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Ditambahkan</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($book->created_at)->format('d M Y, H:i') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Diperbarui</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($book->updated_at)->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <!-- Kontributor -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="ic-icon" style="background: linear-gradient(135deg,#0ea5e9,#0284c7);">
                    <i class="bi bi-people"></i>
                </div>
                <h6>Kontributor</h6>
            </div>
            <div class="info-card-body">
                @if($book->contributors)
                    <div style="white-space: pre-line; font-size: 13.5px; color: #374151; line-height: 1.8;">{{ $book->contributors }}</div>
                @else
                    <span style="color:#94a3b8; font-size:13px;">Belum ada data kontributor</span>
                @endif
            </div>
        </div>

        <!-- Jenis & Kategori -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="ic-icon" style="background: linear-gradient(135deg,#10b981,#059669);">
                    <i class="bi bi-tags"></i>
                </div>
                <h6>Jenis & Kategori</h6>
            </div>
            <div class="info-card-body">
                <div class="detail-row">
                    <span class="detail-label">Jenis Buku</span>
                    <span class="detail-value">
                        @if($bookTypes->count() > 0)
                            <div class="tag-list">
                                @foreach($bookTypes as $type)
                                    <span class="tag tag-type">{{ $type->name }}</span>
                                @endforeach
                            </div>
                        @else
                            <span style="color:#94a3b8;">—</span>
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Kategori</span>
                    <span class="detail-value">
                        @if($categories->count() > 0)
                            <div class="tag-list">
                                @foreach($categories as $cat)
                                    <span class="tag tag-cat">{{ $cat->name }}</span>
                                @endforeach
                            </div>
                        @else
                            <span style="color:#94a3b8;">—</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="action-bar">
            <a href="{{ route('admin.books.edit', $book->id) }}" class="btn-edit-main">
                <i class="bi bi-pencil-square"></i> Edit Buku
            </a>
            <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus buku \'{{ addslashes($book->title) }}\'?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete-main">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </form>
        </div>

    </div>
</div>

@endsection
