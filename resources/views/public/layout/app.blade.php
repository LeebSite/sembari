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
                            blue:   '#0762c9',
                            sky:    '#1d83d1',
                            green:  '#27AE60',
                            yellow: '#F5A623',
                            orange: '#E8621E',
                            purple: '#7C3AED',
                            pink:   '#E91E8C',
                            footer: '#08105fff',
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
                        }
                    }
                }
            }
        }
    </script>

    {{-- Google Fonts: Nunito & Bootstrap Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
    </style>

    @yield('styles')
</head>
<body class="bg-white text-gray-800">

    @include('public.layout.header')

    @yield('content')

    @include('public.layout.footer')

    @yield('scripts')

</body>
</html>
