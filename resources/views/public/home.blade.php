<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sembari — Perpustakaan Digital BBPR</title>
    <meta name="description" content="Sembari adalah platform membaca buku digital gratis dari Balai Bahasa Provinsi Riau. Ribuan buku cerita untuk anak tersedia di sini!">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'round': ['"Nunito"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            blue:   '#0762c9ff',
                            sky:    '#1d83d1ff',
                            green:  '#27AE60',
                            yellow: '#F5A623',
                            orange: '#E8621E',
                            purple: '#7C3AED',
                            pink:   '#E91E8C',
                        }
                    },
                    animation: {
                        'float': 'float 4s ease-in-out infinite',
                        'wiggle': 'wiggle 1s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%':      { transform: 'translateY(-12px)' },
                        },
                        wiggle: {
                            '0%, 100%': { transform: 'rotate(-3deg)' },
                            '50%':      { transform: 'rotate(3deg)' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts: Nunito (Bulat & Ramah Anak) -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Nunito', sans-serif; }

        /* ── Scrollbar Styling ── */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f0f4ff; }
        ::-webkit-scrollbar-thumb { background: #3B9EE8; border-radius: 10px; }

        /* ── Hero Background ── */
        .hero-bg {
            background: linear-gradient(160deg, #EEF6FF 0%, #FFF8ED 50%, #F0FFF4 100%);
            position: relative;
        }
        .hero-bg::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background-image: radial-gradient(circle at 20% 50%, rgba(59,158,232,0.07) 0%, transparent 50%),
                              radial-gradient(circle at 80% 20%, rgba(245,166,35,0.1) 0%, transparent 40%),
                              radial-gradient(circle at 60% 90%, rgba(39,174,96,0.06) 0%, transparent 40%);
        }

        /* ── Wave Divider ── */
        .wave-divider {
            overflow: hidden;
            line-height: 0;
        }
        .wave-divider svg {
            display: block;
            width: 100%;
        }

        /* ── Navbar Glow ── */
        .navbar-glow {
            box-shadow: 0 4px 20px rgba(29, 111, 204, 0.25);
        }

        /* ── Book Card ── */
        .book-card {
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .book-card:hover {
            transform: translateY(-10px) scale(1.02);
        }

        /* ── Fun Star Rating ── */
        .star { color: #F5A623; }

        /* ── Badge pulse ── */
        @keyframes pulseBadge {
            0%, 100% { box-shadow: 0 0 0 0 rgba(245,166,35,0.6); }
            50%       { box-shadow: 0 0 0 8px rgba(245,166,35,0); }
        }
        .badge-pulse { animation: pulseBadge 2s infinite; }

        /* ── Section Background Alt ── */
        .section-alt { background: linear-gradient(to bottom, #F0F7FF, #EEF6FF); }

        /* ── Category Pill ── */
        .cat-pill {
            transition: all 0.2s;
        }
        .cat-pill:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        }
    </style>
</head>
<body class="bg-white text-gray-800">

{{-- ═══════════════════════════════════════════
    NAVBAR
══════════════════════════════════════════════ --}}
<nav class="bg-brand-blue navbar-glow sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-6 lg:px-10 h-20 flex items-center justify-between">

        {{-- Logo Balai Bahasa --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 flex-shrink-0">
            <img src="{{ asset('img/logo/logobalai.png') }}" alt="Logo Balai Bahasa Provinsi Riau"
                 class="h-12 w-auto object-contain"
                 style="filter: drop-shadow(0 2px 8px rgba(0,0,0,0.35)) drop-shadow(0 0 12px rgba(255,255,255,0.25));"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            {{-- Fallback jika gambar tidak ada --}}
            <div style="display:none" class="bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-xl flex items-center gap-2">
                <span class="text-white font-black text-lg tracking-tight">SEMBARI</span>
            </div>
        </a>

        {{-- Menu Desktop --}}
        <div class="hidden md:flex items-center gap-2 font-bold text-sm text-white/90">
            <a href="{{ route('home') }}" class="text-white bg-white/15 px-4 py-2 rounded-full flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Beranda
            </a>
            <a href="#koleksi" class="hover:text-white hover:bg-white/10 px-4 py-2 rounded-full transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Buku
            </a>
            <a href="#jenjang" class="hover:text-white hover:bg-white/10 px-4 py-2 rounded-full transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Jenjang
            </a>
            <a href="#kategori" class="hover:text-white hover:bg-white/10 px-4 py-2 rounded-full transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        {{-- Mobile Hamburger --}}
        <button class="md:hidden text-white p-2">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

    </div>
</nav>


{{-- ═══════════════════════════════════════════
    STATISTIK BAR
══════════════════════════════════════════════ --}}
<div class="bg-brand-green text-white">
    <div class="max-w-6xl mx-auto px-6 lg:px-10 py-3.5 flex items-center justify-center divide-x divide-green-400/60">

        {{-- Stat: Total Buku --}}
        <div class="px-6 md:px-10 text-center flex items-center gap-3">
            <div class="hidden md:flex w-9 h-9 bg-white/20 rounded-xl items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <div id="stat-buku" class="text-2xl font-black" data-target="{{ $stats['buku'] ?? 0 }}">0</div>
                <div class="text-[10px] font-bold uppercase tracking-wider opacity-90">Buku Digital</div>
            </div>
        </div>

        {{-- Stat: Total Pembaca (SEMENTARA: hardcode 12.744, nanti ganti lagi setelah pembaca sudah banyak) --}}
        <div class="px-6 md:px-10 text-center hidden md:flex items-center gap-3">
            <div class="hidden md:flex w-9 h-9 bg-white/20 rounded-xl items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                {{-- Hardcode sementara: ganti ke stats asli setelah pembaca sudah banyak --}}
                <div id="stat-pembaca" class="text-2xl font-black" data-target="12744">0</div>
                {{-- <div id="stat-pembaca" class="text-2xl font-black" data-target="{{ $stats['pembaca'] ?? 0 }}">0</div> --}}
                <div class="text-[10px] font-bold uppercase tracking-wider opacity-90">Pembaca</div>
            </div>
        </div>

        {{-- Stat: Kategori --}}
        <div class="px-6 md:px-10 text-center flex items-center gap-3">
            <div class="hidden md:flex w-9 h-9 bg-white/20 rounded-xl items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div>
                <div id="stat-kategori" class="text-2xl font-black" data-target="{{ $stats['kategori'] ?? 0 }}">0</div>
                <div class="text-[10px] font-bold uppercase tracking-wider opacity-90">Kategori</div>
            </div>
        </div>

    </div>
</div>


{{-- ═══════════════════════════════════════════
    HERO SECTION
══════════════════════════════════════════════ --}}
<header class="hero-bg pt-16 pb-0 overflow-hidden">
    <div class="max-w-6xl mx-auto px-6 lg:px-10 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-10 lg:gap-16">

            {{-- ── Teks Kiri ── --}}
            <div class="lg:w-1/2 text-center lg:text-left">
                <h1 class="text-4xl lg:text-5xl xl:text-6xl font-black leading-tight text-gray-900 mb-5">
                    Yuk, <span class="text-brand-blue relative inline-block">
                        Baca Buku
                        <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 200 10" fill="none">
                            <path d="M0 8 Q 50 0 100 6 Q 150 12 200 4" stroke="#F5A623" stroke-width="4" stroke-linecap="round" fill="none"/>
                        </svg>
                    </span> <br>
                    Bareng <span class="text-brand-green">Sembari!</span>
                </h1>

                <p class="text-gray-600 text-lg leading-relaxed mb-8 max-w-lg mx-auto lg:mx-0">
                    Platform membaca buku digital <strong>gratis</strong> untuk anak-anak Indonesia.
                    Temukan petualangan menakjubkan dari setiap lembar halaman, dari dongeng Riau hingga cerita fiksi — semua ada di sini!
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="#koleksi"
                       class="flex items-center justify-center gap-2.5 px-7 py-4
                              bg-brand-blue text-white font-black text-base rounded-2xl shadow-lg
                              hover:bg-blue-700 hover:shadow-blue-400/40 hover:-translate-y-1
                              transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Mulai Membaca
                    </a>
                    <a href="#kategori"
                       class="flex items-center justify-center gap-2.5 px-7 py-4
                              bg-brand-yellow text-white font-black text-base rounded-2xl shadow-md
                              hover:bg-yellow-500 hover:-translate-y-1
                              transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Jelajahi Buku
                    </a>
                </div>

                {{-- Trust Badges --}}
                <div class="mt-8 flex items-center gap-5 justify-center lg:justify-start text-sm text-gray-500 font-semibold">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Gratis 100%
                    </span>
                    <span class="text-gray-300">·</span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Tanpa Login
                    </span>
                    <span class="text-gray-300">·</span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Aman untuk Anak
                    </span>
                </div>
            </div>

            {{-- ── Ilustrasi Kanan ── --}}
            <div class="lg:w-1/2 relative flex justify-center items-center py-10 lg:py-0">
                <div class="relative w-full max-w-sm">

                    {{-- Gambar utama mengambang tanpa border card --}}
                    <img src="{{ asset('img/logo/sembari.png') }}"
                         alt="Logo Sembari"
                         class="relative z-10 w-full h-auto object-contain animate-float"
                         style="filter: drop-shadow(0 20px 40px rgba(11,102,205,0.2)) drop-shadow(0 8px 16px rgba(0,0,0,0.1));">

                    {{-- Dekorasi: Lingkaran blur biru besar di belakang --}}
                    <div class="absolute inset-0 -z-10 flex items-center justify-center">
                        <div class="w-72 h-72 bg-blue-200/40 rounded-full blur-3xl"></div>
                    </div>

                    {{-- Floating chip: Total Buku --}}
                    <div class="absolute top-0 -right-4 z-20
                                bg-white text-brand-blue rounded-2xl px-4 py-2
                                shadow-lg font-black text-sm
                                flex items-center gap-2
                                animate-float" style="animation-delay: 0.5s;">
                        <div class="w-8 h-8 bg-brand-blue/10 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400 font-bold leading-none mb-0.5">Total Buku</div>
                            <div class="text-brand-green font-black text-base leading-none">99+</div>
                            <!-- <div class="text-brand-green font-black text-base leading-none">{{ $stats['buku'] ?? 0 }}+</div> -->
                        </div>
                    </div>

                    {{-- Floating dot dekorasi --}}
                    <div class="absolute -top-6 left-8 w-5 h-5 bg-brand-yellow rounded-full opacity-70 animate-float" style="animation-delay: 0.3s;"></div>
                    <div class="absolute top-1/3 -right-8 w-3 h-3 bg-brand-green rounded-full opacity-60 animate-float" style="animation-delay: 0.8s;"></div>
                    <div class="absolute bottom-1/4 right-4 w-4 h-4 bg-purple-400 rounded-full opacity-50 animate-float" style="animation-delay: 1.5s;"></div>

                </div>
            </div>
        </div>
    </div>

    {{-- Wave Divider --}}
    <div class="wave-divider mt-12">
        <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z" fill="#F8FAFF"/>
        </svg>
    </div>
</header>

{{-- ── Count-Up Animation Script ── --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Semua elemen dengan data-target akan dianimasikan dari 0 ke angka target
    const counters = document.querySelectorAll('[data-target]');

    const animateCount = (el) => {
        const target = parseInt(el.getAttribute('data-target'), 10);
        if (!target || target === 0) { el.textContent = '0'; return; }

        const duration = 1800; // ms
        const stepTime  = 16;  // ~60fps
        const steps     = Math.ceil(duration / stepTime);
        let   current   = 0;
        let   step      = 0;

        const timer = setInterval(() => {
            step++;
            // Easing: fast start, slow end
            const progress = 1 - Math.pow(1 - step / steps, 3);
            current = Math.round(target * progress);

            // Format: angka > 999 pakai titik (1.744)
            el.textContent = current.toLocaleString('id-ID');

            if (step >= steps) {
                el.textContent = target.toLocaleString('id-ID');
                clearInterval(timer);
            }
        }, stepTime);
    };

    // Gunakan IntersectionObserver agar animasi hanya jalan saat stat bar terlihat
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCount(entry.target);
                observer.unobserve(entry.target); // hanya sekali
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(el => observer.observe(el));
});
</script>


{{-- ═══════════════════════════════════════════
    SECTION: EDISI TERBATAS & TERBARU
══════════════════════════════════════════════ --}}
<section id="koleksi" class="bg-[#F8FAFF] py-16">
    <div class="max-w-6xl mx-auto px-6 lg:px-10">

        {{-- Section Header --}}
        <div class="text-center mb-10">
            <span class="inline-block bg-red-100 text-red-600 text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-widest mb-3">
                🔥 Spesial & Terbaru
            </span>
            <h2 class="text-3xl font-black text-gray-900">Edisi Terbatas & Buku Baru</h2>
            <p class="text-gray-500 mt-2">Koleksi terhangat yang baru saja hadir!</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5 lg:gap-7">
            @forelse($terbatas->merge($terbaru)->unique('id')->take(8) as $book)
            <div class="book-card group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                {{-- Cover --}}
                <div class="relative aspect-[5/7] bg-gradient-to-br from-blue-50 to-purple-50 overflow-hidden">
                    {{-- Label Badge --}}
                    @if($book->license == 'Buku Edisi Terbatas')
                        <div class="absolute top-2.5 left-2.5 bg-red-500 text-white text-[9px] font-black px-2 py-1 rounded-lg shadow z-10 flex items-center gap-1">
                            ⭐ TERBATAS
                        </div>
                    @else
                        <div class="absolute top-2.5 left-2.5 bg-brand-green text-white text-[9px] font-black px-2 py-1 rounded-lg shadow z-10 flex items-center gap-1">
                            🆕 BARU
                        </div>
                    @endif

                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                             alt="{{ $book->title }}">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 gap-2">
                            <span class="text-5xl">📖</span>
                            <span class="text-xs text-gray-400 font-semibold">Tanpa Cover</span>
                        </div>
                    @endif

                    {{-- Hover Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent
                                opacity-0 group-hover:opacity-100 transition-opacity duration-300
                                flex items-end p-3">
                        <a href="{{ route('book.read', $book->slug ?? $book->id) }}"
                           class="w-full py-2.5 bg-brand-yellow text-white font-black text-xs rounded-xl text-center
                                  shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                            📖 Baca Sekarang
                        </a>
                    </div>
                </div>

                {{-- Info --}}
                <div class="p-3.5 flex-1 flex flex-col">
                    <h3 class="font-black text-gray-900 text-sm leading-snug line-clamp-2 mb-1" title="{{ $book->title }}">
                        {{ $book->title }}
                    </h3>
                    <p class="text-[11px] text-gray-400 font-semibold">
                        {{ $book->readingLevel->name ?? 'Semua Umur' }}
                    </p>

                    <div class="mt-auto pt-2.5 border-t border-gray-50 flex items-center justify-between mt-3">
                        <span class="flex items-center gap-1 text-[11px] text-gray-400 font-semibold">
                            👁 {{ $book->stat->views_count ?? '0' }}
                        </span>
                        <span class="bg-blue-50 text-brand-blue text-[10px] font-black px-2 py-0.5 rounded-lg">PDF</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center py-16">
                <p class="text-5xl mb-3">📭</p>
                <p class="text-gray-400 font-bold">Belum ada buku yang tersedia</p>
            </div>
            @endforelse
        </div>

    </div>
</section>


{{-- ═══════════════════════════════════════════
    SECTION: JENJANG PEMBACA
══════════════════════════════════════════════ --}}
<section id="jenjang" class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6 lg:px-10">

        <div class="text-center mb-10">
            <span class="inline-block bg-purple-100 text-purple-600 text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-widest mb-3">
                🎯 Sesuai Kemampuan
            </span>
            <h2 class="text-3xl font-black text-gray-900">Jenjang Pembaca</h2>
            <p class="text-gray-500 mt-2">Buku yang pas untuk tingkat kemampuan membacamu!</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
                $levelColors = [
                    'bg-red-400', 'bg-orange-400', 'bg-yellow-400',
                    'bg-green-400', 'bg-blue-400', 'bg-purple-400',
                ];
                $levelEmoji = ['🐣', '🐥', '🐤', '🦅', '🦁', '🌟'];
            @endphp

            @forelse($jenjang as $index => $level)
            <a href="#" class="cat-pill group flex flex-col items-center bg-white border-2 border-gray-100
                               rounded-2xl p-5 text-center hover:border-brand-blue hover:bg-blue-50 transition-all">
                <div class="w-14 h-14 {{ $levelColors[$index % count($levelColors)] }} text-white rounded-2xl
                            flex items-center justify-center text-2xl mb-3 shadow-md
                            group-hover:scale-110 transition-transform">
                    {{ $levelEmoji[$index % count($levelEmoji)] }}
                </div>
                <h4 class="font-black text-gray-800 text-sm leading-tight">{{ $level->name }}</h4>
            </a>
            @empty
            <div class="col-span-6 text-center py-8">
                <p class="text-gray-400">Belum ada jenjang terdaftar</p>
            </div>
            @endforelse
        </div>

    </div>
</section>


{{-- ═══════════════════════════════════════════
    DIVIDER WAVE
══════════════════════════════════════════════ --}}
<div class="wave-divider">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,25 C360,50 1080,0 1440,25 L1440,50 L0,50 Z" fill="#EEF6FF"/>
    </svg>
</div>


{{-- ═══════════════════════════════════════════
    SECTION: TERPOPULER
══════════════════════════════════════════════ --}}
<section class="bg-[#EEF6FF] py-16">
    <div class="max-w-6xl mx-auto px-6 lg:px-10">

        <div class="flex items-center justify-between mb-10">
            <div>
                <span class="inline-block bg-yellow-100 text-yellow-600 text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-widest mb-2">
                    ⭐ Paling Disukai
                </span>
                <h2 class="text-3xl font-black text-gray-900">Paling Sering Dibaca</h2>
            </div>
            <a href="#" class="hidden md:flex items-center gap-1 text-brand-blue font-black text-sm
                               hover:underline">Lihat Semua →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($terpopuler->take(6) as $popular)
            <div class="flex bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden
                        hover:shadow-md hover:-translate-y-1 transition-all duration-200 group">
                {{-- Book Thumb --}}
                <div class="w-28 h-36 flex-shrink-0 overflow-hidden">
                    @if($popular->cover_image)
                        <img src="{{ asset('storage/' . $popular->cover_image) }}"
                             class="w-full h-full object-cover" alt="{{ $popular->title }}">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-100 to-purple-100
                                    flex items-center justify-center text-4xl">📖</div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="p-4 flex flex-col justify-between flex-1 min-w-0">
                    <div>
                        <span class="inline-block bg-blue-50 text-brand-blue text-[10px] font-black
                                     px-2 py-0.5 rounded uppercase tracking-wide mb-1.5">
                            Populer
                        </span>
                        <h4 class="font-black text-gray-900 text-sm leading-snug line-clamp-2
                                   group-hover:text-brand-blue transition mb-1">
                            {{ $popular->title }}
                        </h4>
                        <p class="text-[11px] text-gray-400 font-semibold">
                            {{ $popular->readingLevel->name ?? 'Semua Umur' }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between mt-3">
                        <div class="flex items-center gap-3 text-[11px] text-gray-400 font-bold">
                            <span>👁 {{ $popular->stat->views_count ?? 0 }}</span>
                            <span>❤️ {{ $popular->stat->likes_count ?? 0 }}</span>
                        </div>
                        <a href="{{ route('book.read', $popular->slug ?? $popular->id) }}"
                           class="text-xs font-black text-white bg-brand-blue px-3 py-1.5 rounded-xl
                                  hover:bg-blue-700 transition flex-shrink-0">
                            Baca →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>


{{-- ═══════════════════════════════════════════
    SECTION: KATEGORI
══════════════════════════════════════════════ --}}
<section id="kategori" class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6 lg:px-10">

        <div class="text-center mb-10">
            <span class="inline-block bg-green-100 text-green-600 text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-widest mb-3">
                🏷️ Semua Topik
            </span>
            <h2 class="text-3xl font-black text-gray-900">Jelajahi Kategori</h2>
            <p class="text-gray-500 mt-2">Temukan buku berdasarkan topik favoritmu!</p>
        </div>

        @php
            $catColors = [
                'bg-red-100 text-red-600 border-red-200 hover:bg-red-500',
                'bg-orange-100 text-orange-600 border-orange-200 hover:bg-orange-500',
                'bg-yellow-100 text-yellow-700 border-yellow-200 hover:bg-yellow-500',
                'bg-green-100 text-green-600 border-green-200 hover:bg-green-500',
                'bg-blue-100 text-blue-600 border-blue-200 hover:bg-blue-500',
                'bg-purple-100 text-purple-600 border-purple-200 hover:bg-purple-500',
                'bg-pink-100 text-pink-600 border-pink-200 hover:bg-pink-500',
            ];
            $catEmoji = ['📖', '🎨', '🔬', '🌍', '🎭', '🏆', '🎵', '🌿', '⚽', '🚀'];
        @endphp

        <div class="flex flex-wrap justify-center gap-3">
            @foreach($kategori as $index => $cat)
            @php $c = $catColors[$index % count($catColors)]; @endphp
            <a href="#"
               class="cat-pill flex items-center gap-2.5 px-5 py-3 rounded-2xl border-2 font-black text-sm
                      transition-all hover:text-white {{ $c }}">
                <span class="text-lg">{{ $catEmoji[$index % count($catEmoji)] }}</span>
                {{ $cat->name }}
                <span class="text-xs opacity-75 bg-black/10 px-2 py-0.5 rounded-full">
                    {{ $cat->books_count }}
                </span>
            </a>
            @endforeach
        </div>

    </div>
</section>


{{-- ═══════════════════════════════════════════
    CTA BANNER
══════════════════════════════════════════════ --}}
<section class="py-16 bg-gradient-to-r from-brand-blue to-blue-800 relative overflow-hidden">
    {{-- Decoration dots --}}
    <div class="absolute top-0 left-0 w-full h-full opacity-10"
         style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 28px 28px;"></div>
    
    <div class="max-w-3xl mx-auto px-6 lg:px-10 text-center relative z-10">
        <p class="text-5xl mb-4 animate-float inline-block">📚</p>
        <h2 class="text-3xl font-black text-white mb-4">
            Siap Mulai Membaca Bersama Sembari?
        </h2>
        <p class="text-blue-200 text-lg mb-8 font-semibold">
            Ribuan buku menunggumu! Gratis, mudah, dan menyenangkan.
        </p>
        <a href="#koleksi"
           class="inline-flex items-center gap-2 px-8 py-4 bg-brand-yellow text-white
                  font-black text-base rounded-2xl shadow-xl badge-pulse
                  hover:bg-yellow-400 hover:-translate-y-1 transition-all duration-200">
            🚀 Mulai Baca Sekarang!
        </a>
    </div>
</section>


{{-- ═══════════════════════════════════════════
    FOOTER
══════════════════════════════════════════════ --}}
<footer class="bg-gray-900 text-white pt-14 pb-8">
    <div class="max-w-6xl mx-auto px-6 lg:px-10">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-10 border-b border-gray-800">

            {{-- Brand --}}
            <div class="md:col-span-2">
                <div class="flex items-center gap-3 mb-5">
                    <img src="{{ asset('img/sembari.png') }}" alt="Sembari" class="h-12 w-auto object-contain brightness-0 invert"
                         onerror="this.style.display='none'">
                </div>
                <p class="text-gray-400 text-sm leading-relaxed font-semibold max-w-md">
                    Platform literasi digital dari <strong class="text-white">Balai Bahasa Provinsi Riau</strong>
                    untuk meningkatkan minat baca anak-anak Indonesia. Membaca itu seru!
                </p>
                <div class="flex items-center gap-3 mt-5">
                    <div class="w-9 h-9 bg-brand-blue rounded-xl flex items-center justify-center text-sm cursor-pointer hover:bg-blue-500 transition">🌐</div>
                    <div class="w-9 h-9 bg-brand-blue rounded-xl flex items-center justify-center text-sm cursor-pointer hover:bg-blue-500 transition">📘</div>
                    <div class="w-9 h-9 bg-brand-blue rounded-xl flex items-center justify-center text-sm cursor-pointer hover:bg-blue-500 transition">📸</div>
                </div>
            </div>

            {{-- Links --}}
            <div>
                <h4 class="font-black mb-4 text-white text-sm uppercase tracking-wider">Jelajah</h4>
                <ul class="space-y-2.5 text-sm text-gray-400 font-semibold">
                    <li><a href="{{ route('home') }}"         class="hover:text-brand-sky transition">🏠 Beranda</a></li>
                    <li><a href="#koleksi"                    class="hover:text-brand-sky transition">📚 Koleksi Buku</a></li>
                    <li><a href="#jenjang"                    class="hover:text-brand-sky transition">🎯 Jenjang Pembaca</a></li>
                    <li><a href="#kategori"                   class="hover:text-brand-sky transition">🏷️ Kategori</a></li>
                    <li><a href="{{ route('admin.login') }}"  class="hover:text-brand-sky transition">🔐 Admin Portal</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="font-black mb-4 text-white text-sm uppercase tracking-wider">Kontak</h4>
                <ul class="space-y-3 text-sm text-gray-400 font-semibold">
                    <li class="flex items-start gap-2.5">
                        <span>📍</span>
                        <span>Jl. Binawidya, Simpang Baru, Tampan, Pekanbaru, Riau 28293</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span>📧</span>
                        <span>info@balaibahasariau.id</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span>📞</span>
                        <span>(0761) 65930</span>
                    </li>
                </ul>
            </div>

        </div>

        <div class="pt-6 flex flex-col md:flex-row items-center justify-between gap-2
                    text-xs text-gray-500 font-semibold">
            <p>&copy; {{ date('Y') }} Sembari — Balai Bahasa Provinsi Riau. All rights reserved.</p>
            <p>Dikembangkan dengan ❤️ untuk Literasi Indonesia</p>
        </div>
    </div>
</footer>

</body>
</html>
