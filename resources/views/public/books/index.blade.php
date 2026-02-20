@extends('public.layout.app')

@section('title', 'Koleksi Buku — Sembari')
@section('description', 'Jelajahi ribuan buku digital gratis untuk anak-anak Indonesia. Filter berdasarkan jenjang, kategori, dan lisensi.')

@section('styles')
    <style>
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
            top: 100px;
            overflow: hidden;
            z-index: 30;
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

        /* ── Sort & Chips ── */
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

        /* ── Book Grid ── */
        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
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
        .bk-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .bk-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.78) 0%, transparent 55%);
            opacity: 0;
            transition: opacity 0.25s;
            display: flex; align-items: flex-end; padding: 14px; z-index: 4;
        }
        
        /* Mobile filter toggle */
        .mobile-filter-toggle {
            display: none;
            background: #0762c9;
            color: #fff;
            padding: 10px 18px;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            margin-bottom: 16px;
        }
        @media (max-width: 1024px) {
            .mobile-filter-toggle { display: flex; align-items: center; gap: 8px; }
            .sidebar { display: none; position: static; }
            .sidebar.open { display: block; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-12px); }
        }
    </style>
@endsection

@section('content')
{{-- ══ PAGE HERO ══ --}}
<div class="bg-gradient-to-br from-brand-blue via-blue-700 to-indigo-600 py-10 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 24px 24px;"></div>
    
    <div class="max-w-6xl mx-auto px-6 lg:px-10 relative">
        <div class="flex flex-col md:flex-row md:items-center gap-6 justify-between">
            <div class="text-white">
                <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-md border border-white/20 px-4 py-1.5 rounded-full mb-4">
                    <span class="text-lg">📚</span>
                    <span class="text-xs font-black uppercase tracking-widest text-white/90">Koleksi Lengkap</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-black mb-2 leading-tight">
                    Semua Buku Tersedia
                </h1>
                <p class="text-blue-100/80 font-semibold">
                    {{ number_format($totalBuku) }} buku digital — gratis & edukatif untuk anak Indonesia!
                </p>
            </div>
            
            {{-- Search Bar --}}
            <form action="{{ route('book.list') }}" method="GET" class="relative group">
                @foreach(request()->except('q') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <input type="text" name="q" value="{{ $search ?? '' }}"
                       placeholder="Cari judul, penulis..."
                       class="w-full md:w-80 pl-6 pr-14 py-4 rounded-2xl border-0 font-bold text-gray-800 shadow-2xl focus:ring-4 focus:ring-brand-yellow/50 transition-all outline-none">
                <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-brand-blue text-white rounded-xl flex items-center justify-center shadow-lg hover:scale-110 active:scale-95 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </form>
        </div>
    </div>
    
    <div class="wave-divider absolute bottom-0 left-0 w-full leading-[0]">
        <svg viewBox="0 0 1440 40" xmlns="http://www.w3.org/2000/svg" class="fill-indigo-50/30"><path d="M0,20 C360,40 1080,0 1440,20 L1440,40 L0,40 Z"/></svg>
    </div>
</div>

<div class="bg-gray-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-6 lg:px-10 py-12">

        <button class="mobile-filter-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4h18M7 8h10M11 12h2M11 16h2"/></svg>
            Filter Koleksi
            @php
                $activeCount = collect([request('lisensi'), request('jenjang'), request('kategori'), request('jenis'), request('tahun'), request('q')])->filter()->count();
            @endphp
            @if($activeCount > 0)
            <span class="bg-red-500 text-white rounded-full w-5 h-5 text-[10px] flex items-center justify-center">{{ $activeCount }}</span>
            @endif
        </button>

        <div class="books-layout">

            {{-- ── SIDEBAR ── --}}
            <aside class="sidebar" id="sidebar">
                <div class="sidebar-top">
                    <h2>
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4h18M7 8h10M11 12h2M11 16h2"/></svg>
                        Filter Buku
                    </h2>
                    <p>Temukan bacaan yang seru!</p>
                </div>

                <form method="GET" action="{{ route('book.list') }}" id="filterForm" class="filter-body text-gray-700">
                    <input type="hidden" name="sort" value="{{ $sort ?? 'terbaru' }}">

                    {{-- CARI --}}
                    <div class="fgroup">
                        <div class="fgroup-label">🔍 <span>Kata Kunci</span></div>
                        <div class="fsearch-wrap">
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" name="q" class="fsearch" value="{{ $search ?? '' }}" placeholder="Judul, penulis...">
                        </div>
                    </div>

                    <div class="fdivider"></div>

                    {{-- LISENSI --}}
                    <div class="fgroup">
                        <div class="fgroup-label">⭐ <span>Lisensi Buku</span></div>
                        <div class="fchecks">
                            <label class="fcheck">
                                <input type="radio" name="lisensi" value="" {{ empty($lisensi) ? 'checked' : '' }} onchange="this.form.submit()">
                                <span>Semua Lisensi</span>
                            </label>
                            <label class="fcheck">
                                <input type="radio" name="lisensi" value="terbatas" {{ ($lisensi ?? '') === 'terbatas' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span>Edisi Terbatas</span>
                                <span class="fcheck-count">🔥</span>
                            </label>
                            <label class="fcheck">
                                <input type="radio" name="lisensi" value="umum" {{ ($lisensi ?? '') === 'umum' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span>Edisi Umum</span>
                            </label>
                        </div>
                    </div>

                    <div class="fdivider"></div>

                    {{-- JENJANG --}}
                    <div class="fgroup">
                        <div class="fgroup-label">🎯 <span>Jenjang Pembaca</span></div>
                        <div class="fselect-wrap">
                            <select name="jenjang" class="fselect" onchange="this.form.submit()">
                                <option value="">Semua Jenjang</option>
                                @foreach($allJenjang as $j)
                                    <option value="{{ $j->id }}" {{ ($jenjang ?? '') == $j->id ? 'selected' : '' }}>{{ $j->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="fdivider"></div>

                    {{-- KATEGORI --}}
                    <div class="fgroup">
                        <div class="fgroup-label">🏷️ <span>Kategori</span></div>
                        @php $catEmoji = ['📚','🎨','🧪','🌍','🎭','🏆','🎵','🌿','⚽','🚀']; @endphp
                        <div class="fchecks max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($allKategori as $idx => $cat)
                                <label class="fcheck">
                                    <input type="radio" name="kategori" value="{{ $cat->id }}" {{ ($kategori ?? '') == $cat->id ? 'checked' : '' }} onchange="this.form.submit()">
                                    <span class="truncate">{{ $catEmoji[$idx % 10] }} {{ $cat->name }}</span>
                                    <span class="fcheck-count">{{ $cat->books_count }}</span>
                                </label>
                            @endforeach
                            <label class="fcheck">
                                <input type="radio" name="kategori" value="" {{ empty($kategori) ? 'checked' : '' }} onchange="this.form.submit()">
                                <span>🔄 Semua Kategori</span>
                            </label>
                        </div>
                    </div>

                    @if($tahunList->count() > 0)
                        <div class="fdivider"></div>
                        <div class="fgroup">
                            <div class="fgroup-label">📅 <span>Tahun Terbit</span></div>
                            <div class="fselect-wrap">
                                <select name="tahun" class="fselect" onchange="this.form.submit()">
                                    <option value="">Semua Tahun</option>
                                    @foreach($tahunList as $t)
                                        <option value="{{ $t }}" {{ ($tahun ?? '') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    @if($activeCount > 0)
                        <div class="fdivider"></div>
                        <a href="{{ route('book.list') }}" class="btn-reset-filter">✕ Bersihkan Filter</a>
                    @endif
                </form>
            </aside>

            {{-- ── MAIN AREA ── --}}
            <div>
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div>
                        <div class="text-sm font-bold text-gray-500 mb-2">
                           Menampilkan <span class="text-gray-900">{{ $books->firstItem() ?? 0 }}–{{ $books->lastItem() ?? 0 }}</span> dari <span class="text-gray-900">{{ $books->total() }}</span> buku
                        </div>
                        @if($activeCount > 0)
                            <div class="flex flex-wrap gap-2">
                                @if(!empty($search)) <div class="filter-chip">🔍 "{{ $search }}"</div> @endif
                                @if(!empty($lisensi)) <div class="filter-chip">⭐ {{ ucfirst($lisensi) }}</div> @endif
                                @if(!empty($jenjang)) <div class="filter-chip">🎯 Jenjang: {{ $allJenjang->firstWhere('id', $jenjang)->name ?? '' }}</div> @endif
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs font-black text-gray-400 uppercase tracking-wider">Urutkan:</span>
                        <div class="sort-select-wrap">
                            <select class="sort-select" onchange="submitSort(this.value)">
                                <option value="terbaru" {{ ($sort ?? 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="populer" {{ ($sort ?? '') === 'populer' ? 'selected' : '' }}>Populer</option>
                                <option value="az"      {{ ($sort ?? '') === 'az'      ? 'selected' : '' }}>A – Z</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Grid --}}
                <div class="book-grid">
                    @forelse($books as $book)
                        <a href="{{ route('book.read', $book->slug ?? $book->id) }}" class="book-card bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col group">
                            <div class="bk-img">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="bk-placeholder">
                                        <span class="text-5xl">📖</span>
                                        <span class="text-[10px] font-black uppercase text-gray-400">Tanpa Cover</span>
                                    </div>
                                @endif

                                @if($book->license === 'Buku Edisi Terbatas')
                                    <div class="absolute top-3 left-3 bg-red-500 text-white text-[9px] font-black px-2.5 py-1 rounded-lg z-10 shadow-lg">⭐ TERBATAS</div>
                                @endif

                                <div class="bk-overlay opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="w-full bg-brand-yellow text-white text-xs font-black py-2.5 rounded-xl text-center translate-y-4 group-hover:translate-y-0 transition-transform">
                                        📖 Baca Sekarang
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 flex-1 flex flex-col">
                                <h3 class="font-black text-gray-800 text-sm leading-snug line-clamp-2 mb-2 group-hover:text-brand-blue transition">{{ $book->title }}</h3>
                                
                                @if($book->readingLevel)
                                    <div class="text-[10px] font-black text-brand-purple bg-purple-50 px-2.5 py-1 rounded-full w-fit mb-3">🎯 {{ $book->readingLevel->name }}</div>
                                @endif

                                <div class="mt-auto pt-3 border-t border-gray-50 flex items-center justify-between">
                                    <div class="flex items-center gap-1.5 text-[11px] font-bold text-gray-400">
                                        <span>👁 {{ number_format($book->stat->views_count ?? 0) }}</span>
                                    </div>
                                    <span class="bg-blue-50 text-brand-blue text-[9px] font-black px-2 py-0.5 rounded-md">PDF</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full py-20 text-center">
                            <div class="text-6xl mb-4">📭</div>
                            <h3 class="text-xl font-black text-gray-800 mb-2">Buku Tidak Ditemukan</h3>
                            <p class="text-gray-500 font-semibold mb-6">Coba ubah kata kunci atau bersihkan filter pencarianmu.</p>
                            <a href="{{ route('book.list') }}" class="inline-block bg-brand-blue text-white px-6 py-3 rounded-2xl font-black text-sm shadow-xl hover:shadow-2xl transition">Reset Filter</a>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if($books->hasPages())
                    <div class="flex justify-center mt-12 gap-2">
                        @if(!$books->onFirstPage())
                            <a href="{{ $books->previousPageUrl() }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border-2 border-gray-100 font-black text-gray-500 hover:border-brand-blue hover:text-brand-blue">‹</a>
                        @endif

                        @foreach($books->getUrlRange(max(1, $books->currentPage()-2), min($books->lastPage(), $books->currentPage()+2)) as $page => $url)
                            <a href="{{ $url }}" class="w-10 h-10 flex items-center justify-center rounded-xl font-black transition {{ $page == $books->currentPage() ? 'bg-brand-blue text-white shadow-lg' : 'bg-white border-2 border-gray-100 text-gray-500 hover:border-brand-blue hover:text-brand-blue' }}">{{ $page }}</a>
                        @endforeach

                        @if($books->hasMorePages())
                            <a href="{{ $books->nextPageUrl() }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border-2 border-gray-100 font-black text-gray-500 hover:border-brand-blue hover:text-brand-blue">›</a>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function submitSort(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('sort', val);
    url.searchParams.delete('page');
    window.location = url.toString();
}
</script>
@endsection
