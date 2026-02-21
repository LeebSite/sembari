{{-- ═══════════════════════════════════════════
    FOOTER — Sembari (Premium Melayu Design)
══════════════════════════════════════════════ --}}
<footer class="relative bg-brand-navy text-white overflow-hidden">
    {{-- Gradient Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/50 via-transparent to-black/30 pointer-events-none"></div>

    {{-- Glassmorphism Decoration --}}
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-brand-blue/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-8 lg:px-12 pt-14 pb-12 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8">
            
            {{-- Column 1: Brand & Identity (Lg: 4 columns) --}}
            <div class="lg:col-span-4 space-y-6">
                <div>
                    {{-- Logo tanpa background putih --}}
                    <div class="mb-6">
                        <img src="{{ asset('img/logo/logobalai.png') }}" 
                             alt="Balai Bahasa Riau" 
                             class="h-16 w-auto object-contain"
                             style="filter: drop-shadow(0 4px 12px rgba(255,255,255,0.2));">
                    </div>
                    <p class="text-blue-100/70 text-sm leading-relaxed font-semibold max-w-sm">
                        Platform literasi digital unggulan dari <strong class="text-white">Balai Bahasa Provinsi Riau</strong>. 
                        Hadir untuk mewujudkan generasi emas Indonesia yang berwawasan luas melalui budaya membaca.
                    </p>
                </div>
                
                {{-- Social Icons --}}
                <div class="flex items-center gap-3">
                    @php
                        $socials = [
                            ['icon' => 'globe', 'link' => 'https://balaibahasariau.kemendikdasmen.go.id/'],
                            ['icon' => 'facebook', 'link' => 'https://www.facebook.com/balaibahasa.provinsiriau'],
                            ['icon' => 'instagram', 'link' => 'https://www.instagram.com/balaibahasaprovinsiriau/'],
                            ['icon' => 'youtube', 'link' => 'https://www.youtube.com/@balaibahasariau?si=vtkes8A9fEQohI_L'],
                            ['icon' => 'tiktok', 'link' => 'https://www.tiktok.com/@balai.bahasa.riau']
                        ];
                    @endphp
                    @foreach($socials as $social)
                    <a href="{{ $social['link'] }}" class="w-9 h-9 rounded-xl bg-white/5 flex items-center justify-center hover:bg-brand-yellow hover:text-white hover:-translate-y-1 transition-all duration-300 border border-white/5 backdrop-blur-sm">
                        <i class="bi bi-{{ $social['icon'] }} text-base"></i>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Column 2: Navigasi & Links (Lg: 2 columns) --}}
            <div class="lg:col-span-2">
                <h4 class="text-white font-black text-xs uppercase tracking-widest mb-6 flex items-center gap-2">
                    <span class="w-2 h-2 bg-brand-yellow rounded-full"></span>
                    Menu
                </h4>
                <ul class="space-y-3.5 text-[13px] text-blue-100/60 font-bold">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-yellow transition">Beranda</a></li>
                    <li><a href="{{ route('book.list') }}" class="hover:text-brand-yellow transition">Koleksi Buku</a></li>
                    <li><a href="https://balaibahasariau.kemendikdasmen.go.id/" class="hover:text-brand-yellow transition">Laman Balai</a></li>
                    <li><a href="#bantuan" class="hover:text-brand-yellow transition">Bantuan</a></li>
                </ul>
            </div>

            {{-- Column 3: Hubungi Kami (Lg: 3 columns) --}}
            <div class="lg:col-span-3">
                <h4 class="text-white font-black text-xs uppercase tracking-widest mb-6 flex items-center gap-2">
                    <span class="w-2 h-2 bg-brand-blue rounded-full"></span>
                    Hubungi Kami
                </h4>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <i class="bi bi-geo-alt text-brand-sky text-base mt-0.5"></i>
                        <p class="text-[12px] text-blue-100/60 font-bold leading-relaxed">
                            Jl. Binawidya, Simpang Baru, Tampan, Pekanbaru, Riau 28293
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="bi bi-envelope text-brand-sky text-base"></i>
                        <p class="text-[12px] text-blue-100/60 font-bold">info@balaibahasariau.id</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="bi bi-telephone text-brand-sky text-base"></i>
                        <p class="text-[12px] text-blue-100/60 font-bold">(0761) 65930</p>
                    </div>
                </div>
            </div>

            {{-- Column 4: Maps (Lg: 3 columns) --}}
            <div class="lg:col-span-3">
                <div class="rounded-2xl overflow-hidden border-2 border-white/5 shadow-2xl h-40">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3613.51215923794!2d101.3819563!3d0.47302600000000006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5a853e3083e97%3A0x5c40a215adfd57fd!2sBalai%20Bahasa%20Riau!5e1!3m2!1sid!2sid!4v1771628852260!5m2!1sid!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

        </div>
    </div>

    {{-- Bottom Section with Pattern --}}
    <div class="relative pt-12">
        {{-- Copyright Bar --}}
        <div class="bg-black/10 backdrop-blur-md py-6 border-t border-white/5">
            <div class="max-w-6xl mx-auto px-8 lg:px-12 flex flex-col md:flex-row items-center justify-between gap-4 relative z-20">
                <p class="text-[11px] text-white/40 font-black uppercase tracking-widest text-center md:text-left">
                    &copy; {{ date('Y') }} Sembari — Balai Bahasa Provinsi Riau. Dikembangkan oleh Tim IT.
                </p>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-brand-yellow rounded-full animate-pulse"></span>
                    <p class="text-[10px] text-white/50 font-black uppercase tracking-widest">
                        Literasi untuk Indonesia Maju
                    </p>
                </div>
            </div>
        </div>

        {{-- Pattern Melayu di paling bawah --}}
        <div class="absolute bottom-0 left-0 w-full h-[120px] pointer-events-none opacity-30 mix-blend-overlay z-10"
             style="background-image: url('{{ asset('img/paternmelayu.svg') }}'); background-repeat: repeat-x; background-size: contain; background-position: bottom;">
        </div>
        
        {{-- Extra darkening for text legibility at absolute bottom if needed --}}
        <div class="absolute bottom-0 left-0 w-full h-full bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
    </div>
</footer>
