<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sembari Flipbook Demo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .stf__wrapper {
            perspective: 1500px;
        }
        .page {
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            background-color: white;
            padding: 20px;
            font-family: 'Georgia', serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            border: 1px solid #e5e7eb;
        }
        .page.-left {
            border-right: none;
        }
        .page.-right {
            border-left: none;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-6xl w-full">
        <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Sembari Digital Book Demo</h1>
        
        <div class="flipbook mx-auto shadow-2xl" id="flipbook">
            <!-- Cover -->
            <div class="page" data-density="hard">
                <h2 class="text-4xl font-bold text-indigo-600 mb-4">The Adventure Begins</h2>
                <div class="w-32 h-32 bg-indigo-100 rounded-full flex items-center justify-center mb-6">
                    <span class="text-4xl">📚</span>
                </div>
                <p class="text-gray-500">A demo of the Flipbook UI</p>
                <p class="mt-8 text-sm text-gray-400">Click or drag corners to flip</p>
            </div>

            <!-- Page 1 -->
            <div class="page">
                <div class="prose">
                    <h3 class="text-xl font-semibold mb-2">Chapter 1</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Once upon a time, in a digital library far, far away...
                        The user wanted a seamless reading experience.
                    </p>
                </div>
                <span class="absolute bottom-4 text-xs text-gray-400">1</span>
            </div>

            <!-- Page 2 -->
            <div class="page">
                <div class="w-full h-48 bg-yellow-50 rounded-lg mb-4 flex items-center justify-center border-2 border-dashed border-yellow-200">
                    <span class="text-yellow-400">Image Placeholder</span>
                </div>
                <p class="text-gray-600 italic">"Technology brings stories to life in new ways."</p>
                <span class="absolute bottom-4 text-xs text-gray-400">2</span>
            </div>

            <!-- Page 3 -->
            <div class="page">
                <div class="prose">
                    <h3 class="text-xl font-semibold mb-2">Interactive Elements</h3>
                    <p class="text-gray-600 leading-relaxed">
                        You can add images, text, and even videos here.
                        The flip effect is smooth and realistic.
                    </p>
                </div>
                <span class="absolute bottom-4 text-xs text-gray-400">3</span>
            </div>

            <!-- Page 4 -->
            <div class="page">
                <div class="grid grid-cols-2 gap-4 w-full">
                    <div class="aspect-square bg-blue-100 rounded"></div>
                    <div class="aspect-square bg-green-100 rounded"></div>
                    <div class="aspect-square bg-red-100 rounded"></div>
                    <div class="aspect-square bg-purple-100 rounded"></div>
                </div>
                <span class="absolute bottom-4 text-xs text-gray-400">4</span>
            </div>

            <!-- Back Cover -->
            <div class="page" data-density="hard">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">The End</h2>
                <p class="text-gray-500">Thanks for reading!</p>
                <button onclick="document.getElementById('flipbook').pageFlip.flip(0)" class="mt-8 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    Read Again
                </button>
            </div>
        </div>

        <div class="mt-8 text-center text-gray-500 text-sm">
            Powered by page-flip
        </div>
    </div>
</body>
</html>
