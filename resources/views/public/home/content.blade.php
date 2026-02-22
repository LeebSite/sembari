{{-- CONTENT SECTIONS | Variabel: $terbatas, $terbaru, $jenjang, $terpopuler, $kategori --}}

{{-- ═══ EDISI TERBATAS & TERBARU ═══ --}}
<section id="koleksi" class="bg-[#F8FAFF] py-16">
    <div class="max-w-6xl mx-auto px-6 lg:px-10">
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
                <div class="relative aspect-[5/7] bg-gradient-to-br from-blue-50 to-purple-50 overflow-hidden">
                    @if($book->license == 'Buku Edisi Terbatas')
                        <div class="absolute top-2.5 left-2.5 bg-red-500 text-white text-[9px] font-black px-2 py-1 rounded-lg shadow z-10">⭐ TERBATAS</div>
                    @else
                        <div class="absolute top-2.5 left-2.5 bg-brand-green text-white text-[9px] font-black px-2 py-1 rounded-lg shadow z-10">🆕 BARU</div>
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

                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-3">
                        <a href="{{ route('book.read', $book->slug ?? $book->id) }}"
                           class="w-full py-2.5 bg-brand-yellow text-white font-black text-xs rounded-xl text-center shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                            📖 Baca Sekarang
                        </a>
                    </div>
                </div>

                <div class="p-3.5 flex-1 flex flex-col">
                    <h3 class="font-black text-gray-900 text-sm leading-snug line-clamp-2 mb-1" title="{{ $book->title }}">
                        {{ $book->title }}
                    </h3>
                    <p class="text-[11px] text-gray-400 font-semibold">{{ $book->readingLevel->name ?? 'Semua Umur' }}</p>
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


{{-- ═══ JENJANG PEMBACA ═══ --}}
<section id="jenjang" class="py-20 bg-white relative overflow-hidden">
    {{-- Decorative Background Elements --}}
    <div class="absolute top-0 left-0 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-50 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-50 rounded-full blur-3xl opacity-50 translate-x-1/3 translate-y-1/3"></div>

    <div class="max-w-6xl mx-auto px-6 lg:px-10 relative z-10">
        <div class="text-center mb-14">
            <span class="inline-block bg-brand-blue/10 text-brand-blue text-[11px] font-black px-4 py-1.5 rounded-full uppercase tracking-[0.2em] mb-4">
                🎯 Temukan Levelmu
            </span>
            <h2 class="text-4xl font-black text-gray-900 tracking-tight">Jenjang Pembaca</h2>
            <div class="w-16 h-1.5 bg-brand-yellow mx-auto mt-4 rounded-full"></div>
            <p class="text-gray-500 mt-5 text-lg max-w-2xl mx-auto leading-relaxed">
                Pilih koleksi buku yang paling pas dengan tingkat kemampuan membacamu untuk pengalaman literasi yang lebih seru!
            </p>
        </div>

        <div class="flex flex-nowrap gap-4 lg:gap-6 overflow-x-auto pb-8 pt-4 no-scrollbar custom-scroll">
            @forelse($jenjang as $index => $level)
            <a href="{{ route('book.list', ['jenjang' => $level->id]) }}" 
               class="flex-none w-[160px] lg:w-[190px] group relative bg-white rounded-[2rem] p-5 border border-gray-100 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_40px_-20px_rgba(7,98,201,0.2)] hover:border-brand-blue/30 transition-all duration-500 flex flex-col items-center text-center overflow-hidden">
                
                {{-- Decorative Circle on Hover --}}
                <div class="absolute top-0 right-0 w-24 h-24 bg-brand-yellow/5 rounded-full translate-x-12 -translate-y-12 group-hover:scale-[3] transition-transform duration-700 pointer-events-none"></div>

                <div class="relative mb-5">
                    <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center p-3 group-hover:bg-brand-gray transition-colors duration-500 shadow-inner overflow-hidden">
                        @if($level->icon)
                            <img src="{{ asset('storage/' . $level->icon) }}" 
                                 alt="{{ $level->name }}" 
                                 class="w-full h-full object-contain group-hover:brightness-0 group-hover:invert transition-all duration-500">
                        @else
                            <span class="text-3xl group-hover:scale-110 transition-transform duration-500">📖</span>
                        @endif
                    </div>
                    {{-- Small floating badge --}}
                    <div class="absolute -bottom-1 -right-1 bg-brand-yellow text-white text-[10px] font-black w-7 h-7 rounded-full flex items-center justify-center shadow-lg border-2 border-white">
                        {{ $level->order }}
                    </div>
                </div>

                <div class="relative flex-1">
                    <h4 class="font-black text-gray-900 text-base mb-1 group-hover:text-brand-blue transition-colors duration-300">
                        {{ $level->name }}
                    </h4>
                    <p class="text-gray-400 text-[14px] font-semibold line-clamp-1 mb-3">
                        {{ $level->description ?: 'Koleksi pembaca ' . $level->name }}
                    </p>
                    <span class="inline-flex items-center gap-1.5 text-brand-blue font-black text-[10px] uppercase tracking-wider group-hover:gap-3 transition-all duration-300">
                        Jelajahi <i class="bi bi-arrow-right"></i>
                    </span>
                </div>
            </a>
            @empty
            <div class="w-full py-12 text-center flex-none">
                <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-[2rem] p-10">
                    <p class="text-gray-400 font-bold">Belum ada jenjang pembaca terdaftar saat ini.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<style>
    .custom-scroll::-webkit-scrollbar {
        height: 6px;
    }
    .custom-scroll::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }
    .custom-scroll::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    @media (min-width: 1024px) {
        .custom-scroll {
            padding-left: 2px;
            padding-right: 2px;
        }
    }
