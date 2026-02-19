{{--
    STATISTIK BAR — Khusus halaman Home
    Variabel yang dibutuhkan dari HomeController:
      - $stats['buku']     → total buku digital
      - $stats['pembaca']  → total pembaca (sementara hardcode)
      - $stats['kategori'] → total kategori
--}}
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

        {{-- Stat: Total Pembaca
             SEMENTARA: hardcode 12.744
             Aktifkan baris yang di-comment setelah data pembaca real tersedia --}}
        <div class="px-6 md:px-10 text-center hidden md:flex items-center gap-3">
            <div class="hidden md:flex w-9 h-9 bg-white/20 rounded-xl items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
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

{{-- Count-Up Animation: angka beranimasi dari 0 ke target saat elemen terlihat --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const animateCount = (el) => {
        const target = parseInt(el.getAttribute('data-target'), 10);
        if (!target || target === 0) { el.textContent = '0'; return; }

        const steps = Math.ceil(1800 / 16); // ~60fps selama 1.8 detik
        let step = 0;

        const timer = setInterval(() => {
            step++;
            const progress = 1 - Math.pow(1 - step / steps, 3); // ease-out cubic
            el.textContent = Math.round(target * progress).toLocaleString('id-ID');
            if (step >= steps) {
                el.textContent = target.toLocaleString('id-ID');
                clearInterval(timer);
            }
        }, 16);
    };

    // Animasi hanya berjalan sekali saat stat bar masuk ke viewport
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCount(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('[data-target]').forEach(el => observer.observe(el));
});
</script>
