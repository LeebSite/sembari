<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeBook;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TypeBookController extends Controller
{
    /**
     * Daftar semua jenis buku.
     */
    public function index()
    {
        // Menggunakan withCount agar variabel $type->books_count tersedia di Blade
        $types = TypeBook::withCount('books')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.type_book.index', compact('types'));
    }

    /**
     * Simpan jenis buku baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:book_types,name',
        ], [
            'name.required' => 'Nama jenis buku wajib diisi.',
            'name.unique'   => 'Jenis buku dengan nama ini sudah ada.',
            'name.max'      => 'Nama maksimal 100 karakter.',
        ]);

        TypeBook::create([
            'name' => trim($request->name),
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.type-book.index')
            ->with('success', 'Jenis buku "' . $request->name . '" berhasil ditambahkan.');
    }

    /**
     * Update jenis buku.
     */
    public function update(Request $request, $id)
    {
        $typeBook = TypeBook::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:book_types,name,' . $typeBook->id,
        ], [
            'name.required' => 'Nama jenis buku wajib diisi.',
            'name.unique'   => 'Jenis buku dengan nama ini sudah ada.',
            'name.max'      => 'Nama maksimal 100 karakter.',
        ]);

        $typeBook->update([
            'name' => trim($request->name),
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.type-book.index')
            ->with('success', 'Jenis buku "' . $request->name . '" berhasil diperbarui.');
    }

    /**
     * Hapus jenis buku.
     */
    public function destroy($id)
    {
        $typeBook = TypeBook::findOrFail($id);
        $name = $typeBook->name;
    
        $typeBook->books()->detach(); 

        $typeBook->delete();
    
        return redirect()->route('admin.type-book.index')
            ->with('success', 'Jenis buku "' . $name . '" berhasil dihapus.');
    }
}