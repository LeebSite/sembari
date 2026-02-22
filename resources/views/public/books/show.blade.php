@extends('public.layout.app')

@section('title', ($book->title ?? 'Detail Buku') . ' — Sembari')

@section('content')
@php
    // Parsing kontributor dari textarea (format Key: Value per baris)
    $contributors = [];
    if($book->contributors) {
        $lines = explode("\n", str_replace("\r", "", $book->contributors));
        foreach($lines as $line) {
            if(str_contains($line, ':')) {
                [$key, $value] = explode(':', $line, 2);
                $contributors[trim($key)] = trim($value);
            }
        }
    }
@endphp

<section class="bg-white pt-4 lg:pt-6 pb-12 min-h-screen relative overflow-hidden">
    {{-- Decorative Background --}}
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50/50 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/2 -z-10"></div>
    <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-yellow-50/50 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/2 -z-10"></div>

    <div class="max-w-4xl mx-auto px-6 lg:px-10">
        
        {{-- Breadcrumb Lite --}}
        <div class="mb-4 flex items-center justify-center lg:justify-start gap-2 text-[10px] lg:text-xs font-bold text-gray-400 uppercase tracking-widest">
            <a href="{{ route('home') }}" class="hover:text-brand-blue transition-colors">Beranda</a>
            <i class="bi bi-chevron-right text-[8px] lg:text-[10px]"></i>
            <a href="{{ route('book.list') }}" class="hover:text-brand-blue transition-colors">Koleksi</a>
            <i class="bi bi-chevron-right text-[8px] lg:text-[10px]"></i>
            <span class="text-brand-blue">Detail Buku</span>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-center lg:items-start">
            
            {{-- ══ LEFT COLUMN: Cover & Stats ══ --}}
            <div class="w-full max-w-[200px] sm:max-w-[240px] lg:w-[280px] lg:max-w-none flex-shrink-0 animate-fadeInLeft">
                <div class="relative group">
                    {{-- Elegant Cover shadow & border --}}
                    <div class="aspect-[3/4.2] rounded-[1.25rem] lg:rounded-[1.5rem] overflow-hidden shadow-[0_20px_40px_-12px_rgba(0,0,0,0.12)] border-[6px] border-white ring-1 ring-gray-100 transform group-hover:-rotate-1 transition-transform duration-700 bg-gray-50">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                 class="w-full h-full object-cover" 
                                 alt="{{ $book->title }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-50 to-purple-50 flex flex-col items-center justify-center gap-4">
                                <i class="bi bi-book text-5xl text-gray-200"></i>
                                <span class="text-gray-300 font-black text-[9px] uppercase tracking-widest">No Cover</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Interaction Bar (Icon above Count) --}}
                <div class="flex items-center justify-between mt-6 p-4 bg-white rounded-2xl shadow-[0_8px_20px_-10px_rgba(0,0,0,0.05)] border border-gray-100">
                    {{-- Share --}}
                    <button onclick="copyToClipboard()" class="flex flex-col items-center gap-1.5 group flex-1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-50 group-hover:bg-blue-50 transition-colors">
                            <i class="bi bi-share text-[11px] text-gray-400 group-hover:text-brand-blue transition-colors"></i>
                        </div>
                        <span class="text-[7px] font-black text-gray-400 uppercase tracking-widest group-hover:text-brand-blue transition-colors">Bagikan</span>
                    </button>

                    <div class="h-8 w-px bg-gray-100"></div>

                    {{-- Reads --}}
                    <div class="flex flex-col items-center gap-1.5 flex-1 text-center border-x border-gray-100 px-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-50">
                            <i class="bi bi-book-half text-[12px] text-gray-400"></i>
                        </div>
                        <div class="flex flex-col items-center gap-0">
                            <span class="text-sm font-black text-gray-800 leading-none">{{ number_format($book->stat->reads_count ?? 0) }}</span>
                            <span class="text-[7px] font-black text-gray-400 uppercase tracking-widest">Dibaca</span>
                        </div>
                    </div>

                    {{-- Like --}}
                    <button id="like-btn" data-id="{{ $book->id }}" onclick="toggleLike({{ $book->id }})" class="flex flex-col items-center gap-1.5 group flex-1">
                        <div id="like-icon-bg" class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-50 group-hover:bg-red-50 transition-colors">
                            <i id="like-icon" class="bi bi-heart text-[11px] text-gray-400 group-hover:text-red-500 transition-colors"></i>
                        </div>
                        <div class="flex flex-col items-center gap-0">
                            <span id="like-count" class="text-sm font-black text-gray-800 leading-none group-hover:text-red-500 transition-colors">{{ number_format($book->stat->likes_count ?? 0) }}</span>
                            <span class="text-[7px] font-black text-gray-400 uppercase tracking-widest group-hover:text-red-500 transition-colors">Disukai</span>
                        </div>
                    </button>
                </div>

                {{-- Action Button --}}
                <a href="{{ route('book.read', $book->slug ?? $book->id) }}" 
                   class="mt-6 flex items-center justify-center gap-2.5 w-full py-3.5 bg-brand-blue text-white rounded-xl font-black text-sm shadow-[0_10px_20px_-10px_rgba(7,102,210,0.3)] hover:shadow-[0_12px_24px_-10px_rgba(7,102,210,0.45)] hover:-translate-y-1 active:scale-95 transition-all duration-300">
                    <i class="bi bi-book-half text-base"></i>
                    Baca Sekarang
                </a>
            </div>

            {{-- ══ RIGHT COLUMN: Deep Info ══ --}}
            {{-- Aligned Left for all orientations --}}
            <div class="flex-1 lg:pt-1 animate-fadeInRight w-full text-left">
                <h1 class="text-2xl lg:text-3xl font-black text-gray-900 leading-tight mb-6 tracking-tight px-4 lg:px-0 mt-8 lg:mt-0">
                    {{ $book->title }}
                </h1>

                {{-- Metadata Grid --}}
                <div class="grid grid-cols-1 land-grid-cols-2 lg:grid-cols-2 gap-y-6 lg:gap-y-8 gap-x-10 mb-8 pb-8 border-b border-gray-100 px-4 lg:px-0">
                    <div class="metadata-item">
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-1.5">Penulis</p>
                        <p class="text-gray-800 font-bold text-base leading-tight">{{ $contributors['Penulis'] ?? '—' }}</p>
                    </div>
                    <div class="metadata-item">
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-1.5">Penerjemah</p>
                        <p class="text-gray-800 font-bold text-base leading-tight">{{ $contributors['Penerjemah'] ?? '—' }}</p>
                    </div>
                    <div class="metadata-item">
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-1.5">Ilustrator</p>
                        <p class="text-gray-800 font-bold text-base leading-tight">{{ $contributors['Ilustrator'] ?? '—' }}</p>
                    </div>
                    <div class="metadata-item">
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-1.5">Lisensi</p>
                        <p class="text-gray-800 font-bold text-base leading-tight">{{ $book->license ?? 'Buku Edisi Umum' }}</p>
                    </div>
                    <div class="metadata-item">
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-1.5">Tahun Terbit</p>
                        <p class="text-gray-800 font-bold text-base leading-tight">{{ $book->tahun_terbit ?? '—' }}</p>
                    </div>
                </div>

                {{-- Description Full --}}
                <div class="mb-8 px-4 lg:px-0">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-3 flex items-center justify-start gap-2">
                        <i class="bi bi-text-left text-brand-blue"></i> 
                        <span>Deskripsi</span>
                    </p>
                    <div class="text-gray-600 leading-relaxed text-sm max-w-2xl">
                        @if($book->description)
                            {!! nl2br(e($book->description)) !!}
                        @else
                            <p class="italic text-gray-400 text-xs">Deskripsi buku sedang disiapkan oleh pustakawan.</p>
                        @endif
                    </div>
                </div>

                {{-- Taxonomic Badges --}}
                <div class="space-y-6 px-4 lg:px-0">
                    <div class="grid grid-cols-1 land-grid-cols-2 lg:grid-cols-1 gap-6">
                        {{-- Jenjang --}}
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-3 flex items-center justify-start gap-2">
                                <i class="bi bi-award text-brand-blue"></i> 
                                <span>Jenjang Pembaca</span>
                            </p>
                            @if($book->readingLevel)
                                <div class="inline-flex items-center gap-2 bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-[11px] font-bold border border-gray-100">
                                    <i class="bi bi-bullseye text-brand-blue/60"></i>
                                    {{ $book->readingLevel->name }}
                                </div>
                            @else
                                <span class="text-gray-400 italic font-semibold text-[11px]">Semua Umur</span>
                            @endif
                        </div>

                        {{-- Categories --}}
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-3 flex items-center justify-start gap-2">
                                <i class="bi bi-tags text-brand-blue"></i> 
                                <span>Kategori</span>
                            </p>
                            <div class="flex flex-wrap justify-start gap-2">
                                @forelse($book->categories as $category)
                                    <span class="px-4 py-2 bg-white border border-gray-100 rounded-lg text-[11px] font-bold text-gray-600 cursor-default">
                                        {{ $category->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-400 italic font-semibold text-[11px]">Uncategorized</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Tags --}}
                    <div>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-3 flex items-center justify-start gap-2">
                            <i class="bi bi-hash text-brand-blue"></i> 
                            <span>Tag Lokal</span>
                        </p>
                        <div class="flex flex-wrap justify-start gap-x-4 gap-y-2">
                            <span class="text-brand-yellow font-black text-[11px] italic hover:underline cursor-pointer">#{{ str_replace(' ', '', $book->title) }}</span>
                            @if(isset($contributors['Penulis']))
                                <span class="text-brand-yellow font-black text-[11px] italic hover:underline cursor-pointer">#{{ str_replace(' ', '', $contributors['Penulis']) }}</span>
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
    to { opacity: 1; transform: translateX(0); }
}
@keyframes fadeInRight {
    from { opacity: 0; transform: translateX(20px); }
    to { opacity: 1; transform: translateX(0); }
}
.animate-fadeInLeft { animation: fadeInLeft 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) both; }
.animate-fadeInRight { animation: fadeInRight 1s cubic-bezier(0.2, 0.8, 0.2, 1) both; }

