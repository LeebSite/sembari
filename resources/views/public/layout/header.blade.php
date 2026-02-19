{{-- ═══════════════════════════════════════════
    NAVBAR — Layout Global
    Digunakan oleh semua halaman publik.
    ⚠️  Stat bar ada di: public/home/statsbar.blade.php
        (tidak diletakkan di sini karena hanya muncul di halaman Home)
══════════════════════════════════════════════ --}}
<nav class="bg-brand-blue navbar-glow sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-6 lg:px-10 h-20 flex items-center justify-between">

        {{-- Logo Balai Bahasa --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 flex-shrink-0">
            <img src="{{ asset('img/logo/logobalai.png') }}" alt="Logo Balai Bahasa Provinsi Riau"
                 class="h-12 w-auto object-contain"
                 style="filter: drop-shadow(0 2px 8px rgba(0,0,0,0.35)) drop-shadow(0 0 12px rgba(255,255,255,0.25));"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            {{-- Fallback teks jika gambar tidak ditemukan --}}
            <div style="display:none" class="bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-xl flex items-center gap-2">
                <span class="text-white font-black text-lg tracking-tight">SEMBARI</span>
            </div>
        </a>

        {{-- Menu Desktop --}}
        <div class="hidden md:flex items-center gap-2 font-bold text-sm text-white/90">
            <a href="{{ route('home') }}" class="text-white bg-white/15 px-4 py-2 rounded-full flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Beranda
            </a>
            <a href="#koleksi" class="hover:text-white hover:bg-white/10 px-4 py-2 rounded-full transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Buku
            </a>
            <a href="#jenjang" class="hover:text-white hover:bg-white/10 px-4 py-2 rounded-full transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Jenjang
            </a>
            <a href="#kategori" class="hover:text-white hover:bg-white/10 px-4 py-2 rounded-full transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Kategori
            </a>
        </div>

        {{-- Search Bar --}}
        <div class="relative hidden lg:block">
            <input type="text" placeholder="Cari buku seru..."
                   class="pl-11 pr-4 py-2.5 rounded-full text-sm font-semibold text-gray-700
                          bg-white/95 border-0 focus:ring-3 focus:ring-brand-yellow w-60
                          shadow-inner transition focus:w-72">
            <svg class="w-4 h-4 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        {{-- Mobile Hamburger --}}
        <button class="md:hidden text-white p-2">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

    </div>
</nav>
