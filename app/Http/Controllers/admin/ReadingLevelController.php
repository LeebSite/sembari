<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReadingLevel;
use Illuminate\Http\Request;

class ReadingLevelController extends Controller
{
    /**
     * Display a listing of the reading levels.
     */
    public function index()
    {
        $readingLevels = ReadingLevel::orderBy('order')->get();
        return view('admin.reading_levels.index', compact('readingLevels'));
    }

    /**
     * Store a newly created reading level in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'description' => 'nullable|string',
            'icon' => 'nullable|mimes:jpeg,png,jpg,svg,svg+xml|max:2048',
        ]);

        $data = $request->except('icon');

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('reading_levels/icons', 'public');
        }

        ReadingLevel::create($data);

        return redirect()->route('admin.reading-levels.index')
            ->with('success', 'Jenjang baca berhasil ditambahkan!');
    }

    /**
     * Update the specified reading level in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'description' => 'nullable|string',
            'icon' => 'nullable|mimes:jpeg,png,jpg,svg,svg+xml|max:2048',
        ]);

        $readingLevel = ReadingLevel::findOrFail($id);
        $data = $request->except('icon');

        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($readingLevel->icon && \Storage::disk('public')->exists($readingLevel->icon)) {
                \Storage::disk('public')->delete($readingLevel->icon);
            }
            $data['icon'] = $request->file('icon')->store('reading_levels/icons', 'public');
        }

        $readingLevel->update($data);

        return redirect()->route('admin.reading-levels.index')
            ->with('success', 'Jenjang baca berhasil diperbarui!');
    }

    /**
     * Remove the specified reading level from storage.
     */
    public function destroy($id)
    {
        $readingLevel = ReadingLevel::findOrFail($id);
        
        // Check if there are books associated with this level
        if ($readingLevel->books()->count() > 0) {
            return redirect()->route('admin.reading-levels.index')
                ->with('error', 'Tidak dapat menghapus jenjang baca karena masih ada buku yang terkait!');
        }

        $readingLevel->delete();

        return redirect()->route('admin.reading-levels.index')
            ->with('success', 'Jenjang baca berhasil dihapus!');
    }
}
