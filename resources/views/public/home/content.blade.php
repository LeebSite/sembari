    {{-- CONTENT SECTIONS --}}
    @php
        /**
        * Ambil nama penulis dari field detail (format "Penulis: Nama")
        * Menggunakan Closure agar aman di-include berkali-kali.
        */
        $getPenulis = function($book) {
            if (!$book->detail) return null;
            $lines = explode("\n", str_replace("\r", "", $book->detail));
            foreach ($lines as $line) {
                if (str_contains($line, ':')) {
                    [$key, $value] = explode(':', $line, 2);
                    $k = trim($key);
                    if ($k === 'Penulis' || $k === 'Penyunting') return trim($value);
                }
            }
            return null;
        };
    @endphp

    {{-- ═══════════════════════════════════════
        1. KOLEKSI TERBARU
        ═══════════════════════════════════════ --}}
    <section id="terbaru" class="bg-white py-16 lg:py-20">
        <div class="max-w-6xl mx-auto px-6 lg:px-10">

            {{-- Section Header --}}
            <div class="flex items-end justify-between mb-10">
                <div>
                    <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-emerald-600 bg-emerald-50 border border-emerald-100 px-3 py-1 rounded-full uppercase tracking-widest mb-3">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                        Baru Ditambahkan
                    </span>
                    <h2 class="text-2xl lg:text-3xl font-black text-slate-800">Koleksi <em class="not-italic text-brand-blue">Terbaru</em></h2>
                </div>
                <a href="{{ route('book.list', ['sort' => 'terbaru']) }}"
                class="flex-shrink-0 flex items-center gap-2 text-sm font-bold text-brand-blue hover:text-blue-700 transition-colors">
                    Lainnya <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            {{-- Grid 5 columns --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($terbaru->take(5) as $book)
                @php $penulis = $getPenulis($book); @endphp
                <a href="{{ route('book.show', $book->slug ?? $book->id) }}"
                class="group flex flex-col rounded-2xl overflow-hidden border border-slate-100 bg-white hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                    {{-- Cover --}}
                    <div class="relative aspect-[3/4] overflow-hidden bg-slate-50">
                        <div class="absolute top-2.5 left-2.5 z-10">
                            <span class="text-[9px] font-black text-white bg-emerald-500 px-2.5 py-1 rounded-full shadow">BARU</span>
                        </div>
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                alt="{{ $book->title }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-3xl text-slate-300">
                                <i class="bi bi-book"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-slate-900/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="text-white text-xs font-black bg-brand-yellow px-4 py-2 rounded-xl shadow translate-y-2 group-hover:translate-y-0 transition-transform">Baca →</span>
                        </div>
                    </div>
                    {{-- Info --}}
                    <div class="p-3 flex-1 flex flex-col">
                        <span class="text-[9px] font-bold text-brand-blue uppercase tracking-wider mb-1">{{ $book->readingLevel->name ?? 'Umum' }}</span>
                        <h4 class="text-[13px] font-black text-slate-800 line-clamp-2 leading-tight flex-1">{{ $book->title }}</h4>
                        @if($penulis)
                        <p class="text-[10px] text-slate-400 mt-1.5 line-clamp-1 italic">{{ $penulis }}</p>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ═══════════════════════════════════════
        2. TERPOPULER
        ═══════════════════════════════════════ --}}
    <section id="terpopuler" class="py-16 lg:py-20 relative overflow-hidden" style="background: linear-gradient(135deg, #FF6B35 0%, #E84855 100%);">
        {{-- Decorative blobs --}}
        <div class="absolute -top-24 -right-24 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-black/10 rounded-full blur-3xl"></div>

        <div class="max-w-6xl mx-auto px-6 lg:px-10 relative z-10">

            {{-- Section Header --}}
            <div class="flex items-end justify-between mb-10">
                <div>
                    <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-orange-200 bg-white/10 border border-white/20 px-3 py-1 rounded-full uppercase tracking-widest mb-3">
                        <i class="bi bi-heart-fill text-red-300"></i> Paling Disukai
                    </span>
                    <h2 class="text-2xl lg:text-3xl font-black text-white"><em class="not-italic">Terpopuler</em></h2>
                </div>
                <a href="{{ route('book.list', ['sort' => 'populer']) }}"
                class="flex-shrink-0 flex items-center gap-2 text-sm font-black text-white bg-white/15 hover:bg-white/25 border border-white/20 px-5 py-2 rounded-full transition-all">
                    Lainnya <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            {{-- Grid 5 columns --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($terpopuler->take(5) as $book)
                <a href="{{ route('book.show', $book->slug ?? $book->id) }}"
                class="group flex flex-col rounded-2xl overflow-hidden bg-white hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                    {{-- Stats Row --}}
                    <div class="flex justify-between items-center px-3 py-2 bg-slate-50 border-b border-slate-100">
                        <span class="flex items-center gap-1 text-[10px] font-bold text-slate-500">
                            <i class="bi bi-eye text-slate-400"></i> {{ number_format($book->stat->views_count ?? 0) }}
                        </span>
                        <span class="flex items-center gap-1 text-[10px] font-bold text-rose-500">
                            <i class="bi bi-heart-fill"></i> {{ number_format($book->stat->likes_count ?? 0) }}
                        </span>
                    </div>
                    {{-- Cover --}}
                    <div class="relative aspect-square overflow-hidden bg-slate-100">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                alt="{{ $book->title }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-4xl text-slate-300">
                                <i class="bi bi-book"></i>
                            </div>
                        @endif
                    </div>
                    {{-- Info — flex-1 agar semua kartu sama tinggi --}}
                    <div class="p-3 flex flex-col items-center text-center flex-1">
                        {{-- Judul: tinggi tetap 2 baris agar tombol sejajar --}}
                        <h4 class="text-[12px] font-black text-slate-800 line-clamp-2 leading-tight mb-2.5"
                            style="min-height: 2.4em;">{{ $book->title }}</h4>
                        <span class="text-[9px] font-bold text-white bg-blue-500 px-3 py-1 rounded-full mb-3">
                            {{ $book->readingLevel->name ?? 'Pembaca' }}
                        </span>
                        {{-- mt-auto: tombol selalu di bawah --}}
                        <span class="mt-auto w-full text-center text-[11px] font-black text-white bg-[#4ea2f0] px-3 py-2 rounded-xl flex items-center justify-center gap-1.5 group-hover:bg-blue-600 transition-colors">
                            <i class="bi bi-book-half"></i> Baca
                        </span>
                    </div>
                </a>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ═══════════════════════════════════════
        3. JENJANG PEMBACA
        ═══════════════════════════════════════ --}}
    <section id="jenjang" class="py-20 lg:py-28 bg-white relative overflow-hidden">
        {{-- Subtle top accent --}}
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-rose-300 via-fuchsia-400 to-indigo-400"></div>
        {{-- Light background blob --}}
        <div class="absolute inset-0 bg-[#FAFAFA]"></div>

        <div class="max-w-6xl mx-auto px-6 lg:px-10 relative z-10">

            {{-- Section Header --}}
            <div class="text-center mb-14">
                <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-rose-500 bg-rose-50 px-3 py-1 rounded-full uppercase tracking-widest mb-4">
                    🎯 Temukan Levelmu
                </span>
                <h2 class="text-3xl lg:text-4xl font-black text-slate-800 mb-3">Jenjang Pembaca</h2>
                <p class="text-slate-400 text-base max-w-lg mx-auto leading-relaxed">
                    Pilih koleksi buku yang paling sesuai dengan tingkat kemampuan membacamu.
                </p>
            </div>

            {{-- Slider Wrapper --}}
            @php
                $levelColors = [
                    ['circle' => '#E4271B', 'icon_type' => 'star'],
                    ['circle' => '#7E57C2', 'icon_type' => 'circle'],
                    ['circle' => '#5E35B1', 'icon_type' => 'circle'],
                    ['circle' => '#3949AB', 'icon_type' => 'circle'],
                    ['circle' => '#1A237E', 'icon_type' => 'circle'],
                    ['circle' => '#2E7D32', 'icon_type' => 'triangle'],
                    ['circle' => '#F9A825', 'icon_type' => 'circle'],
                ];
            @endphp

            <div class="relative">
                {{-- Prev Button --}}
                <button id="jenjang-prev"
                        onclick="scrollJenjangSlider(-1)"
                        class="absolute -left-4 lg:-left-6 top-[4.5rem] z-20
                            w-11 h-11 rounded-full bg-white shadow-lg border border-slate-100
                            flex items-center justify-center text-slate-500
                            hover:bg-brand-blue hover:text-white hover:border-brand-blue
                            transition-all duration-200 opacity-40 pointer-events-none"
                        aria-label="Sebelumnya">
                    <i class="bi bi-chevron-left text-base font-black"></i>
                </button>

                {{-- Next Button --}}
                <button id="jenjang-next"
                        onclick="scrollJenjangSlider(1)"
                        class="absolute -right-4 lg:-right-6 top-[4.5rem] z-20
                            w-11 h-11 rounded-full bg-white shadow-lg border border-slate-100
                            flex items-center justify-center text-slate-500
                            hover:bg-brand-blue hover:text-white hover:border-brand-blue
                            transition-all duration-200"
                        aria-label="Selanjutnya">
                    <i class="bi bi-chevron-right text-base font-black"></i>
                </button>

                {{-- Slider Track --}}
                <div id="jenjang-slider"
                    class="flex flex-nowrap gap-8 lg:gap-12 overflow-x-auto no-scrollbar scroll-smooth px-2 pb-4 pt-5"
                    style="overflow-y: visible;">

                    @foreach($jenjang as $i => $level)
                    @php
                        $cols = $levelColors[$i % count($levelColors)];
                        $col  = $cols['circle'];
                    @endphp
                    <a href="{{ route('book.list', ['jenjang' => $level->id]) }}"
                    class="group flex-none flex flex-col items-center text-center w-28 lg:w-32 outline-none select-none">

                        {{-- Circle --}}
                        <div class="transition-transform duration-300 group-hover:-translate-y-2 mb-4
                                    group-hover:drop-shadow-[0_14px_22px_rgba(0,0,0,0.18)]">
                            @if($level->icon)
                                <div class="w-24 h-24 lg:w-28 lg:h-28 rounded-full overflow-hidden border-4 border-white shadow-xl"
                                    style="background-color: {{ $col }};">
                                    <img src="{{ asset('storage/' . $level->icon) }}"
                                        class="w-full h-full object-cover"
                                        alt="{{ $level->name }}">
                                </div>
                            @else
                                <div class="w-24 h-24 lg:w-28 lg:h-28 rounded-full border-4 border-white shadow-xl
                                            flex items-center justify-center relative"
                                    style="background: {{ $col }};">
                                    @if($i === 0)
                                        <svg viewBox="0 0 100 100" class="w-14 h-14 fill-white drop-shadow">
                                            <polygon points="50,5 61,35 95,35 68,57 79,91 50,70 21,91 32,57 5,35 39,35"/>
                                        </svg>
                                    @elseif($cols['icon_type'] === 'triangle')
                                        <svg viewBox="0 0 100 100" class="w-12 h-12 fill-white drop-shadow">
                                            <polygon points="50,10 90,85 10,85"/>
                                        </svg>
                                    @else
                                        <span class="text-white font-black text-3xl lg:text-4xl drop-shadow">
                                            {{ $level->name }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- Name --}}
                        <h4 class="font-black text-base lg:text-lg mb-1" style="color: {{ $col }};">
                            {{ $level->name }}
                        </h4>

                        {{-- Description --}}
                        @if($level->description)
                        <p class="text-[11px] text-slate-400 leading-relaxed line-clamp-2">
                            {{ $level->description }}
                        </p>
                        @endif

                    </a>
                    @endforeach

                </div>
            </div>

        </div>
    </section>

    <script>
        (function () {
            const slider = document.getElementById('jenjang-slider');
            const btnPrev = document.getElementById('jenjang-prev');
            const btnNext = document.getElementById('jenjang-next');
            if (!slider || !btnPrev || !btnNext) return;

            const STEP = 160; // px per scroll step

            function updateArrows() {
                const maxScroll = slider.scrollWidth - slider.clientWidth;
                btnPrev.classList.toggle('opacity-40', slider.scrollLeft <= 2);
                btnPrev.classList.toggle('pointer-events-none', slider.scrollLeft <= 2);
                btnNext.classList.toggle('opacity-40', slider.scrollLeft >= maxScroll - 2);
                btnNext.classList.toggle('pointer-events-none', slider.scrollLeft >= maxScroll - 2);
            }

            window.scrollJenjangSlider = function(dir) {
                slider.scrollBy({ left: dir * STEP, behavior: 'smooth' });
                setTimeout(updateArrows, 350);
            };

            slider.addEventListener('scroll', updateArrows);
            window.addEventListener('resize', updateArrows);
            // Initial state
            updateArrows();
        })();
    </script>

    {{-- ═══════════════════════════════════════
        4. EDISI TERBATAS
        ═══════════════════════════════════════ --}}
    <section id="eksklusif" class="py-16 lg:py-20 bg-slate-900 relative overflow-hidden">
        {{-- Subtle texture --}}
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(white 1px, transparent 1px); background-size: 28px 28px;"></div>
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-brand-yellow/50 to-transparent"></div>

        <div class="max-w-6xl mx-auto px-6 lg:px-10 relative z-10">

            {{-- Section Header --}}
            <div class="flex items-end justify-between mb-10">
                <div>
                    <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-amber-400 bg-amber-400/10 border border-amber-400/20 px-3 py-1 rounded-full uppercase tracking-widest mb-3">
                        <i class="bi bi-award-fill"></i> Edisi Eksklusif
                    </span>
                    <h2 class="text-2xl lg:text-3xl font-black text-white">Edisi <em class="not-italic text-amber-400">Terbatas</em></h2>
                </div>
                <a href="{{ route('book.list', ['lisensi' => 'terbatas']) }}"
                class="flex-shrink-0 flex items-center gap-2 text-sm font-black text-amber-400 border border-amber-400/30 hover:bg-amber-400/10 px-5 py-2 rounded-full transition-all">
                    Lainnya <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            {{-- Grid 5 columns --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @forelse($terbatas->take(5) as $book)
                <a href="{{ route('book.show', $book->slug ?? $book->id) }}"
                class="group flex flex-col rounded-2xl overflow-hidden border border-white/5 bg-white/5 hover:bg-white/10 hover:-translate-y-1.5 hover:border-amber-400/30 transition-all duration-300">
                    {{-- Cover --}}
                    <div class="relative aspect-[3/4] overflow-hidden">
                        <div class="absolute top-2.5 left-2.5 z-10">
                            <span class="text-[9px] font-black text-slate-900 bg-amber-400 px-2.5 py-1 rounded-full shadow">⭐ TERBATAS</span>
                        </div>
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                alt="{{ $book->title }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-3xl text-white/20 bg-white/5">
                                <i class="bi bi-book"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-amber-400/70 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="text-slate-900 text-xs font-black bg-white px-4 py-2 rounded-xl shadow translate-y-2 group-hover:translate-y-0 transition-transform">Lihat →</span>
                        </div>
                    </div>
                    {{-- Info --}}
                    <div class="p-3">
                        <h4 class="text-[12px] font-bold text-white/80 line-clamp-2 leading-tight text-center">{{ $book->title }}</h4>
                    </div>
                </a>
                @empty
                <div class="col-span-5 text-center py-16">
                    <i class="bi bi-inbox text-4xl text-white/20 block mb-3"></i>
                    <p class="text-white/40 font-bold">Belum ada edisi terbatas saat ini.</p>
                </div>
                @endforelse
            </div>

        </div>
    </section>

    {{-- ═══════════════════════════════════════
        5. CTA
        ═══════════════════════════════════════ --}}
    <section class="py-20 bg-gradient-to-br from-brand-blue via-blue-600 to-indigo-700 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 32px 32px;"></div>
        <div class="max-w-3xl mx-auto px-6 lg:px-10 text-center relative z-10">
            <div class="w-20 h-20 bg-white/15 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-xl">
                <i class="bi bi-book-half text-4xl text-white"></i>
            </div>
            <h2 class="text-3xl lg:text-4xl font-black text-white mb-4">Mulai Petualangan Literasimu!</h2>
            <p class="text-blue-100 text-lg mb-10 font-semibold">Ribuan cerita dari Balai Bahasa Provinsi Riau menantimu.<br> Gratis, interaktif, dan menyenangkan!</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('book.list') }}" class="inline-flex items-center gap-2.5 px-8 py-4 bg-brand-yellow text-white font-black text-base rounded-2xl shadow-xl hover:-translate-y-1 transition-transform">
                    <i class="bi bi-grid-3x3-gap-fill text-lg"></i> Jelajahi Koleksi
                </a>
                <a href="{{ route('help') }}" class="inline-flex items-center gap-2.5 px-8 py-4 bg-white/15 border border-white/20 text-white font-black text-base rounded-2xl hover:bg-white/25 transition-all">
                    <i class="bi bi-question-circle-fill text-lg"></i> Bantuan
                </a>
            </div>
        </div>
    </section>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
