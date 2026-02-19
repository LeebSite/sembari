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
<section id="jenjang" class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6 lg:px-10">
        <div class="text-center mb-10">
            <span class="inline-block bg-purple-100 text-purple-600 text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-widest mb-3">
                🎯 Sesuai Kemampuan
            </span>
            <h2 class="text-3xl font-black text-gray-900">Jenjang Pembaca</h2>
            <p class="text-gray-500 mt-2">Buku yang pas untuk tingkat kemampuan membacamu!</p>
        </div>

        @php
            $levelColors = ['bg-red-400','bg-orange-400','bg-yellow-400','bg-green-400','bg-blue-400','bg-purple-400'];
            $levelEmoji  = ['🐣','🐥','🐤','🦅','🦁','🌟'];
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @forelse($jenjang as $index => $level)
            <a href="#" class="cat-pill group flex flex-col items-center bg-white border-2 border-gray-100 rounded-2xl p-5 text-center hover:border-brand-blue hover:bg-blue-50 transition-all">
                <div class="w-14 h-14 {{ $levelColors[$index % count($levelColors)] }} text-white rounded-2xl flex items-center justify-center text-2xl mb-3 shadow-md group-hover:scale-110 transition-transform">
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
            <a href="#" class="hidden md:flex items-center gap-1 text-brand-blue font-black text-sm hover:underline">Lihat Semua →</a>
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
            @foreach($kategori as $index => $cat)
            @php $c = $catColors[$index % count($catColors)]; @endphp
            <a href="#" class="cat-pill flex items-center gap-2.5 px-5 py-3 rounded-2xl border-2 font-black text-sm transition-all hover:text-white {{ $c }}">
                <span class="text-lg">{{ $catEmoji[$index % count($catEmoji)] }}</span>
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
