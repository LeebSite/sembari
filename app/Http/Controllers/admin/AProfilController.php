<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class AProfilController extends Controller
{
    public function visiMisi()
    {
        $profil = DB::table('profil')->where('profil_id', 1)->first();
    
        return view('admin.profil.visimisi', [
            'visi' => $profil->visi ?? '',
            'misi' => isset($profil->misi)
                ? preg_split("/\r\n|\n|\r/", $profil->misi)
                : [],
        ]);
    }

    public function updateVisiMisi(Request $request)
{
    $validated = $request->validate([
        'visi' => 'required|string',
        'misi' => 'required|string',
    ]);

    $misiBersih = collect(
        preg_split("/\r\n|\n|\r/", $validated['misi'])
    )
    ->map(function ($item) {
        // hapus "1. ", "2. ", dst
        return preg_replace('/^\s*\d+\.\s*/', '', trim($item));
    })
    ->filter()
    ->implode("\n");

    DB::table('profil')
        ->where('profil_id', 1)
        ->update([
            'visi'       => $validated['visi'],
            'misi'       => $misiBersih,
            'updated_at' => now(),
        ]);

    return response()->json([
        'message' => 'Visi & Misi berhasil disimpan',
    ]);
}

    public function tugasFungsi()
    {
        $profil = DB::table('profil')
            ->where('profil_id', 1)
            ->first();
    
        return view('admin.profil.tugasfungsi', [
            'tugas' => $profil->tugas ?? '',
            'fungsi' => isset($profil->fungsi)
                ? preg_split("/\r\n|\n|\r/", $profil->fungsi)
                : [],
        ]);
    }

    public function updateTugasFungsi(Request $request)
{
    $validated = $request->validate([
        'tugas'  => 'required|string',
        'fungsi' => 'required|string',
    ]);

    $fungsiBersih = collect(
        preg_split("/\r\n|\n|\r/", $validated['fungsi'])
    )
    ->map(function ($item) {
        // hapus "1. ", "2. ", "3. " dst
        return preg_replace('/^\s*\d+\.\s*/', '', trim($item));
    })
    ->filter()
    ->implode("\n");

    DB::table('profil')
        ->where('profil_id', 1)
        ->update([
            'tugas'      => $validated['tugas'],
            'fungsi'     => $fungsiBersih,
            'updated_at' => now(),
        ]);

    return response()->json([
        'message' => 'Tugas & Fungsi berhasil disimpan',
    ]);
}


    public function pegawai(Request $request)
    {
        $search = $request->query('search');
    
        // Helper function (via private method)
        $processFoto = function ($item) {
            return $this->getFotoUrl($item);
        };
    
        $kepalaBalai = DB::table('pegawai')
            ->where('jabatan', 'Kepala Balai')
            ->first();
        $kepalaBalai = $this->getFotoUrl($kepalaBalai);
    
        $kasubbagUmum = DB::table('pegawai')
            ->where('jabatan', 'Kasubbag Umum')
            ->first();
        $kasubbagUmum = $this->getFotoUrl($kasubbagUmum);
    
        $pegawai = DB::table('pegawai')
            ->when($search, function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%");
            })
            ->whereNotIn('jabatan', ['Kepala Balai', 'Kasubbag Umum'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($item) {
                return $this->getFotoUrl($item);
            });
    
        return view('admin.profil.pegawai', compact(
            'pegawai',
            'kepalaBalai',
            'kasubbagUmum'
        ));
    }

    public function storePegawai(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string',
            'jabatan' => 'required|string',
            'foto'    => 'required|image|max:2048',
        ]);

        $fotoPath = $request->file('foto')->store('pegawai', 'public');

        DB::table('pegawai')->insert([
            'nama'       => $request->nama,
            'jabatan'    => $request->jabatan,
            'foto'       => $fotoPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.profil.pegawai')
            ->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function updatePegawai(Request $request, $id)
    {
        $request->validate([
            'nama'    => 'required|string',
            'jabatan' => 'required|string',
            'foto'    => 'nullable|image|max:2048',
        ]);

        $pegawai = DB::table('pegawai')->where('pegawai_id', $id)->first();
        if (!$pegawai) {
            return back()->with('error', 'Data pegawai tidak ditemukan');
        }

        $data = [
            'nama'       => $request->nama,
            'jabatan'    => $request->jabatan,
            'updated_at' => now(),
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if (!empty($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            // Simpan foto baru
            $data['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        DB::table('pegawai')->where('pegawai_id', $id)->update($data);

        return redirect()
            ->route('admin.profil.pegawai')
            ->with('success', 'Data pegawai berhasil diperbarui');
    }

    public function destroyPegawai($id)
    {
        $pegawai = DB::table('pegawai')->where('pegawai_id', $id)->first();
        if (!$pegawai) {
            return back()->with('error', 'Data pegawai tidak ditemukan');
        }

        // ❗ CATATAN: Foto TIDAK dihapus karena mungkin dipakai oleh riwayat struktur organisasi
        // Jika ingin menghapus foto juga, uncomment code berikut:
        // if (!empty($pegawai->foto)) {
        //     Storage::disk('public')->delete($pegawai->foto);
        // }

        DB::table('pegawai')->where('pegawai_id', $id)->delete();

        return redirect()
            ->route('admin.profil.pegawai')
            ->with('success', 'Pegawai berhasil dihapus (foto disimpan untuk arsip)');
    }


    public function strukturorganisasi(Request $request)
{
    // ambil semua riwayat
    $riwayat = DB::table('struktur_organisasi')
        ->orderByDesc('created_at')
        ->get();

    // struktur aktif (default)
    $strukturAktif = DB::table('struktur_organisasi')
        ->where('status', 1)
        ->first();

    // kalau klik riwayat
    if ($request->filled('struktur')) {
        $strukturAktif = DB::table('struktur_organisasi')
            ->where('struktur_id', $request->struktur)
            ->first();
    }

    // default null (INI PENTING)
    $kepalaBalai = null;
    $kasubbagUmum = null;

    if ($strukturAktif) {
        $kepalaBalai = $strukturAktif->kepala_balai
            ? json_decode($strukturAktif->kepala_balai)
            : null;
        $kepalaBalai = $this->getFotoUrl($kepalaBalai);

        $kasubbagUmum = $strukturAktif->kasubbag_umum
            ? json_decode($strukturAktif->kasubbag_umum)
            : null;
        $kasubbagUmum = $this->getFotoUrl($kasubbagUmum);
    }

    return view('admin.profil.strukturorganisasi', compact(
        'strukturAktif',
        'kepalaBalai',
        'kasubbagUmum',
        'riwayat'
    ));
}


 private function buatSnapshotStruktur()
{
    $kepala = DB::table('pegawai')
        ->where('jabatan', 'Kepala Balai')
        ->first();

    $kasubbag = DB::table('pegawai')
        ->where('jabatan', 'Kasubbag Umum')
        ->first();

    if (!$kepala && !$kasubbag) {
        return;
    }

    // nonaktifkan struktur lama
    DB::table('struktur_organisasi')
        ->where('status', 1)
        ->update(['status' => 0]);

    DB::table('struktur_organisasi')->insert([
        'versi' => now()->year,
        'kepala_balai' => $kepala ? json_encode([
            'pegawai_id' => $kepala->pegawai_id,
            'nama'       => $kepala->nama,
            'jabatan'    => $kepala->jabatan,
            'foto'       => $kepala->foto,
        ]) : null,

        'kasubbag_umum' => $kasubbag ? json_encode([
            'pegawai_id' => $kasubbag->pegawai_id,
            'nama'       => $kasubbag->nama,
            'jabatan'    => $kasubbag->jabatan,
            'foto'       => $kasubbag->foto,
        ]) : null,

        'status'     => 1,
        'created_at'=> now(),
        'updated_at'=> now(),
    ]);
}



    public function updateStrategis(Request $request)
{
    $updated = false;

    if ($request->kepala_id) {

        $data = [
            'nama'       => $request->kepala_nama,
            'jabatan'    => 'Kepala Balai',
            'updated_at' => now(),
        ];

        if ($request->hasFile('kepala_foto')) {
            $data['foto'] = $request->file('kepala_foto')->store('pegawai', 'public');
        }

        DB::table('pegawai')
            ->where('pegawai_id', $request->kepala_id)
            ->update($data);

        $updated = true;
    }

    if ($request->kasubbag_id) {

        $data = [
            'nama'       => $request->kasubbag_nama,
            'jabatan'    => 'Kasubbag Umum',
            'updated_at' => now(),
        ];

        if ($request->hasFile('kasubbag_foto')) {
            $data['foto'] = $request->file('kasubbag_foto')->store('pegawai', 'public');
        }

        DB::table('pegawai')
            ->where('pegawai_id', $request->kasubbag_id)
            ->update($data);

        $updated = true;
    }

    // 🔥 INI KUNCI UTAMANYA
    if ($updated) {
        $this->buatSnapshotStruktur();
    }

    return redirect()
        ->route('admin.profil.pegawai')
        ->with('success', 'Jabatan strategis berhasil diperbarui');
}



    private function getFotoUrl($item)
    {
        if ($item && isset($item->foto) && $item->foto) {
            $foto = preg_replace(
                '#^(storage/|/storage/|img/pegawai/|/img/pegawai/|pegawai/|/pegawai/)#',
                '',
                ltrim($item->foto, '/')
            );
            $item->foto_url = asset('storage/pegawai/' . $foto);
        } elseif ($item) {
            $item->foto_url = asset('img/default-user.png');
        }
        return $item;
    }
}