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
            ->select('books.*')
            ->orderBy('books.created_at', 'desc')
            ->paginate(10);

        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create()
    {
        $categories = DB::table('categories')->orderBy('name')->get();
        $bookTypes = DB::table('book_types')->orderBy('name')->get();

        return view('admin.books.create', compact('categories', 'bookTypes'));
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
            'cover_image' => 'nullable|image|max:2048',
            'categories' => 'nullable|array',
            'book_types' => 'nullable|array',
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
            'contributors' => $request->contributors,
            'license' => $request->license,
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
            'cover_image' => 'nullable|image|max:2048',
            'categories' => 'nullable|array',
            'book_types' => 'nullable|array',
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
            'contributors' => $request->contributors,
            'license' => $request->license,
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
