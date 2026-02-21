<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of books with search, filter, and sort.
     */
    public function index(Request $request)
    {
        $search  = $request->input('search', '');
        $kategori = $request->input('kategori', '');
        $lisensi  = $request->input('lisensi', '');
        $sort     = $request->input('sort', 'terbaru');

        $query = DB::table('books')
            ->select('books.*')
            ->leftJoin('book_stats', 'books.id', '=', 'book_stats.book_id');

        // ── Search judul / kontributor ──
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('books.title', 'like', "%{$search}%")
                  ->orWhere('books.contributors', 'like', "%{$search}%");
            });
        }

        // ── Filter kategori ──
        if ($kategori) {
            $query->whereExists(function ($q) use ($kategori) {
                $q->select(DB::raw(1))
                  ->from('book_categories')
                  ->whereColumn('book_categories.book_id', 'books.id')
                  ->where('category_id', $kategori);
            });
        }

        // ── Filter lisensi ──
        if ($lisensi) {
            $query->where('books.license', $lisensi);
        }

        // ── Sort ──
        match ($sort) {
            'az'        => $query->orderBy('books.title', 'asc'),
            'za'        => $query->orderBy('books.title', 'desc'),
            'terpopuler'=> $query->orderByRaw('COALESCE(book_stats.views_count, 0) DESC'),
            default     => $query->orderBy('books.created_at', 'desc'),
        };

        $books      = $query->paginate(12)->withQueryString();
        $categories = DB::table('categories')->orderBy('name')->get();
        $totalAll   = DB::table('books')->count();

        return view('admin.books.index', compact(
            'books', 'categories', 'totalAll',
            'search', 'kategori', 'lisensi', 'sort'
        ));
    }


    /**
     * Show the form for creating a new book.
     */
    public function create()
    {
        $categories = DB::table('categories')->orderBy('name')->get();
        $bookTypes = DB::table('book_types')->orderBy('name')->get();
        $readingLevels = DB::table('reading_levels')->orderBy('order')->get();

        return view('admin.books.create', compact('categories', 'bookTypes', 'readingLevels'));
    }

    /**
     * Store a newly created book in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'contributors' => 'nullable',
            'license' => 'nullable|in:Buku Edisi Terbatas,Buku Edisi Umum',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'reading_level_id' => 'nullable|exists:reading_levels,id',
            'cover_image' => 'nullable|image|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:51200', // Max 50MB
            'categories' => 'nullable|array',
            'book_types' => 'nullable|array',
        ]);

        $slug = Str::slug($request->title);

        // Handle cover image upload
        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('covers', 'public');
        }

        // Handle PDF file upload
        $pdfFilePath = null;
        if ($request->hasFile('pdf_file')) {
            $pdfFilePath = $request->file('pdf_file')->store('books', 'public');
        }

        // Insert book
        $bookId = DB::table('books')->insertGetId([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'contributors' => $request->contributors,
            'license' => $request->license,
            'tahun_terbit' => $request->tahun_terbit ?: null,
            'reading_level_id' => $request->reading_level_id,
            'pdf_file' => $pdfFilePath,
            'cover_image' => $coverImagePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert book stats
        DB::table('book_stats')->insert([
            'book_id' => $bookId,
            'views_count' => 0,
            'likes_count' => 0,
            'reads_count' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Attach categories
        if ($request->has('categories')) {
            foreach ($request->categories as $categoryId) {
                DB::table('book_categories')->insert([
                    'book_id' => $bookId,
                    'category_id' => $categoryId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Attach book types
        if ($request->has('book_types')) {
            foreach ($request->book_types as $bookTypeId) {
                DB::table('book_book_type')->insert([
                    'book_id' => $bookId,
                    'book_type_id' => $bookTypeId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Display the specified book.
     */
    public function show($id)
    {
        $book = DB::table('books')->where('id', $id)->first();
        
        if (!$book) {
            abort(404);
        }

        $categories = DB::table('book_categories')
            ->join('categories', 'book_categories.category_id', '=', 'categories.id')
            ->where('book_categories.book_id', $id)
            ->select('categories.name')
            ->get();

        $bookTypes = DB::table('book_book_type')
            ->join('book_types', 'book_book_type.book_type_id', '=', 'book_types.id')
            ->where('book_book_type.book_id', $id)
            ->select('book_types.name')
            ->get();

        return view('admin.books.show', compact('book', 'categories', 'bookTypes'));
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit($id)
    {
        $book = DB::table('books')->where('id', $id)->first();
        
        if (!$book) {
            abort(404);
        }

        $categories = DB::table('categories')->orderBy('name')->get();
        $bookTypes = DB::table('book_types')->orderBy('name')->get();
        $readingLevels = DB::table('reading_levels')->orderBy('order')->get();

        // Get selected categories
        $selectedCategories = DB::table('book_categories')
            ->where('book_id', $id)
            ->pluck('category_id')
            ->toArray();

        // Get selected book types
        $selectedBookTypes = DB::table('book_book_type')
            ->where('book_id', $id)
            ->pluck('book_type_id')
            ->toArray();

        return view('admin.books.edit', compact(
            'book',
            'categories',
            'bookTypes',
            'readingLevels',
            'selectedCategories',
            'selectedBookTypes'
        ));
    }

    /**
     * Update the specified book in database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'contributors' => 'nullable',
            'license' => 'nullable|in:Buku Edisi Terbatas,Buku Edisi Umum',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'reading_level_id' => 'nullable|exists:reading_levels,id',
            'cover_image' => 'nullable|image|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:51200', // Max 50MB
            'categories' => 'nullable|array',
            'book_types' => 'nullable|array',
        ]);

        $slug = Str::slug($request->title);

        // Get current book data
        $book = DB::table('books')->where('id', $id)->first();
        $coverImagePath = $book->cover_image;
        $pdfFilePath = $book->pdf_file;
        
        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('covers', 'public');
        }

        // Handle PDF file upload
        if ($request->hasFile('pdf_file')) {
            $pdfFilePath = $request->file('pdf_file')->store('books', 'public');
        }

        // Update book
        DB::table('books')->where('id', $id)->update([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'contributors' => $request->contributors,
            'license' => $request->license,
            'tahun_terbit' => $request->tahun_terbit ?: null,
            'reading_level_id' => $request->reading_level_id,
            'pdf_file' => $pdfFilePath,
            'cover_image' => $coverImagePath,
            'updated_at' => now(),
        ]);

        // Update categories
        DB::table('book_categories')->where('book_id', $id)->delete();
        if ($request->has('categories')) {
            foreach ($request->categories as $categoryId) {
                DB::table('book_categories')->insert([
                    'book_id' => $id,
                    'category_id' => $categoryId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Update book types
        DB::table('book_book_type')->where('book_id', $id)->delete();
        if ($request->has('book_types')) {
            foreach ($request->book_types as $bookTypeId) {
                DB::table('book_book_type')->insert([
                    'book_id' => $id,
                    'book_type_id' => $bookTypeId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil diperbarui!');
    }

    /**
     * Remove the specified book from database.
     */
    public function destroy($id)
    {
        // Delete akan cascade ke book_categories dan book_book_type
        DB::table('books')->where('id', $id)->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus!');
    }
}
