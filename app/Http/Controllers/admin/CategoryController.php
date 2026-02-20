<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Daftar semua kategori.
     */
    public function index()
    {
        $categories = Category::withCount('books')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Kategori dengan nama ini sudah ada.',
            'name.max'      => 'Nama maksimal 100 karakter.',
        ]);

        Category::create([
            'name' => trim($request->name),
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori "' . $request->name . '" berhasil ditambahkan.');
    }

    /**
     * Update kategori.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Kategori dengan nama ini sudah ada.',
            'name.max'      => 'Nama maksimal 100 karakter.',
        ]);

        $category->update([
            'name' => trim($request->name),
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori "' . $request->name . '" berhasil diperbarui.');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(Category $category)
    {
        $name = $category->name;

        // Detach relasi buku sebelum hapus
        $category->books()->detach();
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori "' . $name . '" berhasil dihapus.');
    }
}
