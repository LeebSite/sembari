{{-- HERO SECTION | Variabel: $stats --}}
<header class="hero-bg pt-20 pb-4 overflow-hidden">
    <div class="max-w-6xl mx-auto px-6 lg:px-10 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">

            {{-- Teks Kiri --}}
            <div class="lg:w-1/2 text-center lg:text-left">
                <h1 class="text-4xl lg:text-5xl xl:text-[58px] font-black leading-[1.2] text-gray-900 mb-6">
                    Yuk, <span class="text-brand-blue relative inline-block">
                        Baca Buku
                        <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 200 10" fill="none">
                            <path d="M0 8 Q 50 0 100 6 Q 150 12 200 4" stroke="#F5A623" stroke-width="4" stroke-linecap="round" fill="none"/>
                        </svg>
                    </span><br>
                    Bareng <span class="text-brand-green">Sembari!</span>
                </h1>

                <p class="text-gray-500 text-base lg:text-lg leading-8 mb-10 max-w-md mx-auto lg:mx-0">
                    Platform membaca buku digital <strong class="text-gray-700">gratis</strong> untuk anak-anak Indonesia.
                    Dari dongeng Riau hingga cerita fiksi seru — semua ada di sini!
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="#koleksi" class="flex items-center justify-center gap-2.5 px-7 py-4 bg-brand-blue text-white font-black text-base rounded-2xl shadow-lg hover:bg-blue-700 hover:-translate-y-1 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Mulai Membaca
                    </a>
                    <a href="#kategori" class="flex items-center justify-center gap-2.5 px-7 py-4 bg-brand-yellow text-white font-black text-base rounded-2xl shadow-md hover:bg-yellow-500 hover:-translate-y-1 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Jelajahi Buku
                    </a>
                </div>

                {{-- Trust Badges --}}
                <div class="mt-10 flex flex-wrap items-center gap-4 justify-center lg:justify-start">
                    <span class="flex items-center gap-2 bg-green-50 text-green-700 text-sm font-bold px-4 py-2 rounded-full border border-green-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Gratis 100%
                    </span>
                    <span class="flex items-center gap-2 bg-blue-50 text-blue-700 text-sm font-bold px-4 py-2 rounded-full border border-blue-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Tanpa Login
                    </span>
                    <span class="flex items-center gap-2 bg-yellow-50 text-yellow-700 text-sm font-bold px-4 py-2 rounded-full border border-yellow-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Aman untuk Anak
                    </span>
                </div>
            </div>

            {{-- Ilustrasi Kanan --}}
            <div class="lg:w-1/2 relative flex justify-center items-center py-10 lg:py-0">
                <div class="relative w-full max-w-sm">
                    <img src="{{ asset('img/logo/sembari.png') }}" alt="Logo Sembari"
                         class="relative z-10 w-full h-auto object-contain animate-float"
                         style="filter: drop-shadow(0 24px 48px rgba(7,98,201,0.12)) drop-shadow(0 4px 12px rgba(7,98,201,0.08));">
                    <div class="absolute inset-0 -z-10 flex items-center justify-center">
                        <div class="w-72 h-72 bg-blue-200/40 rounded-full blur-3xl"></div>
                    </div>
                    {{-- Floating chip --}}
                    <div class="absolute top-0 -right-4 z-20 bg-white text-brand-blue rounded-2xl px-4 py-2 shadow-lg font-black text-sm border border-blue-50 flex items-center gap-2 animate-float" style="animation-delay: 0.5s;">
                        <div class="w-8 h-8 bg-brand-blue/10 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400 font-bold leading-none mb-0.5">Total Buku</div>
                            <div class="text-brand-green font-black text-base leading-none">99+</div>
                        </div>
                    </div>
                    {{-- Dekorasi dot --}}
                    <div class="absolute -top-6 left-8 w-5 h-5 bg-brand-yellow rounded-full opacity-70 animate-float" style="animation-delay:0.3s;"></div>
                    <div class="absolute top-1/3 -right-8 w-3 h-3 bg-brand-green rounded-full opacity-60 animate-float" style="animation-delay:0.8s;"></div>
                    <div class="absolute bottom-1/4 right-4 w-4 h-4 bg-purple-400 rounded-full opacity-50 animate-float" style="animation-delay:1.5s;"></div>
                </div>
            </div>

        </div>
    </div>
    <div class="wave-divider mt-12">
        <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z" fill="#F8FAFF"/>
        </svg>
    </div>
</header>
