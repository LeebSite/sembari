<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sembari — Perpustakaan Digital BBPR')</title>
    <meta name="description" content="@yield('description', 'Sembari adalah platform membaca buku digital gratis dari Balai Bahasa Provinsi Riau. Ribuan buku cerita untuk anak tersedia di sini!')">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'round': ['"Nunito"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            blue:   '#0766d2ff',
                            sky:    '#1d83d1',
                            green:  '#27AE60',
                            yellow: '#F5A623',
                            yellow2: '#ffd500ff',
                            orange: '#E8621E',
                            purple: '#7C3AED',
                            pink:   '#E91E8C',
                            navy: '#08105fff',
                            darkblue: '#2838c3ff',
                            gray: '#94A3B8',
                            white: '#ffffff',
                        }
                    },
                    animation: {
                        'float':  'float 4s ease-in-out infinite',
                        'wiggle': 'wiggle 1s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%':      { transform: 'translateY(-12px)' },
                        },
                        wiggle: {
                            '0%, 100%': { transform: 'rotate(-3deg)' },
                            '50%':      { transform: 'rotate(3deg)' },
                        },
                        'slide-in': {
                            '0%': { transform: 'translateX(100%)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>

    {{-- Google Fonts: Nunito & Bootstrap Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    {{-- AOS Animation --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        * { font-family: 'Nunito', sans-serif; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f0f4ff; }
        ::-webkit-scrollbar-thumb { background: #1d83d1; border-radius: 10px; }

        /* ── Hero Background ── */
        .hero-bg {
            background-color: #FAFCFF;
            position: relative;
            overflow: hidden;
        }
        /* Glow biru halus di pojok kanan atas */
        .hero-bg::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 520px; height: 520px;
            background: radial-gradient(circle, rgba(7,98,201,0.07) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        /* Pola polka dot tipis */
        .hero-bg::after {
            content: '';
            position: absolute; inset: 0;
            background-image: radial-gradient(circle, #7CB9E8 1px, transparent 1px);
            background-size: 36px 36px;
            opacity: 0.05;
            pointer-events: none;
        }

        /* ── Wave Divider ── */
        .wave-divider { overflow: hidden; line-height: 0; }
        .wave-divider svg { display: block; width: 100%; }

        /* ── Navbar Glow ── */
        .navbar-glow { box-shadow: 0 4px 20px rgba(7,98,201,0.25); }

        /* ── Book Card ── */
        .book-card { transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .book-card:hover { transform: translateY(-10px) scale(1.02); }

        /* ── Star ── */
        .star { color: #F5A623; }

        /* ── Badge Pulse ── */
        @keyframes pulseBadge {
            0%, 100% { box-shadow: 0 0 0 0 rgba(245,166,35,0.6); }
            50%       { box-shadow: 0 0 0 8px rgba(245,166,35,0); }
        }
        .badge-pulse { animation: pulseBadge 2s infinite; }

        /* ── Section Alt ── */
        .section-alt { background: linear-gradient(to bottom, #F0F7FF, #EEF6FF); }

        /* ── Category Pill ── */
        .cat-pill { transition: all 0.2s; }
        .cat-pill:hover { transform: translateY(-3px); box-shadow: 0 6px 18px rgba(0,0,0,0.12); }

        /* ── Toast Notification ── */
        .toast-animate {
            animation: slide-in 0.5s cubic-bezier(0.18, 0.89, 0.32, 1.28) forwards;
        }

        /* ── PRELOADER STYLES ── */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, #ffffff 0%, #F8FAFF 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            transition: opacity 0.4s ease, visibility 0.4s;
        }

        /* Magic Book Animation */
        .magic-book {
            width: 100px;
            height: 80px;
            position: relative;
            perspective: 1000px;
        }

        .book-spine {
            width: 4px;
            height: 100%;
            background: #1E40AF;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
            z-index: 5;
        }

        .book-page {
            width: 50%;
            height: 100%;
            background: white;
            position: absolute;
            right: 0;
            transform-origin: left center;
            border: 2px solid #1E40AF;
            border-left: none;
            border-radius: 0 10px 10px 0;
            animation: flip-page 2.5s infinite ease-in-out;
            box-shadow: 2px 2px 10px rgba(30, 64, 175, 0.1);
        }

        .book-page-fixed {
            width: 50%;
            height: 100%;
            background: #EFF6FF;
            position: absolute;
            border: 2px solid #1E40AF;
            z-index: 1;
        }

        .page-left { left: 0; border-radius: 10px 0 0 10px; border-right: none; }
        .page-right { right: 0; border-radius: 0 10px 10px 0; border-left: none; }

        @keyframes flip-page {
            0% { transform: rotateY(0deg); z-index: 10; }
            50% { transform: rotateY(-180deg); z-index: 10; }
            100% { transform: rotateY(-180deg); z-index: 1; }
        }

        .magic-book .book-page:nth-child(2) { animation-delay: 0.5s; }
        .magic-book .book-page:nth-child(3) { animation-delay: 1.0s; }
        .magic-book .book-page:nth-child(4) { animation-delay: 1.5s; }

        /* Sparkles */
        .sparkles {
            position: absolute;
            width: 100%;
            height: 100px;
            pointer-events: none;
        }

        .sparkle {
            position: absolute;
            background: #F5A623;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            animation: sparkle-float 2s infinite;
        }

        @keyframes sparkle-float {
            0% { transform: translateY(0) scale(0); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateY(-60px) scale(1); opacity: 0; }
        }

        .loading-text {
            margin-top: 40px;
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            color: #1E40AF;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 13px;
        }

        .preloader-hidden {
            opacity: 0;
            visibility: hidden;
        }
    </style>

    @yield('styles')
</head>
<body class="bg-white text-gray-800">
    {{-- ══ PRELOADER (MAGIC BOOK) ══ --}}
    <div id="preloader">
        <div class="relative">
            <div class="magic-book">
                <div class="book-spine"></div>
                <div class="book-page-fixed page-left"></div>
                <div class="book-page-fixed page-right"></div>
                <div class="book-page"></div>
                <div class="book-page"></div>
                <div class="book-page"></div>
            </div>
            {{-- Sparkle elements --}}
            <div class="sparkles">
                <div class="sparkle" style="left: 20%; animation-delay: 0.2s;"></div>
                <div class="sparkle" style="left: 50%; animation-delay: 0.5s;"></div>
                <div class="sparkle" style="left: 80%; animation-delay: 0.8s;"></div>
            </div>
        </div>
        <div class="loading-text flex items-center gap-2">
            <span>Sebentar ya...</span>
            <span class="flex gap-1">
                <span class="w-1.5 h-1.5 bg-brand-yellow rounded-full animate-bounce"></span>
                <span class="w-1.5 h-1.5 bg-brand-yellow rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                <span class="w-1.5 h-1.5 bg-brand-yellow rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
            </span>
        </div>
    </div>

    @include('public.layout.header')

    @yield('content')

    {{-- Global Toast --}}
    @if(session('success_like'))
    <div id="toast-notif" class="fixed bottom-6 right-6 z-[9999] toast-animate">
        <div class="bg-brand-navy border-l-4 border-brand-yellow text-white p-4 rounded-2xl shadow-2xl flex items-center gap-4 min-w-[300px]">
            <div class="bg-brand-yellow/20 p-2.5 rounded-xl">
                <i class="bi bi-heart-fill text-brand-yellow text-xl"></i>
            </div>
            <div>
                <h4 class="font-black text-sm tracking-tight">Sangat Suka!</h4>
                <p class="text-xs font-bold text-gray-400">{{ session('success_like') }}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-gray-500 hover:text-white transition">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast-notif');
            if(toast) {
                toast.style.transition = 'all 0.6s cubic-bezier(0.68, -0.55, 0.27, 1.55)';
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(50px) scale(0.9)';
                setTimeout(() => toast.remove(), 600);
            }
        }, 4000);
    </script>
    @endif

    @include('public.layout.footer')

    @yield('scripts')

    {{-- AOS Init --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init({
        duration: 1000,
        once: true,
        offset: 100,
        easing: 'ease-out-cubic'
      });

      // ── PRELOADER LOGIC ──
      window.addEventListener('load', function() {
          const preloader = document.getElementById('preloader');
          setTimeout(() => {
              preloader.classList.add('preloader-hidden');
          }, 800); // Minimum delay to see the animation
      });

      // Show loader on navigation
      window.addEventListener('beforeunload', function() {
          document.getElementById('preloader').classList.remove('preloader-hidden');
      });
    </script>

</body>
</html>
