<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- CSS eksternal -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none !important;
        }

        input[type="password"]::-webkit-credentials-auto-fill-button {
            visibility: hidden !important;
            display: none !important;
        }
    </style>

</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4" style="background-color:#1e3a8a;">
    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-md w-full max-w-sm sm:max-w-md transition-all">

        <!-- Logo -->
        <div class="flex justify-center mb-4">
            <img src="{{ asset('img/logobbpr4.png') }}" class="logo-admin w-auto transition-all">
        </div>

        <p class="text-xs sm:text-sm text-center text-gray-600 mb-1">
            Silakan masukkan email dan kata sandi Anda
            <br>untuk masuk ke laman admin Balai Bahasa Provinsi Riau</br>
        </p>

        <!-- Error -->
        @if ($errors->has('login'))
            <p class="text-red-500 mt-2 text-center text-sm">{{ $errors->first('login') }}</p>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="form-login">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <input type="text" name="login" value="{{ old('login') }}" required
                    placeholder="Email atau Username"
                    class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-md
                        focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Password -->
            <div class="relative mb-4">
                <input id="password" type="password" name="password" required placeholder="Kata sandi"
                    class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-md
                        focus:ring-2 focus:ring-blue-400 pr-10">

                <span class="absolute right-3 top-2.5 cursor-pointer" onclick="togglePassword()">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path id="eyePath1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path id="eyePath2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5
                                c4.477 0 8.268 2.943 9.542 7
                                -1.274 4.057-5.065 7-9.542 7
                                -4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </span>
            </div>

            <!-- Button -->
            <div class="mt-2">
                <button type="submit"
                    class="login-btn w-full py-2 text-sm sm:text-base rounded-md font-medium transition">
                    Masuk
                </button>
            </div>

            <p class="text-[10px] sm:text-xs text-center text-gray-400 mt-4">
                © 2025 Balai Bahasa Provinsi Riau
            </p>
        </form>


    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const path1 = document.getElementById('eyePath1');
            const path2 = document.getElementById('eyePath2');

            if (input.type === 'password') {
                input.type = 'text';
                // Mata tertutup
                path1.setAttribute('d', 'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.944-9.543-7a9.958 9.958 0 012.641-4.263M9.88 9.88a3 3 0 004.24 4.24M6.1 6.1l11.8 11.8');
                path2.setAttribute('d', ''); // hapus path kedua agar tidak dobel
            } else {
                input.type = 'password';
                // Mata terbuka
                path1.setAttribute('d', 'M15 12a3 3 0 11-6 0 3 3 0 016 0z');
                path2.setAttribute('d', 'M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z');
            }
        }
    </script>
</body>

</html>
