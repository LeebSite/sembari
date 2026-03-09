<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\ReadingLevel;
use App\Models\Daerah;

class BookListController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['readingLevel', 'stat', 'categories', 'daerah']);

        // ── Search ──
        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('detail', 'like', "%$search%")
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

        // ── Filter Daerah ──
        if ($daerah = $request->get('daerah')) {
            $query->where('daerah_id', $daerah);
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

        $books       = $query->paginate(20)->withQueryString();
        $totalBuku   = Book::count();
        $allKategori = Category::withCount('books')->orderBy('name')->get();
        $allJenjang  = ReadingLevel::orderBy('order')->get();
        $allDaerah   = Daerah::withCount('books')->orderBy('name')->get();
        $tahunList   = Book::whereNotNull('tahun_terbit')
                          ->distinct()
                          ->orderByDesc('tahun_terbit')
                          ->pluck('tahun_terbit');

        return view('public.books.index', compact(
            'books', 'totalBuku',
            'allKategori', 'allJenjang', 'allDaerah', 'tahunList',
            'search', 'lisensi', 'jenjang', 'kategori', 'daerah', 'tahun', 'sort'
        ));
    }

    public function show($id)
    {
        $book = Book::with(['readingLevel', 'stat', 'categories', 'daerah'])
            ->where('id', $id)
            ->orWhere('slug', $id)
            ->firstOrFail();

        // ── Logic Stats: Views ──
        $viewed = session()->get('viewed_books', []);
        if (!in_array($book->id, $viewed)) {
            $stat = $book->stat()->firstOrCreate(['book_id' => $book->id]);
            $stat->increment('views_count');
            session()->push('viewed_books', $book->id);
        }

        return view('public.books.show', compact('book'));
    }

    /**
     * Fitur Like tanpa login (Public).
     */
    public function toggleLike(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $stat = $book->stat()->firstOrCreate(['book_id' => $book->id]);
        $type = $request->get('type', 'like');

        if ($type === 'like') {
            $stat->increment('likes_count');
            session()->flash('success_like', 'Terima kasih atas penilaianmu!');
        } else {
            if ($stat->likes_count > 0) {
                $stat->decrement('likes_count');
            }
        }

        return response()->json([
            'success'          => true,
            'likes_count'      => $stat->likes_count,
            'likes_formatted'  => number_format($stat->likes_count)
        ]);
    }
}
