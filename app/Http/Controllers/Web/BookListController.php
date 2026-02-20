<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\ReadingLevel;
use App\Models\BookType;

class BookListController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['readingLevel', 'stat', 'categories', 'bookTypes']);

        // ── Search ──
        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('contributors', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }

        // ── Filter Lisensi ──
        if ($lisensi = $request->get('lisensi')) {
            $map = [
                'terbatas' => 'Buku Edisi Terbatas',
                'umum'     => 'Buku Edisi Umum',
            ];
            if (isset($map[$lisensi])) {
                $query->where('license', $map[$lisensi]);
            }
        }

        // ── Filter Jenjang ──
        if ($jenjang = $request->get('jenjang')) {
            $query->where('reading_level_id', $jenjang);
        }

        // ── Filter Kategori ──
        if ($kategori = $request->get('kategori')) {
            $query->whereHas('categories', fn($q) => $q->where('categories.id', $kategori));
        }

        // ── Filter Jenis Buku ──
        if ($jenis = $request->get('jenis')) {
            $query->whereHas('bookTypes', fn($q) => $q->where('book_types.id', $jenis));
        }

        // ── Filter Tahun ──
        if ($tahun = $request->get('tahun')) {
            $query->where('tahun_terbit', $tahun);
        }

        // ── Sort ──
        $sort = $request->get('sort', 'terbaru');
        match ($sort) {
            'az'       => $query->orderBy('title', 'asc'),
            'za'       => $query->orderBy('title', 'desc'),
            'populer'  => $query->leftJoin('book_stats', 'books.id', '=', 'book_stats.book_id')
                                ->orderBy('book_stats.views_count', 'desc')
                                ->select('books.*'),
            default    => $query->orderBy('created_at', 'desc'),
        };

        $books         = $query->paginate(20)->withQueryString();
        $totalBuku     = Book::count();
        $allKategori   = Category::withCount('books')->orderBy('name')->get();
        $allJenjang    = ReadingLevel::orderBy('order')->get();
        $allJenis      = BookType::orderBy('name')->get();
        $tahunList     = Book::whereNotNull('tahun_terbit')
                            ->distinct()
                            ->orderByDesc('tahun_terbit')
                            ->pluck('tahun_terbit');

        return view('public.books.index', compact(
            'books', 'totalBuku',
            'allKategori', 'allJenjang', 'allJenis', 'tahunList',
            'search', 'lisensi', 'jenjang', 'kategori', 'jenis', 'tahun', 'sort'
        ));
    }
}
