@extends('public.layout.app')

@section('title', 'Tentang Sembari — Perpustakaan Digital BBPR')

@section('description', 'Pelajari lebih lanjut tentang Sembari, platform membaca buku digital gratis dari Balai Bahasa Provinsi Riau untuk anak-anak Indonesia.')

@section('content')
{{-- ══ HERO SECTION ══ --}}
<div class="bg-gradient-to-br from-brand-blue via-blue-700 to-indigo-600 py-16 lg:py-24 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 24px 24px;"></div>
    
    <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
        <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-md border border-white/20 px-5 py-2 rounded-full mb-6">
            <span class="text-xl">✨</span>
            <span class="text-xs font-black uppercase tracking-widest text-white">Mengenal Lebih Dekat</span>
        </div>
        <h1 class="text-4xl lg:text-6xl font-black text-white mb-6 leading-tight">
            Tentang <span class="text-brand-yellow">Sembari</span>
        </h1>
        <p class="text-lg lg:text-xl text-blue-100 font-bold leading-relaxed max-w-2xl mx-auto">
            Platform literasi digital yang menghubungkan imajinasi anak-anak Indonesia dengan ribuan cerita bermutu.
        </p>
    </div>
    
    {{-- Decorative Elements --}}
    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-brand-yellow/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-brand-purple/20 rounded-full blur-3xl animate-pulse"></div>
</div>

