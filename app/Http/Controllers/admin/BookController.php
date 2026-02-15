<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of books.
     */
    public function index()
    {
        $books = DB::table('books')
            ->leftJoin('reading_levels', 'books.reading_level_id', '=', 'reading_levels.id')
            ->leftJoin('licenses', 'books.license_id', '=', 'licenses.id')
            ->select(
                'books.*',
                'reading_levels.label as reading_level',
                'licenses.name as license_name'
            )
            ->orderBy('books.created_at', 'desc')
            ->paginate(10);

        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create()
    {
        $readingLevels = DB::table('reading_levels')->get();
        $licenses = DB::table('licenses')->get();
        $categories = DB::table('categories')->get();
        $authors = DB::table('authors')->orderBy('name')->get();

        return view('admin.books.create', compact('readingLevels', 'licenses', 'categories', 'authors'));
    }

    /**
     * Store a newly created book in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'cover_image' => 'nullable|image|max:2048',
            'reading_level_id' => 'nullable|exists:reading_levels,id',
            'license_id' => 'nullable|exists:licenses,id',
        ]);

        $slug = Str::slug($request->title);

        // Handle cover image upload
        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('covers', 'public');
        }

        // Insert book
        $bookId = DB::table('books')->insertGetId([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'cover_image' => $coverImagePath,
            'reading_level_id' => $request->reading_level_id,
            'license_id' => $request->license_id,
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

        // Attach contributors (authors)
        if ($request->has('penulis')) {
            foreach ($request->penulis as $authorId) {
                DB::table('book_contributors')->insert([
                    'book_id' => $bookId,
                    'author_id' => $authorId,
                    'role' => 'penulis',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        if ($request->has('penerjemah')) {
            foreach ($request->penerjemah as $authorId) {
                DB::table('book_contributors')->insert([
                    'book_id' => $bookId,
                    'author_id' => $authorId,
                    'role' => 'penerjemah',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        if ($request->has('ilustrator')) {
            foreach ($request->ilustrator as $authorId) {
                DB::table('book_contributors')->insert([
                    'book_id' => $bookId,
                    'author_id' => $authorId,
                    'role' => 'ilustrator',
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

        $contributors = DB::table('book_contributors')
            ->join('authors', 'book_contributors.author_id', '=', 'authors.id')
            ->where('book_contributors.book_id', $id)
            ->select('authors.name', 'book_contributors.role')
            ->get();

        $categories = DB::table('book_categories')
            ->join('categories', 'book_categories.category_id', '=', 'categories.id')
            ->where('book_categories.book_id', $id)
            ->select('categories.name')
            ->get();

        return view('admin.books.show', compact('book', 'contributors', 'categories'));
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

        $readingLevels = DB::table('reading_levels')->get();
        $licenses = DB::table('licenses')->get();
        $categories = DB::table('categories')->get();
        $authors = DB::table('authors')->orderBy('name')->get();

        // Get selected categories
        $selectedCategories = DB::table('book_categories')
            ->where('book_id', $id)
            ->pluck('category_id')
            ->toArray();

        // Get selected contributors
        $selectedPenulis = DB::table('book_contributors')
            ->where('book_id', $id)
            ->where('role', 'penulis')
            ->pluck('author_id')
            ->toArray();

        $selectedPenerjemah = DB::table('book_contributors')
            ->where('book_id', $id)
            ->where('role', 'penerjemah')
            ->pluck('author_id')
            ->toArray();

        $selectedIlustrator = DB::table('book_contributors')
            ->where('book_id', $id)
            ->where('role', 'ilustrator')
            ->pluck('author_id')
            ->toArray();

        return view('admin.books.edit', compact(
            'book',
            'readingLevels',
            'licenses',
            'categories',
            'authors',
            'selectedCategories',
            'selectedPenulis',
            'selectedPenerjemah',
            'selectedIlustrator'
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
            'cover_image' => 'nullable|image|max:2048',
            'reading_level_id' => 'nullable|exists:reading_levels,id',
            'license_id' => 'nullable|exists:licenses,id',
        ]);

        $slug = Str::slug($request->title);

        // Handle cover image upload
        $book = DB::table('books')->where('id', $id)->first();
        $coverImagePath = $book->cover_image;
        
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('covers', 'public');
        }

        // Update book
        DB::table('books')->where('id', $id)->update([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'cover_image' => $coverImagePath,
            'reading_level_id' => $request->reading_level_id,
            'license_id' => $request->license_id,
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

        // Update contributors
        DB::table('book_contributors')->where('book_id', $id)->delete();
        
        if ($request->has('penulis')) {
            foreach ($request->penulis as $authorId) {
                DB::table('book_contributors')->insert([
                    'book_id' => $id,
                    'author_id' => $authorId,
                    'role' => 'penulis',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        if ($request->has('penerjemah')) {
            foreach ($request->penerjemah as $authorId) {
                DB::table('book_contributors')->insert([
                    'book_id' => $id,
                    'author_id' => $authorId,
                    'role' => 'penerjemah',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        if ($request->has('ilustrator')) {
            foreach ($request->ilustrator as $authorId) {
                DB::table('book_contributors')->insert([
                    'book_id' => $id,
                    'author_id' => $authorId,
                    'role' => 'ilustrator',
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
        DB::table('books')->where('id', $id)->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus!');
    }
}
