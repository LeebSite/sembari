<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\Category;
use App\Models\ReadingLevel;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Buku Terbaru (4 terbaru)
        $terbaru = Book::with(['readingLevel', 'stat'])
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // 2. Buku Terpopuler (berdasarkan views di table book_stats)
        $terpopuler = Book::select('books.*')
            ->leftJoin('book_stats', 'books.id', '=', 'book_stats.book_id')
            ->orderBy('book_stats.views_count', 'desc')
            ->take(8)
            ->get();

        // 3. Edisi Terbatas
        $terbatas = Book::where('license', 'Buku Edisi Terbatas')
            ->take(4)
            ->get();

        // 4. Jenjang Pembaca
        $jenjang = ReadingLevel::orderBy('order')->get();

        // 5. Kategori beserta jumlah buku
        $kategori = Category::withCount('books')->get();

        // 6. Statistik ringkasan
        $stats = [
            'buku'     => DB::table('books')->count(),
            'pembaca'  => DB::table('book_stats')->sum('reads_count'),
            'kategori' => DB::table('categories')->count(),
        ];

        return view('public.home.home', compact(
            'terbaru',
            'terpopuler',
            'terbatas',
            'jenjang',
            'kategori',
            'stats'
        ));
    }
}
