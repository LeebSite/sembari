<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $book->title ?? 'Membaca' }} — Sembari Reader</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --bg-light: #f3f4f6;
            --bg-dark: #18181b;
            --glass: rgba(255, 255, 255, 0.8);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: #d1d5db radial-gradient(circle, #f3f4f6 0%, #d1d5db 100%);
            margin: 0; padding: 0; overflow: hidden;
            display: flex; flex-direction: column; height: 100vh;
        }

        #top-header {
            position: fixed; top: 0; left: 0; right: 0;
            height: 50px; background: white; display: flex; align-items: center;
            justify-content: space-between; padding: 0 20px; z-index: 1005;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transform: translateY(-100%);
            transition: transform 0.4s cubic-bezier(0.18, 0.89, 0.32, 1.28);
        }

        /* Hover Zones */
        .hover-zone-top {
            position: fixed; top: 0; left: 0; right: 0; height: 30px; z-index: 1001;
        }
        .hover-zone-bottom {
            position: fixed; bottom: 0; left: 0; right: 0; height: 60px; z-index: 1001;
        }

        /* Show on Hover */
        .hover-zone-top:hover ~ #top-header,
        #top-header:hover {
            transform: translateY(0);
        }

        .header-title {
            position: absolute; left: 50%; transform: translateX(-50%);
            font-weight: 800; color: var(--primary-dark); font-size: 0.85rem;
            display: flex; align-items: center; gap: 8px; text-transform: uppercase;
            letter-spacing: 1px;
        }

        #reader-wrapper {
            flex: 1; display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden; padding: 10px;
            touch-action: none; /* Penting: matikan default touch agar pinch bisa dikontrol JS */
        }

        #book-viewport {
            visibility: hidden;
            transform-origin: center center;
            transition: transform 0.05s linear;
            will-change: transform;
            /* background: #fff; - DIHAPUS agar tidak ada blok putih */
        }
        #book-viewport.ready { visibility: visible; }

        /* Indikator pinch zoom di mobile */
        #zoom-indicator {
            position: fixed;
            top: 60px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.65);
            color: white;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            z-index: 2000;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }
        #zoom-indicator.visible { opacity: 1; }

        /* Saat zoom aktif, sembunyikan side nav agar tidak mengganggu pan */
        body.zoomed #prev-btn,
        body.zoomed #next-btn {
            opacity: 0.3;
            pointer-events: none;
        }

        .st-page {
            background-color: white;
            overflow: hidden;
            border-left: 1px solid rgba(0,0,0,0.03);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); /* Shadow pindah ke sini */
        }

        /* Sembunyikan bayangan/latar jika halaman kosong (saat Cover) */
        .stf__item {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }
        /* Pastikan elemen st-page tetap punya background putih */
        .st-page {
            background: white !important;
        }

        canvas, img { 
            width: 100%; height: 100%; display: block; 
            pointer-events: none; user-select: none;
        }

        .side-nav {
            position: fixed; top: 50%; transform: translateY(-50%);
            width: 45px; height: 45px; background: rgba(0,0,0,0.2);
            color: white; border-radius: 50%; display: flex;
            align-items: center; justify-content: center; border: none;
            cursor: pointer; z-index: 1001; font-size: 1.2rem; transition: 0.3s;
            backdrop-filter: blur(5px);
        }
        .side-nav:hover { background: var(--primary); transform: translateY(-50%) scale(1.15); }
        #prev-btn { left: 20px; } #next-btn { right: 20px; }

        #bottom-toolbar {
            position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%) translateY(100px);
            background: var(--bg-dark); padding: 6px 16px; border-radius: 50px;
            display: flex; align-items: center; gap: 10px; z-index: 1005;
            opacity: 0; transition: all 0.4s cubic-bezier(0.18, 0.89, 0.32, 1.28); 
            box-shadow: 0 10px 40px rgba(0,0,0,0.4);
        }
        
        /* Show bottom toolbar on hover zone or itself */
        .hover-zone-bottom:hover ~ #reader-wrapper #bottom-toolbar,
        #bottom-toolbar:hover {
            opacity: 1; transform: translateX(-50%) translateY(0);
        }

        .tool-btn {
            color: #a1a1aa; background: none; border: none; cursor: pointer;
            font-size: 0.95rem; width: 32px; height: 32px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            transition: 0.2s;
        }
        .tool-btn:hover { color: white; background: rgba(255,255,255,0.1); }

        #page-info { color: white; font-weight: 700; font-size: 0.8rem; min-width: 50px; text-align: center; }

        /* Finish / Rating Modal */
        #finish-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.75);
            backdrop-filter: blur(12px);
            display: none; align-items: center; justify-content: center; z-index: 3000;
            opacity: 0; transition: opacity 0.4s ease;
        }
        #finish-overlay.show { display: flex; opacity: 1; }

        .finish-card {
            background: white; width: 90%; max-width: 480px; padding: 36px 32px 28px;
            border-radius: 28px; text-align: center; position: relative;
            box-shadow: 0 25px 60px rgba(0,0,0,0.4);
            animation: cardPop 0.35s cubic-bezier(0.34,1.56,0.64,1) both;
        }
        @keyframes cardPop {
            from { transform: scale(0.85); opacity: 0; }
            to   { transform: scale(1);    opacity: 1; }
        }
        .close-finish {
            position: absolute; top: 18px; right: 20px; font-size: 1.4rem;
            color: #cbd5e1; cursor: pointer; transition: color 0.2s;
        }
        .close-finish:hover { color: #64748b; }
        .finish-title { font-weight: 800; font-size: 1.35rem; color: #1e293b; margin-bottom: 28px; line-height: 1.4; }

        .rating-container { display: flex; gap: 16px; justify-content: center; margin-bottom: 24px; }
        .rating-option {
            flex: 1; padding: 22px 12px 18px; border: 2px solid #f1f5f9; border-radius: 20px;
            cursor: pointer; transition: all 0.25s ease; background: #fafafa;
        }
        .rating-option:hover { border-color: var(--primary); background: #f0f0ff; transform: translateY(-6px); box-shadow: 0 8px 24px rgba(99,102,241,0.15); }
        .rating-option:active { transform: translateY(-2px); }
        .rating-emoji { font-size: 64px; line-height: 1; display: block; margin-bottom: 12px; }
        .rating-label { font-weight: 700; font-size: 0.95rem; color: #475569; }

        #loading-overlay {
            position: fixed; inset: 0; background: #f9fafb;
            display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 2000;
        }
        .loader {
            width: 40px; height: 40px; border: 3px solid #f3f4f6;
            border-bottom-color: var(--primary); border-radius: 50%; animation: rot 1s linear infinite;
        }
        @keyframes rot { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        #loading-text { margin-top: 15px; color: var(--primary-dark); font-weight: 700; font-size: 0.85rem; }
    </style>
</head>
<body>

    <div id="loading-overlay">
        <span class="loader"></span>
        <div id="loading-text">Menyiapkan Koleksi...</div>
    </div>

    <!-- Finish / Rating Modal -->
    <div id="finish-overlay">
        <div class="finish-card">
            <i class="bi bi-x-lg close-finish" onclick="hideFinish()"></i>
            <h2 class="finish-title">Apakah kamu menyukai<br>cerita dalam buku ini?</h2>

            <div class="rating-container">
                <div class="rating-option" id="opt-biasa" onclick="submitRating('biasa')">
                    <span class="rating-emoji">😐</span>
                    <div class="rating-label">Biasa Saja.</div>
                </div>
                <div class="rating-option" id="opt-suka" onclick="submitRating('suka')">
                    <span class="rating-emoji">😍</span>
                    <div class="rating-label">Sangat Suka!</div>
                </div>
            </div>

            <a href="{{ route('book.list') }}" style="display:inline-block; padding:11px 28px; background:var(--primary); color:white; text-decoration:none; border-radius:50px; font-weight:700; font-size:0.9rem;">
                Cari Buku Lain
            </a>
        </div>
    </div>

    <div class="hover-zone-top"></div>
    <div class="hover-zone-bottom"></div>

    <div id="top-header">
        {{-- Tombol kembali: intercept jika sudah sampai halaman terakhir --}}
        <a href="{{ route('book.show', $book->id) }}" id="back-btn"
           style="color: var(--primary); text-decoration: none; font-size: 1.2rem;"
           onclick="handleBackButton(event, '{{ route('book.show', $book->id) }}')">
            <i class="bi bi-arrow-left-short"></i>
        </a>
        <div class="header-title">
            <i class="bi bi-book-half"></i>
            {{ strtoupper($book->title) }}
        </div>
        <div style="width: 44px"></div>
    </div>

    <button id="prev-btn" class="side-nav"><i class="bi bi-chevron-left"></i></button>
    <button id="next-btn" class="side-nav"><i class="bi bi-chevron-right"></i></button>

    <div id="zoom-indicator">100%</div>

    <div id="reader-wrapper">
        <div id="book-viewport"></div>

        <div id="bottom-toolbar">
            <span id="page-info">1 / -</span>
            <div style="width: 1px; height: 12px; background: rgba(255,255,255,0.15); margin: 0 5px;"></div>
            <button class="tool-btn" id="zoom-out" title="Perkecil"><i class="bi bi-zoom-out"></i></button>
            <button class="tool-btn" id="home-btn" title="Reset Ukuran"><i class="bi bi-house"></i></button>
            <button class="tool-btn" id="zoom-in" title="Perbesar"><i class="bi bi-zoom-in"></i></button>
            <button class="tool-btn" id="full-screen" title="Layar Penuh"><i class="bi bi-arrows-fullscreen"></i></button>
            @if($book->pdf_file)
                <a href="{{ asset('storage/' . $book->pdf_file) }}" download class="tool-btn" title="Download PDF" style="text-decoration: none;">
                    <i class="bi bi-cloud-arrow-down-fill" style="color: #818cf8;"></i>
                </a>
            @endif
        </div>
    </div>

    <script src="{{ asset('js/page-flip.min.js') }}"></script>
    <script src="{{ asset('js/pdf.min.js') }}"></script>

    <script>
        let pageFlip;
        let reachedLastPage = false;   // apakah pembaca sudah sampai halaman terakhir?
        let pendingBackUrl  = null;     // URL tujuan setelah menutup modal

        function showFinishModal(backUrl) {
            pendingBackUrl = backUrl || null;
            const overlay = document.getElementById('finish-overlay');
            overlay.style.display = 'flex';
            requestAnimationFrame(() => {
                requestAnimationFrame(() => overlay.classList.add('show'));
            });
        }

        function hideFinish() {
            const overlay = document.getElementById('finish-overlay');
            overlay.classList.remove('show');
            // Setelah transisi selesai, sembunyikan dan navigasi jika ada
            setTimeout(() => {
                overlay.style.display = 'none';
                if (pendingBackUrl) {
                    window.location.href = pendingBackUrl;
                }
            }, 400);
        }

        // Intercept tombol kembali: tampilkan rating dulu jika sudah di halaman terakhir
        function handleBackButton(event, backUrl) {
            if (reachedLastPage) {
                event.preventDefault();
                showFinishModal(backUrl);
            }
            // Jika belum sampai halaman terakhir, biarkan navigasi normal
        }

        async function submitRating(val) {
            // Tampilkan loading state pada tombol
            document.querySelectorAll('.rating-option').forEach(el => {
                el.style.pointerEvents = 'none';
                el.style.opacity = '0.6';
            });

            // Hanya kirim like jika memilih "suka"
            if (val === 'suka') {
                try {
                    const response = await fetch("{{ route('book.like', $book->id) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ type: 'like' })
                    });
                    const result = await response.json();
                    if (result.success) {
                        console.log('Liked! Count:', result.likes_count);
                    }
                } catch (error) {
                    console.error('Error liking book:', error);
                }
            }

            // Redirect ke daftar koleksi
            window.location.href = "{{ route('book.list') }}";
        }

        document.addEventListener('DOMContentLoaded', async function() {
            const viewport = document.getElementById('book-viewport');
            const loadingText = document.getElementById('loading-text');
            const hasServerPages = {{ count($pages) > 0 ? 'true' : 'false' }};
            const pdfUrl = "{{ asset('storage/' . ($book->pdf_file ?? '')) }}";
            const imageUrls = {!! json_encode($pages) !!};

            function getBookSize() {
                const availableH = window.innerHeight - 120;
                const ratio = 1.414; 
                let w = Math.floor(availableH * ratio);
                if (w > window.innerWidth - 80) w = window.innerWidth - 80;
                return { 
                    width: Math.floor(w / 2), 
                    height: Math.floor((w / 2) / 0.707) 
                };
            }

            const size = getBookSize();
            
            pageFlip = new St.PageFlip(viewport, {
                width: size.width,
                height: size.height,
                size: "fixed",
                minWidth: 300, maxWidth: 1000,
                minHeight: 400, maxHeight: 1400,
                drawShadow: true,
                flippingTime: 800,
                usePortrait: true,
                startPage: 0,
                showCover: true,
                autoCenter: true, // AKTIFKAN AUTO CENTER
                mobileScrollSupport: false
            });

            if (hasServerPages) {
                const pageElems = [];
                imageUrls.forEach((url, i) => {
                    const div = document.createElement('div');
                    div.className = 'st-page';
                    // Tambahkan density hard pada halaman pertama dan terakhir agar kaku seperti cover
                    if(i === 0 || i === imageUrls.length - 1) div.setAttribute('data-density', 'hard');
                    div.innerHTML = `<img src="${url}">`;
                    pageElems.push(div);
                });
                pageFlip.loadFromHTML(pageElems);
                initInterface(imageUrls.length);
            } else if (pdfUrl && pdfUrl.length > 10) {
                try {
                    loadingText.innerText = "Membuka PDF...";
                    const pdfjs = window['pdfjs-dist/build/pdf'];
                    pdfjs.GlobalWorkerOptions.workerSrc = "{{ asset('js/pdf.worker.min.js') }}";
                    
                    const pdf = await pdfjs.getDocument(pdfUrl).promise;
                    const total = pdf.numPages;
                    const pageElems = [];

                    for (let i = 1; i <= total; i++) {
                        loadingText.innerText = `Menyiapkan Halaman ${i}/${total}...`;
                        const page = await pdf.getPage(i);
                        const vp = page.getViewport({ scale: 2.0 });
                        const canvas = document.createElement('canvas');
                        canvas.height = vp.height; canvas.width = vp.width;
                        await page.render({ canvasContext: canvas.getContext('2d'), viewport: vp }).promise;
                        
                        const div = document.createElement('div');
                        div.className = 'st-page';
                        if(i === 1 || i === total) div.setAttribute('data-density', 'hard');
                        div.appendChild(canvas);
                        pageElems.push(div);
                    }
                    pageFlip.loadFromHTML(pageElems);
                    initInterface(total);
                } catch (e) {
                    loadingText.innerText = "Gagal memproses PDF.";
                    console.error(e);
                }
            }

            function initInterface(count) {
                viewport.classList.add('ready');
                document.getElementById('page-info').innerText = `1 / ${count}`;
                
                setTimeout(() => {
                    document.getElementById('loading-overlay').style.opacity = '0';
                    setTimeout(() => document.getElementById('loading-overlay').style.display = 'none', 500);
                }, 800);

                pageFlip.on('flip', (e) => {
                    const currentPage = e.data + 1;
                    document.getElementById('page-info').innerText = `${currentPage} / ${count}`;

                    // Tandai jika sudah sampai 2 halaman terakhir
                    if (e.data >= count - 2) {
                        reachedLastPage = true;
                    }
                });

                pageFlip.on('changeState', () => {
                    // Backup deteksi via getCurrentPageIndex
                    const curr = pageFlip.getCurrentPageIndex();
                    if (curr >= count - 2) {
                        reachedLastPage = true;
                    }
                });

                document.getElementById('prev-btn').onclick = () => pageFlip.flipPrev();
                document.getElementById('next-btn').onclick = () => pageFlip.flipNext();
                
                // ─── State Zoom & Pan ─────────────────────────────────
                let zoom = 1;
                let panX = 0, panY = 0;
                const MIN_ZOOM = 0.5, MAX_ZOOM = 4;
                const zoomIndicator = document.getElementById('zoom-indicator');
                let zoomIndicatorTimer = null;

                function applyTransform() {
                    // Saat zoom = 1, reset pan ke tengah
                    if (zoom <= 1) { panX = 0; panY = 0; }
                    viewport.style.transform = `scale(${zoom}) translate(${panX}px, ${panY}px)`;

                    // Tampilkan indikator
                    zoomIndicator.textContent = Math.round(zoom * 100) + '%';
                    zoomIndicator.classList.add('visible');
                    clearTimeout(zoomIndicatorTimer);
                    zoomIndicatorTimer = setTimeout(() => zoomIndicator.classList.remove('visible'), 1500);

                    // Toggle class 'zoomed' di body untuk disable flip button
                    document.body.classList.toggle('zoomed', zoom > 1.05);
                }

                // ─── Zoom Button (Desktop & Mobile) ───────────────────
                document.getElementById('zoom-in').onclick = () => {
                    zoom = Math.min(MAX_ZOOM, zoom + 0.2);
                    applyTransform();
                };
                document.getElementById('zoom-out').onclick = () => {
                    zoom = Math.max(MIN_ZOOM, zoom - 0.2);
                    applyTransform();
                };
                document.getElementById('home-btn').onclick = () => {
                    zoom = 1; panX = 0; panY = 0;
                    applyTransform();
                };
                document.getElementById('full-screen').onclick = () => {
                    if (!document.fullscreenElement) document.documentElement.requestFullscreen();
                    else document.exitFullscreen();
                };

                // ─── Keyboard Navigation ──────────────────────────────
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft') pageFlip.flipPrev();
                    if (e.key === 'ArrowRight') pageFlip.flipNext();
                });

                // ─── PINCH TO ZOOM (Touch) ────────────────────────────
                const readerWrapper = document.getElementById('reader-wrapper');

                let lastDist = 0;         // jarak 2 jari terakhir
                let pinching = false;     // sedang pinch?
                let zoomAtPinchStart = 1; // zoom saat pinch mulai

                // Pan state
                let isPanning = false;
                let panStartX = 0, panStartY = 0;
                let panXAtStart = 0, panYAtStart = 0;

                function getTouchDist(touches) {
                    const dx = touches[0].clientX - touches[1].clientX;
                    const dy = touches[0].clientY - touches[1].clientY;
                    return Math.sqrt(dx * dx + dy * dy);
                }

                readerWrapper.addEventListener('touchstart', (e) => {
                    if (e.touches.length === 2) {
                        // ── Mulai Pinch ──
                        pinching = true;
                        isPanning = false;
                        lastDist = getTouchDist(e.touches);
                        zoomAtPinchStart = zoom;
                        e.preventDefault();
                    } else if (e.touches.length === 1 && zoom > 1.05) {
                        // ── Mulai Pan (hanya jika sudah zoom) ──
                        isPanning = true;
                        pinching = false;
                        panStartX = e.touches[0].clientX;
                        panStartY = e.touches[0].clientY;
                        panXAtStart = panX;
                        panYAtStart = panY;
                        e.preventDefault();
                    }
                }, { passive: false });

                readerWrapper.addEventListener('touchmove', (e) => {
                    if (pinching && e.touches.length === 2) {
                        // ── Hitung zoom baru dari rasio jarak jari ──
                        const dist = getTouchDist(e.touches);
                        const delta = dist / lastDist;
                        zoom = Math.min(MAX_ZOOM, Math.max(MIN_ZOOM, zoomAtPinchStart * delta));
                        applyTransform();
                        e.preventDefault();
                    } else if (isPanning && e.touches.length === 1 && zoom > 1.05) {
                        // ── Hitung offset pan ──
                        const dx = (e.touches[0].clientX - panStartX) / zoom;
                        const dy = (e.touches[0].clientY - panStartY) / zoom;

                        // Batasi pan agar tidak keluar terlalu jauh
                        const maxPan = 300;
                        panX = Math.min(maxPan, Math.max(-maxPan, panXAtStart + dx));
                        panY = Math.min(maxPan, Math.max(-maxPan, panYAtStart + dy));
                        applyTransform();
                        e.preventDefault();
                    }
                }, { passive: false });

                readerWrapper.addEventListener('touchend', (e) => {
                    if (e.touches.length < 2) pinching = false;
                    if (e.touches.length === 0) {
                        isPanning = false;
                        // Snap kembali ke zoom=1 jika hampir normal
                        if (zoom < 1.1) {
                            zoom = 1;
                            applyTransform();
                        }
                    }
                });

                // ─── Mouse Wheel Zoom (Desktop) ───────────────────────
                readerWrapper.addEventListener('wheel', (e) => {
                    if (e.ctrlKey || e.metaKey) {
                        e.preventDefault();
                        const delta = e.deltaY > 0 ? -0.1 : 0.1;
                        zoom = Math.min(MAX_ZOOM, Math.max(MIN_ZOOM, zoom + delta));
                        applyTransform();
                    }
                }, { passive: false });
            }
        });
    </script>
</body>
</html>