/* Custom Orientation & Mobile Landscape */
@media screen and (orientation: landscape) and (max-width: 991px) {
    .land-grid-cols-2 {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    }
}
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        checkLikeStatus({{ $book->id }});
    });

    function checkLikeStatus(bookId) {
        const likedBooks = JSON.parse(localStorage.getItem('liked_books') || '[]');
        const btn = document.getElementById('like-btn');
        const icon = document.getElementById('like-icon');
        const bg = document.getElementById('like-icon-bg');

        if (likedBooks.includes(bookId)) {
            icon.classList.remove('bi-heart', 'text-gray-400');
            icon.classList.add('bi-heart-fill', 'text-red-500');
            bg.classList.add('bg-red-50');
        }
    }

    async function toggleLike(bookId) {
        let likedBooks = JSON.parse(localStorage.getItem('liked_books') || '[]');
        const isCurrentlyLiked = likedBooks.includes(bookId);
        const type = isCurrentlyLiked ? 'unlike' : 'like';

        try {
            const response = await fetch(`/buku/${bookId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ type: type })
            });

            const data = await response.json();

            if (data.success) {
                // Update UI count
                document.getElementById('like-count').innerText = data.likes_formatted;

                // Update localStorage & Icon Appearance
                const icon = document.getElementById('like-icon');
                const bg = document.getElementById('like-icon-bg');

                if (type === 'like') {
                    likedBooks.push(bookId);
                    icon.classList.remove('bi-heart', 'text-gray-400');
                    icon.classList.add('bi-heart-fill', 'text-red-500');
                    bg.classList.add('bg-red-50');
                } else {
                    likedBooks = likedBooks.filter(id => id !== bookId);
                    icon.classList.remove('bi-heart-fill', 'text-red-500');
                    icon.classList.add('bi-heart', 'text-gray-400');
                    bg.classList.remove('bg-red-50');
                }
                localStorage.setItem('liked_books', JSON.stringify(likedBooks));
            }
        } catch (error) {
            console.error('Error toggling like:', error);
        }
    }

    function copyToClipboard() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('Link buku berhasil disalin!');
        });
    }
</script>
@endpush
@endsection
