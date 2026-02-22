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
            height: 50px; background: white; display: flex; align-items: center;
            justify-content: space-between; padding: 0 20px; z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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
        }

        #book-viewport {
            visibility: hidden;
            /* background: #fff; - DIHAPUS agar tidak ada blok putih */
        }
        #book-viewport.ready { visibility: visible; }

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
            position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
            background: var(--bg-dark); padding: 6px 16px; border-radius: 50px;
            display: flex; align-items: center; gap: 10px; z-index: 1000;
            opacity: 0; transition: 0.5s; box-shadow: 0 10px 40px rgba(0,0,0,0.4);
        }
        #bottom-toolbar.show { opacity: 1; }

        .tool-btn {
            color: #a1a1aa; background: none; border: none; cursor: pointer;
            font-size: 0.95rem; width: 32px; height: 32px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            transition: 0.2s;
        }
        .tool-btn:hover { color: white; background: rgba(255,255,255,0.1); }

        #page-info { color: white; font-weight: 700; font-size: 0.8rem; min-width: 50px; text-align: center; }

        /* Finish Modal Styles */
        #finish-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.85);
            backdrop-filter: blur(10px);
            display: none; align-items: center; justify-content: center; z-index: 3000;
            opacity: 0; transition: 0.5s;
        }
        #finish-overlay.show { display: flex; opacity: 1; }

        .finish-card {
            background: white; width: 90%; max-width: 500px; padding: 40px;
            border-radius: 30px; text-align: center; position: relative;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }
        .close-finish {
            position: absolute; top: 20px; right: 20px; font-size: 1.5rem;
            color: #94a3b8; cursor: pointer;
        }
        .finish-title { font-weight: 800; font-size: 1.5rem; color: #1e293b; margin-bottom: 30px; }
        
        .rating-container { display: flex; gap: 20px; justify-content: center; margin-bottom: 30px; }
        .rating-option {
            flex: 1; padding: 25px 15px; border: 2px solid #f1f5f9; border-radius: 20px;
            cursor: pointer; transition: 0.3s;
        }
        .rating-option:hover { border-color: var(--primary); background: #f8fafc; transform: translateY(-5px); }
        .rating-option img { width: 80px; height: 80px; margin: 0 auto 15px; }
        .rating-label { font-weight: 700; color: #475569; }

        .footer-note { font-size: 0.75rem; color: #94a3b8; margin-top: 20px; }

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

    <!-- Finish Modal -->
    <div id="finish-overlay">
        <div class="finish-card">
            <i class="bi bi-x-lg close-finish" onclick="hideFinish()"></i>
            <h2 class="finish-title">Apakah kamu menyukai cerita dalam buku ini?</h2>
            
            <div class="rating-container">
                <div class="rating-option" onclick="submitRating('biasa')">
                    <img src="https://openmoji.org/data/color/svg/1F610.svg" alt="Biasa Saja">
                    <div class="rating-label">Biasa Saja.</div>
                </div>
                <div class="rating-option" onclick="submitRating('suka')">
                    <img src="https://openmoji.org/data/color/svg/1F60D.svg" alt="Sangat Suka!">
                    <div class="rating-label">Sangat Suka!</div>
                </div>
            </div>

            <a href="{{ route('home') }}" style="display: inline-block; padding: 12px 30px; background: var(--primary); color: white; text-decoration: none; border-radius: 50px; font-weight: 700; margin-top: 10px;">
                Cari Buku Lain
            </a>
        </div>
    </div>

    <div id="top-header">
        <a href="{{ route('book.show', $book->id) }}" style="color: var(--primary); text-decoration: none; font-size: 1.2rem;">
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
        
        function hideFinish() {
            document.getElementById('finish-overlay').classList.remove('show');
        }

        async function submitRating(val) {
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
                        console.log("Liked! New count:", result.likes_count);
                    }
                } catch (error) {
                    console.error("Error liking book:", error);
                }
            }
            
            // Animasi feedback sederhana sebelum pindah
            alert("Terima kasih atas penilaianmu!");
            window.location.href = "{{ route('home') }}";
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
                document.getElementById('bottom-toolbar').classList.add('show');
                document.getElementById('page-info').innerText = `1 / ${count}`;
                
                setTimeout(() => {
                    document.getElementById('loading-overlay').style.opacity = '0';
                    setTimeout(() => document.getElementById('loading-overlay').style.display = 'none', 500);
                }, 800);

                pageFlip.on('flip', (e) => {
                    const currentPage = e.data + 1;
                    document.getElementById('page-info').innerText = `${currentPage} / ${count}`;
                    
                    // Jika sampai halaman terakhir, munculkan modal Like
                    if (currentPage === count) {
                        setTimeout(() => {
                            document.getElementById('finish-overlay').classList.add('show');
                        }, 1000);
                    }
                });

                document.getElementById('prev-btn').onclick = () => pageFlip.flipPrev();
                document.getElementById('next-btn').onclick = () => pageFlip.flipNext();
                
                let zoom = 1;
                document.getElementById('zoom-in').onclick = () => { zoom += 0.1; viewport.style.transform = `scale(${zoom})`; };
                document.getElementById('zoom-out').onclick = () => { if(zoom > 0.5) zoom -= 0.1; viewport.style.transform = `scale(${zoom})`; };
                document.getElementById('home-btn').onclick = () => { zoom = 1; viewport.style.transform = 'scale(1)'; };
                document.getElementById('full-screen').onclick = () => {
                    if (!document.fullscreenElement) document.documentElement.requestFullscreen();
                    else document.exitFullscreen();
                };
            }
        });
    </script>
</body>
</html>
