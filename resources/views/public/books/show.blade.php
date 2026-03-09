@extends('public.layout.app')

@section('title', ($book->title ?? 'Detail Buku') . ' — Sembari')

@section('content')
@php
    // Parsing detail terstruktur (format "Key: Value" per baris)
    $details = [];
    if($book->detail) {
        $lines = explode("\n", str_replace("\r", "", $book->detail));
        foreach($lines as $line) {
            if(str_contains($line, ':')) {
                [$key, $value] = explode(':', $line, 2);
                $details[trim($key)] = trim($value);
            }
        }
    }
    // Helper: tampilkan nilai atau em-dash
    $d = fn($key) => (!empty($details[$key]) && $details[$key] !== '-') ? $details[$key] : '—';
@endphp

<section class="bg-white pt-4 lg:pt-6 pb-16 min-h-screen relative overflow-hidden">
    {{-- Decorative BG --}}
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50/40 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/2 -z-10"></div>
    <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-yellow-50/40 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/2 -z-10"></div>

    <div class="max-w-5xl mx-auto px-6 lg:px-10">

        {{-- Breadcrumb --}}
        <div class="mb-6 flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
            <a href="{{ route('home') }}" class="hover:text-brand-blue transition-colors">Beranda</a>
            <i class="bi bi-chevron-right text-[8px]"></i>
            <a href="{{ route('book.list') }}" class="hover:text-brand-blue transition-colors">Koleksi</a>
            <i class="bi bi-chevron-right text-[8px]"></i>
            <span class="text-brand-blue truncate max-w-[180px]">{{ $book->title }}</span>
        </div>

        {{-- ══ MAIN LAYOUT ══ --}}
        <div class="flex flex-col lg:flex-row gap-10 lg:gap-14 items-start">

            {{-- ══ LEFT: Cover + Actions ══ --}}
            <div class="w-full max-w-[220px] mx-auto lg:mx-0 lg:w-[260px] flex-shrink-0 animate-fadeInLeft">

                {{-- Cover --}}
                <div class="relative group">
                    <div class="rounded-2xl overflow-hidden shadow-[0_24px_48px_-12px_rgba(0,0,0,0.14)] border-[5px] border-white ring-1 ring-gray-100 transform group-hover:-rotate-1 transition-transform duration-700 bg-gray-50">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                 class="w-full h-auto block"
                                 alt="{{ $book->title }}">
                        @else
                            <div class="aspect-[3/4.2] w-full bg-gradient-to-br from-blue-50 to-purple-50 flex flex-col items-center justify-center gap-4">
                                <i class="bi bi-book text-5xl text-gray-200"></i>
                                <span class="text-gray-300 font-black text-[9px] uppercase tracking-widest">No Cover</span>
                            </div>
                        @endif
                    </div>
                    {{-- Lisensi badge --}}
                    @if($book->license === 'Buku Edisi Terbatas')
                        <div class="absolute top-3 left-3 bg-red-500 text-white text-[9px] font-black px-2.5 py-1 rounded-lg shadow-lg">⭐ TERBATAS</div>
                    @endif
                </div>

                {{-- Stats Bar --}}
                <div class="flex items-center justify-between mt-5 p-3.5 bg-white rounded-2xl shadow-[0_8px_20px_-10px_rgba(0,0,0,0.06)] border border-gray-100">
                    {{-- Share --}}
                    <button onclick="copyToClipboard()" class="flex flex-col items-center gap-1.5 group flex-1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-50 group-hover:bg-blue-50 transition-colors">
                            <i class="bi bi-share text-[11px] text-gray-400 group-hover:text-brand-blue transition-colors"></i>
                        </div>
                        <span class="text-[7px] font-black text-gray-400 uppercase tracking-widest group-hover:text-brand-blue transition-colors">Bagikan</span>
                    </button>
                    <div class="h-8 w-px bg-gray-100"></div>
                    {{-- Dibaca --}}
                    <div class="flex flex-col items-center gap-1.5 flex-1 text-center border-x border-gray-100 px-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-50">
                            <i class="bi bi-book-half text-[12px] text-gray-400"></i>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="text-sm font-black text-gray-800 leading-none">{{ number_format($book->stat->reads_count ?? 0) }}</span>
                            <span class="text-[7px] font-black text-gray-400 uppercase tracking-widest">Dibaca</span>
                        </div>
                    </div>
                    <div class="h-8 w-px bg-gray-100"></div>
                    {{-- Disukai --}}
                    <div class="flex flex-col items-center gap-1.5 flex-1 text-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-50">
                            <i class="bi bi-heart-fill text-[11px] text-red-400"></i>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="text-sm font-black text-gray-800 leading-none">{{ number_format($book->stat->likes_count ?? 0) }}</span>
                            <span class="text-[7px] font-black text-gray-400 uppercase tracking-widest">Disukai</span>
                        </div>
                    </div>
                </div>

                {{-- CTA Read --}}
                <a href="{{ route('book.read', $book->slug ?? $book->id) }}"
                   class="mt-4 flex items-center justify-center gap-2.5 w-full py-3.5 bg-brand-blue text-white rounded-xl font-black text-sm shadow-[0_10px_20px_-10px_rgba(7,102,210,0.35)] hover:shadow-[0_14px_28px_-10px_rgba(7,102,210,0.45)] hover:-translate-y-0.5 active:scale-95 transition-all duration-300">
                    <i class="bi bi-book-half text-base"></i>
                    Baca Sekarang
                </a>


            </div>

            {{-- ══ RIGHT: Info ══ --}}
            <div class="flex-1 animate-fadeInRight w-full">
                <h1 class="text-2xl lg:text-3xl font-black text-gray-900 leading-tight mb-2 tracking-tight">
                    {{ $book->title }}
                </h1>

                {{-- Kategori chips di bawah judul --}}
                <div class="flex flex-wrap gap-1.5 mb-6">
                    @if($book->readingLevel)
                        <span class="inline-flex items-center gap-1 text-[10px] font-black text-purple-600 bg-purple-50 border border-purple-100 px-2.5 py-1 rounded-full">
                            <i class="bi bi-bullseye text-[9px]"></i> {{ $book->readingLevel->name }}
                        </span>
                    @endif
                    @if($book->daerah)
                        <span class="inline-flex items-center gap-1 text-[10px] font-black text-blue-600 bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-full">
                            <i class="bi bi-geo-alt-fill text-[9px]"></i> {{ $book->daerah->name }}
                        </span>
                    @endif
                    @foreach($book->categories->take(3) as $cat)
                        <span class="inline-flex items-center gap-1 text-[10px] font-black text-gray-500 bg-gray-50 border border-gray-100 px-2.5 py-1 rounded-full">
                            #{{ $cat->name }}
                        </span>
                    @endforeach
                    @if($book->license === 'Buku Edisi Terbatas')
                        <span class="inline-flex items-center gap-1 text-[10px] font-black text-red-600 bg-red-50 border border-red-100 px-2.5 py-1 rounded-full">
                            ⭐ Terbatas
                        </span>
                    @endif
                </div>

                {{-- ── DETAIL CARD ── --}}
                <div class="bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden mb-7">
                    <div class="px-5 py-3.5 bg-white border-b border-gray-100 flex items-center gap-2">
                        <i class="bi bi-person-lines-fill text-brand-blue"></i>
                        <span class="text-xs font-black text-gray-700 uppercase tracking-wider">Informasi Buku</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-gray-100">

                        {{-- Kolom Kiri --}}
                        <div class="divide-y divide-gray-100">
                            @foreach([
                                ['icon'=>'bi-pencil-fill','label'=>'Penulis','value'=>$d('Penulis')],
                                ['icon'=>'bi-translate','label'=>'Penerjemah','value'=>$d('Penerjemah')],
                                ['icon'=>'bi-pencil-square','label'=>'Penyunting','value'=>$d('Penyunting')],
                                ['icon'=>'bi-palette-fill','label'=>'Ilustrator','value'=>$d('Ilustrator')],
                            ] as $field)
                            <div class="flex items-start gap-3 px-5 py-3.5">
                                <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="bi {{ $field['icon'] }} text-brand-blue text-[11px]"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-0.5">{{ $field['label'] }}</p>
                                    <p class="text-gray-800 font-bold text-sm leading-snug break-words">{{ $field['value'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="divide-y divide-gray-100">
                            @foreach([
                                ['icon'=>'bi-search','label'=>'Penelaah','value'=>$d('Penelaah')],
                                ['icon'=>'bi-layout-text-sidebar','label'=>'Penata Letak','value'=>$d('Penata Letak')],
                                ['icon'=>'bi-upc-scan','label'=>'ISBN','value'=>$d('ISBN')],
                                ['icon'=>'bi-calendar3','label'=>'Tahun Terbit','value'=>$book->tahun_terbit ?? '—'],
                            ] as $field)
                            <div class="flex items-start gap-3 px-5 py-3.5">
                                <div class="w-7 h-7 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="bi {{ $field['icon'] }} text-emerald-600 text-[11px]"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-0.5">{{ $field['label'] }}</p>
                                    <p class="text-gray-800 font-bold text-sm leading-snug break-words">{{ $field['value'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                {{-- ── DESKRIPSI ── --}}
                @if($book->description)
                <div class="mb-7">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-3 flex items-center gap-2">
                        <i class="bi bi-text-left text-brand-blue"></i>
                        <span>Deskripsi / Sinopsis</span>
                    </p>
                    <div class="text-gray-600 leading-relaxed text-sm bg-gray-50 rounded-xl p-5 border border-gray-100">
                        {!! nl2br(e($book->description)) !!}
                    </div>
                </div>
                @endif

                {{-- ── TAXONOMI & TAGS ── --}}
                <div class="space-y-5">

                    {{-- Jenjang + Daerah side by side --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-2 flex items-center gap-2">
                                <i class="bi bi-award text-brand-blue"></i> Jenjang Pembaca
                            </p>
                            @if($book->readingLevel)
                                <div class="inline-flex items-center gap-2 bg-purple-50 text-purple-700 px-4 py-2 rounded-xl text-[11px] font-bold border border-purple-100">
                                    <i class="bi bi-bullseye text-purple-400"></i>
                                    {{ $book->readingLevel->name }}
                                </div>
                            @else
                                <span class="text-gray-400 italic font-semibold text-[11px]">Semua Umur</span>
                            @endif
                        </div>

                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-2 flex items-center gap-2">
                                <i class="bi bi-geo-alt-fill text-brand-blue"></i> Daerah Asal
                            </p>
                            @if($book->daerah)
                                <a href="{{ route('book.list', ['daerah' => $book->daerah->id]) }}"
                                   class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 px-4 py-2 rounded-xl text-[11px] font-bold border border-blue-100 hover:bg-blue-100 transition-colors">
                                    <i class="bi bi-pin-map-fill text-blue-500"></i>
                                    {{ $book->daerah->name }}, Riau
                                </a>
                            @else
                                <span class="text-gray-400 italic font-semibold text-[11px]">—</span>
                            @endif
                        </div>
                    </div>

                    {{-- Kategori --}}
                    @if($book->categories->count() > 0)
                    <div>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-2 flex items-center gap-2">
                            <i class="bi bi-tags text-brand-blue"></i> Kategori
                        </p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($book->categories as $category)
                                <span class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-[11px] font-bold text-gray-600">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Tag Lokal --}}
                    <div>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-2 flex items-center gap-2">
                            <i class="bi bi-hash text-brand-blue"></i> Tag
                        </p>
                        <div class="flex flex-wrap gap-x-3 gap-y-1.5">
                            <span class="text-brand-yellow font-black text-[11px] italic">#{{ str_replace(' ', '', $book->title) }}</span>
                            @if($d('Penulis') !== '—')
                                <span class="text-brand-yellow font-black text-[11px] italic">#{{ str_replace(' ', '', $d('Penulis')) }}</span>
                            @endif
                            @if($book->daerah)
                                <span class="text-brand-yellow font-black text-[11px] italic">#{{ str_replace(' ', '', $book->daerah->name) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
@keyframes fadeInLeft {
    from { opacity: 0; transform: translateX(-20px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes fadeInRight {
    from { opacity: 0; transform: translateX(20px); }
    to   { opacity: 1; transform: translateX(0); }
}
.animate-fadeInLeft  { animation: fadeInLeft  0.8s cubic-bezier(0.2, 0.8, 0.2, 1) both; }
.animate-fadeInRight { animation: fadeInRight 1s   cubic-bezier(0.2, 0.8, 0.2, 1) both; }
</style>

@push('scripts')
<script>
    function copyToClipboard() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link buku berhasil disalin!');
        });
    }
</script>
@endpush
@endsection