</style>


{{-- ═══ WAVE ═══ --}}
<div class="wave-divider">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,25 C360,50 1080,0 1440,25 L1440,50 L0,50 Z" fill="#EEF6FF"/>
    </svg>
</div>


{{-- ═══ TERPOPULER ═══ --}}
<section class="bg-[#EEF6FF] py-16">
    <div class="max-w-6xl mx-auto px-6 lg:px-10">
        <div class="flex items-center justify-between mb-10">
            <div>
                <span class="inline-block bg-yellow-100 text-yellow-600 text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-widest mb-2">⭐ Paling Disukai</span>
                <h2 class="text-3xl font-black text-gray-900">Paling Sering Dibaca</h2>
            </div>
            <a href="{{ route('book.list', ['sort' => 'populer']) }}" class="hidden md:flex items-center gap-1 text-brand-blue font-black text-sm hover:underline">Lihat Semua →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($terpopuler->take(6) as $popular)
            <div class="flex bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-200 group">
                <div class="w-28 h-36 flex-shrink-0 overflow-hidden">
                    @if($popular->cover_image)
                        <img src="{{ asset('storage/' . $popular->cover_image) }}" class="w-full h-full object-cover" alt="{{ $popular->title }}">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center text-4xl">📖</div>
                    @endif
                </div>
                <div class="p-4 flex flex-col justify-between flex-1 min-w-0">
                    <div>
                        <span class="inline-block bg-blue-50 text-brand-blue text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-wide mb-1.5">Populer</span>
                        <h4 class="font-black text-gray-900 text-sm leading-snug line-clamp-2 group-hover:text-brand-blue transition mb-1">{{ $popular->title }}</h4>
                        <p class="text-[11px] text-gray-400 font-semibold">{{ $popular->readingLevel->name ?? 'Semua Umur' }}</p>
                    </div>
                    <div class="flex items-center justify-between mt-3">
                        <div class="flex items-center gap-3 text-[11px] text-gray-400 font-bold">
                            <span>👁 {{ $popular->stat->views_count ?? 0 }}</span>
                            <span>❤️ {{ $popular->stat->likes_count ?? 0 }}</span>
                        </div>
                        <a href="{{ route('book.read', $popular->slug ?? $popular->id) }}"
                           class="text-xs font-black text-white bg-brand-blue px-3 py-1.5 rounded-xl hover:bg-blue-700 transition flex-shrink-0">
                            Baca →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ═══ KATEGORI ═══ --}}
<section id="kategori" class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6 lg:px-10">
        <div class="text-center mb-10">
            <span class="inline-block bg-green-100 text-green-600 text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-widest mb-3">🏷️ Semua Topik</span>
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
            $catEmoji = ['📖','🎨','🔬','🌍','🎭','🏆','🎵','🌿','⚽','🚀'];
        @endphp

        <div class="flex flex-wrap justify-center gap-3">
            @foreach($kategori ?? [] as $index => $cat)
            @php $c = $catColors[$index % count($catColors)] ?? 'bg-blue-100 text-blue-600 border-blue-200 hover:bg-blue-500'; @endphp
            <a href="{{ route('book.list', ['kategori' => $cat->id]) }}" class="cat-pill flex items-center gap-2.5 px-5 py-3 rounded-2xl border-2 font-black text-sm transition-all hover:text-white {{ $c }}">
                <span class="text-lg">{{ $catEmoji[$index % count($catEmoji)] ?? '📖' }}</span>
                {{ $cat->name }}
                <span class="text-xs opacity-75 bg-black/10 px-2 py-0.5 rounded-full">{{ $cat->books_count }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>


{{-- ═══ CTA BANNER ═══ --}}
<section class="py-16 bg-gradient-to-r from-brand-blue to-blue-800 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 28px 28px;"></div>
    <div class="max-w-3xl mx-auto px-6 lg:px-10 text-center relative z-10">
        <p class="text-5xl mb-4 animate-float inline-block">📚</p>
        <h2 class="text-3xl font-black text-white mb-4">Siap Mulai Membaca Bersama Sembari?</h2>
        <p class="text-blue-200 text-lg mb-8 font-semibold">Ribuan buku menunggumu! Gratis, mudah, dan menyenangkan.</p>
        <a href="#koleksi" class="inline-flex items-center gap-2 px-8 py-4 bg-brand-yellow text-white font-black text-base rounded-2xl shadow-xl badge-pulse hover:bg-yellow-400 hover:-translate-y-1 transition-all duration-200">
            🚀 Mulai Baca Sekarang!
        </a>
    </div>
</section>
