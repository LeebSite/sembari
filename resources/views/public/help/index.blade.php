@extends('public.layout.app')

@section('title', 'Bantuan Sembari — Perpustakaan Digital BBPR')

@section('description', 'Pelajari lebih lanjut tentang Sembari, platform membaca buku digital gratis dari Balai Bahasa Provinsi Riau untuk anak-anak Indonesia.')

@push('styles')
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }
    @keyframes float-slow {
        0%, 100% { transform: translateY(0) rotate(0); }
        50% { transform: translateY(-15px) rotate(-5deg); }
    }
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    .animate-float-slow {
        animation: float-slow 8s ease-in-out infinite;
    }
</style>
@endpush

@section('content')
{{-- ══ HERO SECTION ══ --}}
<div class="bg-gradient-to-br from-[#1E40AF] via-[#2563EB] to-[#1D4ED8] py-20 lg:py-32 relative overflow-hidden">
    {{-- Floating Decorative Icons --}}
    <div class="absolute top-1/4 left-10 lg:left-20 animate-float opacity-50 pointer-events-none">
        <i class="bi bi-chat-dots-fill text-6xl text-white"></i>
    </div>
    <div class="absolute bottom-1/4 right-10 lg:right-24 animate-float-slow opacity-50 pointer-events-none">
        <i class="bi bi-question-circle-fill text-5xl text-brand-yellow2"></i>
    </div>
    <div class="absolute top-1/3 right-15 lg:right-40 animate-float opacity-50 pointer-events-none">
        <i class="bi bi-search text-7xl text-white"></i>
    </div>
    <div class="absolute bottom-10 left-1/4 animate-float-slow opacity-50 pointer-events-none">
        <i class="bi bi-envelope-fill text-4xl text-white"></i>
    </div>
    <div class="absolute top-10 right-1/4 animate-float opacity-50 pointer-events-none hidden lg:block">
        <i class="bi bi-book text-6xl text-brand-yellow2"></i>
    </div>

    <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
        <div class="inline-flex items-center gap-2 bg-white/5 backdrop-blur-sm border border-white/10 px-6 py-2 rounded-full mb-8">
            <span class="text-xs font-black uppercase tracking-[0.3em] text-blue-200">Layanan Pengguna</span>
        </div>
        <h1 class="text-5xl lg:text-7xl font-black text-white mb-6 leading-tight tracking-tight">
            Pusat <span class="text-brand-yellow">Bantuan</span>
        </h1>
        <p class="text-lg lg:text-xl text-blue-100/80 font-medium leading-relaxed max-w-2xl mx-auto">
            Butuh bantuan terkait layanan perpustakaan digital? Temukan panduan, solusi kendala teknis, dan informasi layanan dalam satu pintu.
        </p>
    </div>
</div>

