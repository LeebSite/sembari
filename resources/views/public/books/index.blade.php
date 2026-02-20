<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Buku — Sembari</title>
    <meta name="description" content="Jelajahi ribuan buku digital gratis untuk anak-anak Indonesia. Filter berdasarkan jenjang, kategori, dan lisensi.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Nunito', sans-serif; }

        /* ── Layout ── */
        .books-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 28px;
            align-items: start;
        }
        @media (max-width: 1024px) {
            .books-layout { grid-template-columns: 1fr; }
        }

        /* ── Sidebar ── */
        .sidebar {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            padding: 0;
            position: sticky;
            top: 88px;
            overflow: hidden;
        }
        .sidebar-top {
            background: linear-gradient(135deg, #0762c9, #3b82f6);
            padding: 20px 22px 16px;
        }
        .sidebar-top h2 {
            font-size: 18px;
            font-weight: 900;
            color: #fff;
            display: flex; align-items: center; gap: 10px;
            margin: 0 0 4px;
        }
        .sidebar-top p { font-size: 12px; color: rgba(255,255,255,0.75); margin: 0; font-weight: 600; }

        .filter-body { padding: 18px 20px; }

        /* Filter Group */
        .fgroup { margin-bottom: 20px; }
        .fgroup-label {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin-bottom: 8px;
            display: flex; align-items: center; gap: 6px;
        }
        .fgroup-label span { color: inherit; }

        /* Search input */
        .fsearch {
            width: 100%;
            padding: 10px 14px 10px 40px;
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            background: #f8faff;
            outline: none;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }
        .fsearch:focus { border-color: #3b82f6; background: #fff; }
        .fsearch-wrap { position: relative; }
        .fsearch-wrap svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; }

        /* Select */
        .fselect {
            width: 100%;
            padding: 9px 34px 9px 12px;
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 700;
            color: #374151;
            background: #f8faff;
            outline: none;
            appearance: none;
            cursor: pointer;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }
        .fselect:focus { border-color: #3b82f6; }
        .fselect-wrap { position: relative; }
        .fselect-wrap::after {
            content: '▾';
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 12px;
            pointer-events: none;
        }

        /* Checkbox pills */
        .fchecks { display: flex; flex-direction: column; gap: 5px; }
        .fcheck {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 7px 12px;
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.15s;
            font-size: 13px;
            font-weight: 700;
            color: #374151;
        }
        .fcheck:hover { background: #f0f9ff; }
        .fcheck input[type="radio"],
        .fcheck input[type="checkbox"] {
            accent-color: #0762c9;
            width: 15px;
            height: 15px;
            flex-shrink: 0;
        }
        .fcheck-count {
            margin-left: auto;
            font-size: 11px;
            font-weight: 800;
            background: #f1f5f9;
            color: #94a3b8;
            padding: 1px 7px;
            border-radius: 10px;
        }
        .fcheck input:checked ~ * { color: #0762c9; }
        .fcheck:has(input:checked) { background: #eff6ff; }

        /* Reset link */
        .btn-reset-filter {
            display: block;
            width: 100%;
            text-align: center;
            padding: 10px;
            background: #fee2e2;
            color: #dc2626;
            font-size: 12px;
            font-weight: 800;
            border-radius: 14px;
            text-decoration: none;
            transition: background 0.2s;
            margin-top: 6px;
        }
        .btn-reset-filter:hover { background: #fecaca; }

        /* Divider */
        .fdivider { height: 1px; background: #f1f5f9; margin: 16px 0; }

        /* ── Main Area ── */
        .main-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .result-info {
            font-size: 13px;
            font-weight: 700;
            color: #64748b;
        }
        .result-info strong { color: #1e293b; font-size: 16px; }

        /* Sort */
        .sort-wrap { display: flex; align-items: center; gap: 8px; }
        .sort-label { font-size: 12px; font-weight: 700; color: #64748b; }
        .sort-select {
            padding: 7px 30px 7px 12px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            color: #374151;
            background: #fff;
            outline: none;
            appearance: none;
            cursor: pointer;
        }
        .sort-select:focus { border-color: #3b82f6; }
        .sort-select-wrap { position: relative; }
        .sort-select-wrap::after { content: '▾'; position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 11px; pointer-events: none; }

        /* Active filters chips */
        .active-filters { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px; }
        .filter-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
        }
        .filter-chip:hover { background: #dbeafe; }
        .filter-chip-x { font-size: 14px; line-height: 1; }

        /* ── Book Grid ── */
        .book-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }
        @media (max-width: 1280px) { .book-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 768px)  { .book-grid { grid-template-columns: repeat(2, 1fr); } }

        /* Book Card */
        .bk {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(0,0,0,0.07);
            transition: transform 0.22s, box-shadow 0.22s;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            border: 2px solid transparent;
            position: relative;
        }
        .bk:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.13);
            border-color: #fbbf24;
        }

        .bk-img {
            position: relative;
            width: 100%;
            padding-top: 140%;
            overflow: hidden;
            background: linear-gradient(135deg, #e0e7ff, #f3e8ff);
        }
        .bk-img img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s;
        }
        .bk:hover .bk-img img { transform: scale(1.07); }
        .bk-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .bk-placeholder span:first-child { font-size: 44px; }
        .bk-placeholder span:last-child  { font-size: 11px; font-weight: 700; color: #a78bfa; }

        .bk-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 10px;
            font-weight: 900;
            padding: 3px 9px;
            border-radius: 9px;
            z-index: 5;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }
        .badge-red   { background: #ef4444; color: #fff; }
        .badge-green { background: #10b981; color: #fff; }
        .badge-blue  { background: #3b82f6; color: #fff; }

        /* Hover overlay */
        .bk-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.78) 0%, transparent 55%);
            opacity: 0;
            transition: opacity 0.25s;
            display: flex; align-items: flex-end; padding: 14px; z-index: 4;
        }
        .bk:hover .bk-overlay { opacity: 1; }
        .bk-read-btn {
            width: 100%;
            padding: 9px;
            background: #f59e0b;
            color: #fff;
            font-size: 12px;
            font-weight: 900;
            border-radius: 12px;
            text-align: center;
            transform: translateY(8px);
            transition: transform 0.25s;
            display: block;
        }
        .bk:hover .bk-read-btn { transform: translateY(0); }

        .bk-body { padding: 12px 12px 14px; flex: 1; display: flex; flex-direction: column; gap: 5px; }
        .bk-title {
            font-size: 13px;
            font-weight: 800;
            color: #1a1a2e;
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .bk-level {
            font-size: 10px;
            font-weight: 800;
            color: #7c3aed;
            background: #f3e8ff;
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 9px;
            border-radius: 20px;
            width: fit-content;
        }
        .bk-meta {
            display: flex; align-items: center; justify-content: space-between;
            margin-top: auto; padding-top: 8px;
            border-top: 1px dashed #f1f5f9;
        }
        .bk-views { font-size: 11px; font-weight: 700; color: #94a3b8; }
        .bk-tag { font-size: 10px; font-weight: 900; background: #eff6ff; color: #3b82f6; padding: 2px 8px; border-radius: 8px; }

        /* Empty state */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
        }
        .empty-state .emoji { font-size: 64px; display: block; margin-bottom: 16px; }
        .empty-state h3 { font-size: 20px; font-weight: 900; color: #374151; margin-bottom: 8px; }
        .empty-state p { font-size: 14px; color: #94a3b8; font-weight: 600; margin-bottom: 20px; }
        .empty-state a { background: #0762c9; color: #fff; padding: 10px 24px; border-radius: 14px; font-weight: 800; text-decoration: none; font-size: 13px; }

        /* Pagination */
        .pagination-wrap { display: flex; justify-content: center; align-items: center; gap: 6px; margin-top: 32px; flex-wrap: wrap; }
        .pg-btn {
            min-width: 38px;
            height: 38px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            color: #374151;
            background: #fff;
            border: 2px solid #e5e7eb;
            transition: all 0.15s;
            padding: 0 10px;
        }
        .pg-btn:hover { border-color: #3b82f6; color: #3b82f6; }
        .pg-btn.active { background: #0762c9; color: #fff; border-color: #0762c9; }
        .pg-btn.disabled { opacity: 0.3; pointer-events: none; }

        /* Mobile filter toggle */
        .mobile-filter-toggle {
            display: none;
            align-items: center;
            gap: 8px;
            background: #0762c9;
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            margin-bottom: 16px;
        }
        @media (max-width: 1024px) {
            .mobile-filter-toggle { display: flex; }
            .sidebar {
                display: none;
                position: static;
            }
            .sidebar.open { display: block; }
        }
    </style>
</head>
<body class="bg-[#F8FAFF]">

@include('public.layout.header')

{{-- ══ PAGE HERO ══ --}}
<div style="background: linear-gradient(135deg, #0762c9 0%, #1d4ed8 50%, #4f46e5 100%); padding: 40px 0 60px;" class="relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 24px 24px;"></div>
    {{-- wave bubbles --}}
    <div class="absolute top-6 right-20 w-20 h-20 rounded-full opacity-10" style="background:#fff; animation: float 4s ease-in-out infinite;"></div>
    <div class="absolute bottom-10 left-16 w-12 h-12 rounded-full opacity-10" style="background:#fbbf24; animation: float 3s ease-in-out infinite 1s;"></div>
    <div class="max-w-6xl mx-auto px-6 lg:px-10 relative">
        <div class="flex flex-col md:flex-row md:items-center gap-4 justify-between">
            <div>
                <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.2);padding:6px 14px;border-radius:20px;margin-bottom:12px;">
                    <span style="font-size:18px;">📚</span>
                    <span style="font-size:12px;font-weight:800;color:rgba(255,255,255,0.9);letter-spacing:1px;text-transform:uppercase;">Koleksi Lengkap</span>
                </div>
                <h1 style="font-size:clamp(26px,4vw,36px);font-weight:900;color:#fff;margin:0 0 8px;line-height:1.2;">
                    Semua Buku Tersedia
                </h1>
                <p style="color:rgba(255,255,255,0.75);font-size:15px;font-weight:600;margin:0;">
                    {{ number_format($totalBuku) }} buku menunggumu — gratis & tanpa login!
                </p>
            </div>
            {{-- Quick search inside hero --}}
            <form action="{{ route('book.list') }}" method="GET" class="relative flex-shrink-0">
                @foreach(request()->except('q') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <input type="text" name="q" value="{{ $search ?? '' }}"
                       placeholder="Cari judul, penulis..."
                       style="width:280px;padding:13px 48px 13px 18px;border-radius:18px;border:none;font-size:14px;font-weight:700;color:#1e293b;outline:none;box-shadow:0 4px 16px rgba(0,0,0,0.2);">
                <button type="submit" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#64748b;font-size:18px;">🔍</button>
            </form>
        </div>
    </div>
    {{-- wave bottom --}}
    <div style="position:absolute;bottom:-1px;left:0;right:0;">
        <svg viewBox="0 0 1440 40" xmlns="http://www.w3.org/2000/svg"><path d="M0,20 C360,40 1080,0 1440,20 L1440,40 L0,40 Z" fill="#F8FAFF"/></svg>
    </div>
</div>

{{-- ══ MAIN CONTENT ══ --}}
<div class="max-w-7xl mx-auto px-6 lg:px-10 py-10">

    {{-- Mobile filter toggle --}}
    <button class="mobile-filter-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4h18M7 8h10M11 12h2M11 16h2"/></svg>
        Filter Buku
        @php
            $activeCount = collect([request('lisensi'), request('jenjang'), request('kategori'), request('jenis'), request('tahun'), request('q')])->filter()->count();
        @endphp
        @if($activeCount > 0)
        <span style="background:#ef4444;color:#fff;border-radius:50%;width:20px;height:20px;font-size:11px;display:flex;align-items:center;justify-content:center;">{{ $activeCount }}</span>
        @endif
    </button>

    <div class="books-layout">

        {{-- ══ SIDEBAR FILTER ══ --}}
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-top">
                <h2>
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4h18M7 8h10M11 12h2M11 16h2"/></svg>
                    Filter Buku
                </h2>
                <p>Temukan buku yang kamu suka!</p>
            </div>

            <form method="GET" action="{{ route('book.list') }}" id="filterForm" class="filter-body">
                {{-- Pertahankan sort --}}
                <input type="hidden" name="sort" value="{{ $sort ?? 'terbaru' }}">

                {{-- ── CARI ── --}}
                <div class="fgroup">
                    <div class="fgroup-label">🔍 <span>Kata Kunci</span></div>
                    <div class="fsearch-wrap">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="q" class="fsearch"
                               value="{{ $search ?? '' }}"
                               placeholder="Judul, penulis...">
                    </div>
                </div>

                <div class="fdivider"></div>

                {{-- ── LISENSI ── --}}
                <div class="fgroup">
                    <div class="fgroup-label">⭐ <span>Lisensi</span></div>
                    <div class="fchecks">
                        <label class="fcheck">
                            <input type="radio" name="lisensi" value=""
                                   {{ empty($lisensi) ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            <span>Semua Lisensi</span>
                        </label>
                        <label class="fcheck">
                            <input type="radio" name="lisensi" value="terbatas"
                                   {{ ($lisensi ?? '') === 'terbatas' ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            <span>Edisi Terbatas</span>
                            <span class="fcheck-count">⭐</span>
                        </label>
                        <label class="fcheck">
                            <input type="radio" name="lisensi" value="umum"
                                   {{ ($lisensi ?? '') === 'umum' ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            <span>Edisi Umum</span>
                        </label>
                    </div>
                </div>

                <div class="fdivider"></div>

                {{-- ── JENJANG PEMBACA ── --}}
                <div class="fgroup">
                    <div class="fgroup-label">🎯 <span>Jenjang Pembaca</span></div>
                    <div class="fselect-wrap">
                        <select name="jenjang" class="fselect" onchange="this.form.submit()">
                            <option value="">Semua Jenjang</option>
                            @foreach($allJenjang as $j)
                            <option value="{{ $j->id }}" {{ ($jenjang ?? '') == $j->id ? 'selected' : '' }}>
                                {{ $j->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="fdivider"></div>

                {{-- ── KATEGORI ── --}}
                <div class="fgroup">
                    <div class="fgroup-label">🏷️ <span>Kategori</span></div>
                    @php
                        $catEmoji = ['📖','🎨','🔬','🌍','🎭','🏆','🎵','🌿','⚽','🚀','🦋','🌸'];
                    @endphp
                    <div class="fchecks" style="max-height:240px;overflow-y:auto;padding-right:4px;">
                        @foreach($allKategori as $idx => $cat)
                        <label class="fcheck">
                            <input type="radio" name="kategori" value="{{ $cat->id }}"
                                   {{ ($kategori ?? '') == $cat->id ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            <span>{{ $catEmoji[$idx % count($catEmoji)] }} {{ $cat->name }}</span>
                            <span class="fcheck-count">{{ $cat->books_count }}</span>
                        </label>
                        @endforeach
                        <label class="fcheck">
                            <input type="radio" name="kategori" value=""
                                   {{ empty($kategori) ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            <span>🔄 Semua Kategori</span>
                        </label>
                    </div>
                </div>

                @if($allJenis->count() > 0)
                <div class="fdivider"></div>

                {{-- ── JENIS BUKU ── --}}
                <div class="fgroup">
                    <div class="fgroup-label">📂 <span>Jenis Buku</span></div>
                    <div class="fselect-wrap">
                        <select name="jenis" class="fselect" onchange="this.form.submit()">
                            <option value="">Semua Jenis</option>
                            @foreach($allJenis as $j)
                            <option value="{{ $j->id }}" {{ ($jenis ?? '') == $j->id ? 'selected' : '' }}>
                                {{ $j->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif

                @if($tahunList->count() > 0)
                <div class="fdivider"></div>

                {{-- ── TAHUN TERBIT ── --}}
                <div class="fgroup">
                    <div class="fgroup-label">📅 <span>Tahun Terbit</span></div>
                    <div class="fselect-wrap">
                        <select name="tahun" class="fselect" onchange="this.form.submit()">
                            <option value="">Semua Tahun</option>
                            @foreach($tahunList as $t)
                            <option value="{{ $t }}" {{ ($tahun ?? '') == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif

                @if($activeCount > 0)
                <div class="fdivider"></div>
                <a href="{{ route('book.list') }}" class="btn-reset-filter">
                    ✕ Reset Semua Filter
                </a>
                @endif

            </form>
        </aside>

        {{-- ══ MAIN CONTENT ══ --}}
        <div>
            {{-- Header main --}}
            <div class="main-header">
                <div>
                    <div class="result-info">
                        Menampilkan <strong>{{ $books->firstItem() ?? 0 }}–{{ $books->lastItem() ?? 0 }}</strong>
                        dari <strong>{{ $books->total() }}</strong> buku
                    </div>
                    {{-- Active filter chips --}}
                    @if($activeCount > 0)
                    <div class="active-filters" style="margin-top:8px;">
                        @if(!empty($search))
                        <a href="{{ request()->fullUrlWithoutQuery(['q']) }}" class="filter-chip">
                            🔍 "{{ $search }}" <span class="filter-chip-x">×</span>
                        </a>
                        @endif
                        @if(!empty($lisensi))
                        <a href="{{ request()->fullUrlWithoutQuery(['lisensi']) }}" class="filter-chip">
                            ⭐ {{ $lisensi === 'terbatas' ? 'Edisi Terbatas' : 'Edisi Umum' }} <span class="filter-chip-x">×</span>
                        </a>
                        @endif
                        @if(!empty($jenjang))
                        @php $jLevel = $allJenjang->firstWhere('id', $jenjang); @endphp
                        <a href="{{ request()->fullUrlWithoutQuery(['jenjang']) }}" class="filter-chip">
                            🎯 {{ $jLevel->name ?? 'Jenjang' }} <span class="filter-chip-x">×</span>
                        </a>
                        @endif
                        @if(!empty($kategori))
                        @php $jKat = $allKategori->firstWhere('id', $kategori); @endphp
                        <a href="{{ request()->fullUrlWithoutQuery(['kategori']) }}" class="filter-chip">
                            🏷️ {{ $jKat->name ?? 'Kategori' }} <span class="filter-chip-x">×</span>
                        </a>
                        @endif
                        @if(!empty($tahun))
                        <a href="{{ request()->fullUrlWithoutQuery(['tahun']) }}" class="filter-chip">
                            📅 {{ $tahun }} <span class="filter-chip-x">×</span>
                        </a>
                        @endif
                    </div>
                    @endif
                </div>

                {{-- Sort --}}
                <div class="sort-wrap">
                    <span class="sort-label">Urutkan:</span>
                    <div class="sort-select-wrap">
                        <select class="sort-select" onchange="submitSort(this.value)">
                            <option value="terbaru" {{ ($sort ?? 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="az"      {{ ($sort ?? '') === 'az'      ? 'selected' : '' }}>A – Z</option>
                            <option value="za"      {{ ($sort ?? '') === 'za'      ? 'selected' : '' }}>Z – A</option>
                            <option value="populer" {{ ($sort ?? '') === 'populer' ? 'selected' : '' }}>Terpopuler</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- ── Book Grid ── --}}
            <div class="book-grid">
                @forelse($books as $book)
                <a href="{{ route('book.read', $book->slug ?? $book->id) }}" class="bk">
                    <div class="bk-img">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                 alt="{{ $book->title }}"
                                 loading="lazy">
                        @else
                            <div class="bk-placeholder">
                                <span>📚</span>
                                <span>Tanpa Cover</span>
                            </div>
                        @endif

                        {{-- Badge lisensi --}}
                        @if($book->license === 'Buku Edisi Terbatas')
                            <span class="bk-badge badge-red">⭐ Terbatas</span>
                        @elseif($book->license === 'Buku Edisi Umum')
                            <span class="bk-badge badge-green">✓ Umum</span>
                        @endif

                        <div class="bk-overlay">
                            <span class="bk-read-btn">📖 Baca Sekarang</span>
                        </div>
                    </div>

                    <div class="bk-body">
                        <div class="bk-title" title="{{ $book->title }}">{{ $book->title }}</div>

                        @if($book->readingLevel)
                        <div class="bk-level">
                            <span>🎯</span> {{ $book->readingLevel->name }}
                        </div>
                        @endif

                        @if($book->categories->isNotEmpty())
                        <div style="display:flex;flex-wrap:wrap;gap:3px;margin-top:2px;">
                            @foreach($book->categories->take(2) as $cat)
                            <span style="font-size:9px;font-weight:800;background:#f0fdf4;color:#16a34a;padding:2px 7px;border-radius:8px;">{{ $cat->name }}</span>
                            @endforeach
                        </div>
                        @endif

                        <div class="bk-meta">
                            <span class="bk-views">👁 {{ $book->stat->views_count ?? 0 }}</span>
                            @if($book->tahun_terbit)
                                <span class="bk-tag">{{ $book->tahun_terbit }}</span>
                            @else
                                <span class="bk-tag">PDF</span>
                            @endif
                        </div>
                    </div>
                </a>
                @empty
                <div class="empty-state">
                    <span class="emoji">🔍</span>
                    <h3>Buku Tidak Ditemukan</h3>
                    <p>Coba ubah kata kunci atau filter yang kamu gunakan.</p>
                    <a href="{{ route('book.list') }}">Reset Filter</a>
                </div>
                @endforelse
            </div>

            {{-- ── Pagination ── --}}
            @if($books->hasPages())
            <div class="pagination-wrap">
                {{-- Prev --}}
                @if($books->onFirstPage())
                    <span class="pg-btn disabled">← Prev</span>
                @else
                    <a href="{{ $books->previousPageUrl() }}" class="pg-btn">← Prev</a>
                @endif

                {{-- Pages --}}
                @foreach($books->getUrlRange(max(1, $books->currentPage()-2), min($books->lastPage(), $books->currentPage()+2)) as $page => $url)
                    <a href="{{ $url }}" class="pg-btn {{ $page === $books->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                @endforeach

                {{-- Next --}}
                @if($books->hasMorePages())
                    <a href="{{ $books->nextPageUrl() }}" class="pg-btn">Next →</a>
                @else
                    <span class="pg-btn disabled">Next →</span>
                @endif
            </div>
            @endif

        </div>{{-- /main --}}
    </div>{{-- /books-layout --}}
</div>{{-- /container --}}

@include('public.layout.footer')

<script>
function submitSort(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('sort', val);
    url.searchParams.delete('page');
    window.location = url.toString();
}
</script>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-12px); }
}
</style>
</body>
</html>