<div class="bg-gray-50/50 py-20">
    <div class="max-w-6xl mx-auto px-6">
        
        {{-- ══ PENJELASAN APLIKASI ══ --}}
        <div class="grid lg:grid-columns-2 gap-16 items-center mb-32">
            <div class="relative">
                <div class="absolute inset-0 bg-brand-blue/5 rounded-[3rem] -rotate-3 scale-105"></div>
                <div class="relative bg-white p-8 lg:p-12 rounded-[3rem] shadow-xl border border-blue-50">
                    <h2 class="text-3xl font-black text-brand-navy mb-6 flex items-center gap-3">
                        <span class="p-3 bg-brand-blue/10 rounded-2xl text-2xl">📖</span>
                        Apa itu Sembari?
                    </h2>
                    <div class="space-y-4 text-gray-600 font-bold leading-relaxed">
                        <p>
                            <span class="text-brand-blue">Sembari</span> adalah akronim dari <span class="text-brand-navy">Sistem Edukasi Membaca Bersama Literasi Digital</span>, sebuah inovasi dari Balai Bahasa Provinsi Riau.
                        </p>
                        <p>
                            Kami percaya bahwa akses terhadap bacaan bermutu adalah hak setiap anak. Sembari hadir sebagai jembatan untuk mempermudah akses ke ribuan koleksi buku digital, mulai dari dongeng rakyat, ensiklopedia mini, hingga buku pelajaran interaktif.
                        </p>
                        <p>
                            Dengan teknologi Flipbook yang modern, kami menghadirkan pengalaman membaca digital yang senyata mungkin, memberikan sensasi membalik halaman layaknya buku fisik.
                        </p>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-start gap-5 hover:translate-x-2 transition-transform">
                    <div class="bg-brand-green/10 p-4 rounded-2xl text-2xl">🌱</div>
                    <div>
                        <h4 class="font-black text-brand-navy mb-1">Ramah Anak</h4>
                        <p class="text-xs font-bold text-gray-500">Konten dipilih secara ketat untuk mendidik dan menghibur anak usia sekolah.</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-start gap-5 hover:translate-x-2 transition-transform">
                    <div class="bg-brand-yellow/10 p-4 rounded-2xl text-2xl">🚀</div>
                    <div>
                        <h4 class="font-black text-brand-navy mb-1">Akses Tanpa Batas</h4>
                        <p class="text-xs font-bold text-gray-500">Dapat diakses kapan saja, di mana saja, melalui smartphone maupun komputer.</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-start gap-5 hover:translate-x-2 transition-transform">
                    <div class="bg-brand-purple/10 p-4 rounded-2xl text-2xl">💎</div>
                    <div>
                        <h4 class="font-black text-brand-navy mb-1">Gratis Selamanya</h4>
                        <p class="text-xs font-bold text-gray-500">Wujud dedikasi kami dalam mencerdaskan kehidupan bangsa melalui literasi.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ LANGKAH-LANGKAH (DEMO) ══ --}}
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-black text-brand-navy mb-4">Cara Membaca di Sembari</h2>
            <p class="text-gray-500 font-bold">Langkah mudah untuk memulai petualangan literasimu.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-20">
            {{-- Step 1 --}}
            <div class="text-center group">
                <div class="w-20 h-20 bg-white shadow-lg rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:-translate-y-2 transition-transform relative">
                    <span class="absolute -top-3 -right-3 w-8 h-8 bg-brand-blue text-white rounded-full flex items-center justify-center font-black text-xs shadow-lg">1</span>
                    <i class="bi bi-search text-3xl text-brand-blue"></i>
                </div>
                <h4 class="font-black text-brand-navy mb-2">Cari Buku</h4>
                <p class="text-xs font-bold text-gray-400">Jelajahi koleksi melalui fitur cari atau filter kategori.</p>
            </div>
            {{-- Step 2 --}}
            <div class="text-center group">
                <div class="w-20 h-20 bg-white shadow-lg rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:-translate-y-2 transition-transform relative">
                    <span class="absolute -top-3 -right-3 w-8 h-8 bg-brand-blue text-white rounded-full flex items-center justify-center font-black text-xs shadow-lg">2</span>
                    <i class="bi bi-mouse3 text-3xl text-brand-blue"></i>
                </div>
                <h4 class="font-black text-brand-navy mb-2">Pilih & Kilik</h4>
                <p class="text-xs font-bold text-gray-400">Klik buku yang menarik perhatianmu untuk detailnya.</p>
            </div>
            {{-- Step 3 --}}
            <div class="text-center group">
                <div class="w-20 h-20 bg-white shadow-lg rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:-translate-y-2 transition-transform relative">
                    <span class="absolute -top-3 -right-3 w-8 h-8 bg-brand-blue text-white rounded-full flex items-center justify-center font-black text-xs shadow-lg">3</span>
                    <i class="bi bi-book-half text-3xl text-brand-blue"></i>
                </div>
                <h4 class="font-black text-brand-navy mb-2">Baca Sekarang</h4>
                <p class="text-xs font-bold text-gray-400">Tekan tombol baca dan nikmati pengalaman Flipbook.</p>
            </div>
            {{-- Step 4 --}}
            <div class="text-center group">
                <div class="w-20 h-20 bg-white shadow-lg rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:-translate-y-2 transition-transform relative">
                    <span class="absolute -top-3 -right-3 w-8 h-8 bg-brand-blue text-white rounded-full flex items-center justify-center font-black text-xs shadow-lg">4</span>
                    <i class="bi bi-stars text-3xl text-brand-blue"></i>
                </div>
                <h4 class="font-black text-brand-navy mb-2">Berikan Like</h4>
                <p class="text-xs font-bold text-gray-400">Selesaikan bacaanmu dan beri apresiasi pada buku.</p>
            </div>
        </div>

        {{-- ══ CTA ══ --}}
        <div class="bg-brand-navy rounded-[3rem] p-10 lg:p-16 text-center text-white relative overflow-hidden shadow-2xl">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
            <h3 class="text-3xl font-black mb-6 relative z-10">Sudah Siap Membaca Hari Ini?</h3>
            <div class="flex flex-wrap justify-center gap-4 relative z-10">
                <a href="{{ route('book.list') }}" class="bg-brand-yellow text-brand-navy font-black px-8 py-4 rounded-2xl shadow-xl hover:-translate-y-1 transition-all">
                    Jelajahi Koleksi
                </a>
                <a href="{{ route('home') }}" class="bg-white/10 backdrop-blur-md text-white font-black px-8 py-4 rounded-2xl border border-white/20 hover:bg-white/20 transition-all">
                    Kembali ke Beranda
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