<div class="bg-[#F8FAFF] pt-24 pb-0 -mt-10 rounded-t-[3rem] relative z-20">
    <div class="max-w-6xl mx-auto px-6">
        
        {{-- ══ PENJELASAN APLIKASI ══ --}}
        <div class="grid lg:grid-cols-12 gap-12 items-center mb-32">
            <div class="lg:col-span-7 relative">
                <div class="absolute inset-0 bg-brand-blue/5 rounded-[3rem] -rotate-2 scale-105"></div>
                <div class="relative bg-white p-10 lg:p-14 rounded-[3rem] shadow-xl border border-blue-50">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="p-4 bg-brand-blue/10 rounded-2xl text-3xl">
                            <i class="bi bi-journal-text text-brand-blue"></i>
                        </div>
                        <h2 class="text-3xl lg:text-4xl font-black text-brand-navy">Apa itu Sembari?</h2>
                    </div>
                    
                    <div class="space-y-6 text-gray-600 text-lg leading-relaxed font-medium">
                        <p>
                            <span class="text-brand-blue font-bold">Sembari</span> adalah akronim dari <span class="text-brand-navy font-bold">Sistem Edukasi Membaca Bersama Literasi Digital</span>, sebuah inovasi dari Balai Bahasa Provinsi Riau.
                        </p>
                        <p>
                            Sembari hadir sebagai jembatan untuk mempermudah akses ke ribuan koleksi buku digital, mulai dari dongeng rakyat, ensiklopedia mini, hingga buku pelajaran interaktif.
                        </p>
                        <p class="text-sm border-l-4 border-brand-yellow pl-5 py-1 italic text-gray-400">
                            Kami menghadirkan pengalaman membaca digital yang senyata mungkin dengan teknologi Flipbook.
                        </p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white p-7 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-md transition-all group">
                    <div class="bg-green-100 p-4 rounded-2xl text-2xl group-hover:scale-110 transition-transform">🌱</div>
                    <div>
                        <h4 class="font-black text-brand-navy mb-1 text-lg">Ramah Anak</h4>
                        <p class="text-sm font-medium text-gray-400">Konten edukatif untuk usia sekolah.</p>
                    </div>
                </div>
                <div class="bg-white p-7 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-md transition-all group">
                    <div class="bg-yellow-100 p-4 rounded-2xl text-2xl group-hover:scale-110 transition-transform">🚀</div>
                    <div>
                        <h4 class="font-black text-brand-navy mb-1 text-lg">Akses Tanpa Batas</h4>
                        <p class="text-sm font-medium text-gray-400">Baca kapan saja & di mana saja.</p>
                    </div>
                </div>
                <div class="bg-white p-7 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-md transition-all group">
                    <div class="bg-purple-100 p-4 rounded-2xl text-2xl group-hover:scale-110 transition-transform">💎</div>
                    <div>
                        <h4 class="font-black text-brand-navy mb-1 text-lg">Gratis Selamanya</h4>
                        <p class="text-sm font-medium text-gray-400">Dedikasi untuk literasi bangsa.</p>
                    </div>
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

        {{-- ══ DEVELOPER SECTION ══ --}}
        <div class="max-w-5xl mx-auto mt-32">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 bg-blue-50 text-brand-blue px-5 py-2 rounded-full mb-4">
                    <span class="animate-pulse">💻</span>
                    <span class="text-[11px] font-black uppercase tracking-[0.2em]">Tim Pengembang Sistem</span>
                </div>
                <h2 class="text-4xl lg:text-5xl font-black text-brand-navy tracking-tight">Penyusun <span class="text-brand-blue">Sistem</span></h2>
            </div>

            <div class="group relative">
                {{-- Decorative background element --}}
                <div class="absolute -inset-4 bg-gradient-to-tr from-brand-blue/5 to-transparent rounded-[4rem] -rotate-1 group-hover:rotate-0 transition-transform duration-500"></div>
                
                <div class="bg-white p-10 lg:p-16 rounded-[3.5rem] shadow-2xl shadow-blue-900/5 border border-blue-50 relative overflow-hidden flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                    {{-- Abstract Shapes --}}
                    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-blue/[0.02] rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-40 h-40 bg-brand-yellow2/[0.03] rounded-full translate-y-1/2 -translate-x-1/2"></div>

                    {{-- Image Side --}}
                    <div class="relative flex-shrink-0">
                        <div class="absolute inset-0 bg-brand-blue/10 rounded-[2.5rem] rotate-6 scale-95"></div>
                        <div class="w-48 h-48 lg:w-64 lg:h-64 bg-white rounded-[2.5rem] p-3 shadow-xl relative z-10">
                            <div class="w-full h-full rounded-[1.8rem] overflow-hidden border-2 border-blue-50">
                                <img src="{{ asset('img/developer_leeb.png') }}" 
                                     alt="Muhammad Ghalib Pradipa" 
                                     class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700"
                                     onerror="this.src='https://ui-avatars.com/api/?name=Muhammad+Ghalib+Pradipa&background=1E40AF&color=fff&size=400'">
                            </div>
                        </div>
                        {{-- Floating Tag --}}
                        <div class="absolute -bottom-4 -right-4 bg-brand-blue text-brand-white px-4 py-2 rounded-xl font-bold text-[10px] shadow-lg z-20 animate-float-slow">
                            MHS MAGANG
                        </div>
                    </div>
                    
                    {{-- Info Side --}}
                    <div class="flex-1 text-center lg:text-left relative z-10">
                        <h3 class="text-3xl lg:text-4xl font-black text-brand-navy mb-2 tracking-tight">MUHAMMAD GHALIB PRADIPA</h3>
                        <p class="text-brand-blue font-extrabold text-lg mb-8 flex items-center justify-center lg:justify-start gap-3">
                            <span class="w-10 h-1 bg-brand-yellow2 rounded-full hidden lg:block"></span>
                            Pengembang Sistem Utana
                        </p>
                        
                        <div class="grid sm:grid-cols-2 gap-6 mb-8 text-left">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                                    <i class="bi bi-building text-brand-blue"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">Institusi Kampus</p>
                                    <p class="text-sm font-bold text-gray-600">Univ. Sultan Syarif Kasim Riau</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-yellow-50 flex items-center justify-center flex-shrink-0">
                                    <i class="bi bi-code-slash text-brand-yellow2 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">Bidang Fokus</p>
                                    <p class="text-sm font-bold text-gray-600">Fullstack Web Developer</p>
                                </div>
                            </div>
                        </div>

                        <div class="relative bg-gray-50/50 p-6 rounded-3xl border border-gray-100/50">
                            <i class="bi bi-quote text-4xl text-brand-blue/10 absolute top-2 left-2"></i>
                            <p class="text-gray-500 font-medium leading-relaxed italic text-sm relative z-10 px-4">
                                "Mahasiswa Program Studi Teknik Informatika yang sedang melaksanakan Kerja Praktik di Balai Bahasa Provinsi Riau. Mengembangkan sistem ini untuk memfasilitasi akses bacaan digital bagi masyarakat, khususnya anak-anak, guna mendukung penguatan literasi di Provinsi Riau."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div> {{-- Close max-w-6xl --}}

    {{-- ══ FULL-WIDTH CTA SECTION ══ --}}
    <div class="relative mt-24">
        <div class="bg-gradient-to-br from-[#1E40AF] via-[#1D4ED8] to-[#1E3A8A] rounded-t-[4rem] rounded-b-none p-12 lg:p-20 text-center text-white relative overflow-hidden shadow-2xl">
            {{-- Decorative circles --}}
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-brand-yellow2/5 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 max-w-4xl mx-auto">
                <div class="inline-block p-4 bg-white/10 backdrop-blur-md rounded-3xl mb-8 animate-float">
                    <i class="bi bi-rocket-takeoff-fill text-4xl text-brand-yellow2"></i>
                </div>
                <h3 class="text-3xl lg:text-5xl font-black mb-6 leading-tight tracking-tight">
                    Mari Mulai <br> <span class="text-brand-yellow2">Membaca Bersama Kami!</span>
                </h3>
                <p class="text-blue-100/80 text-lg font-medium mb-12 max-w-2xl mx-auto leading-relaxed">
                    Setiap halaman adalah petualangan baru. Ribuan cerita bermutu menantimu di Sembari. Ayo, jelajahi koleksi kami sekarang!
                </p>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="{{ route('book.list') }}" class="group bg-brand-yellow2 text-brand-navy font-black px-10 py-4 rounded-2xl shadow-xl shadow-yellow-600/30 hover:scale-105 hover:-translate-y-1 transition-all flex items-center gap-3 text-base">
                        Jelajahi Koleksi
                        <i class="bi bi-arrow-right-circle-fill text-xl group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="{{ route('home') }}" class="group bg-white/10 backdrop-blur-md text-white font-black px-10 py-4 rounded-2xl border border-white/20 hover:bg-white/20 transition-all flex items-center gap-3 text-base">
                        <i class="bi bi-house-door-fill text-lg"></i>
                        Kembali Ke Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> {{-- Close bg-[#F8FAFF] --}}
@endsection
