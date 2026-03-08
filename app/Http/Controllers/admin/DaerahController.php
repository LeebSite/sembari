<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Daerah;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DaerahController extends Controller
{
    /**
     * Daftar semua daerah.
     */
    public function index()
    {
        $daerahList = Daerah::withCount('books')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.daerah.index', compact('daerahList'));
    }

    /**
     * Simpan daerah baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:daerah,name',
        ], [
            'name.required' => 'Nama daerah wajib diisi.',
            'name.unique'   => 'Daerah dengan nama ini sudah ada.',
            'name.max'      => 'Nama maksimal 100 karakter.',
        ]);

        Daerah::create([
            'name' => trim($request->name),
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.daerah.index')
            ->with('success', 'Daerah "' . $request->name . '" berhasil ditambahkan.');
    }

    /**
     * Update daerah.
     */
    public function update(Request $request, $id)
    {
        $daerah = Daerah::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:daerah,name,' . $daerah->id,
        ], [
            'name.required' => 'Nama daerah wajib diisi.',
            'name.unique'   => 'Daerah dengan nama ini sudah ada.',
            'name.max'      => 'Nama maksimal 100 karakter.',
        ]);

        $daerah->update([
            'name' => trim($request->name),
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.daerah.index')
            ->with('success', 'Daerah "' . $request->name . '" berhasil diperbarui.');
    }

    /**
     * Hapus daerah.
     * Buku yang terhubung akan tetap ada, daerah_id-nya akan menjadi NULL (ON DELETE SET NULL).
     */
    public function destroy($id)
    {
        $daerah = Daerah::findOrFail($id);
        $name   = $daerah->name;

        $daerah->delete(); // FK ON DELETE SET NULL akan mengosongkan daerah_id di books

        return redirect()->route('admin.daerah.index')
            ->with('success', 'Daerah "' . $name . '" berhasil dihapus.');
    }
}
