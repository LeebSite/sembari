<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\APengaturanController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReadingLevelController;
use App\Http\Middleware\AdminAuth;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\BookListController;
use App\Http\Controllers\Web\HelpController;
use App\Http\Controllers\Admin\TypeBookController;
use App\Http\Controllers\Admin\DaerahController;

// --- PUBLIC ROUTES ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/koleksi', [BookListController::class, 'index'])->name('book.list');
Route::get('/bantuan', [HelpController::class, 'index'])->name('help');
Route::get('/buku/{id}', [BookListController::class, 'show'])->name('book.show');
Route::post('/buku/{id}/like', [\App\Http\Controllers\Web\BookListController::class, 'toggleLike'])->name('book.like');
Route::get('/baca/{slug}', function ($slug) {
    $book = \App\Models\Book::where('slug', $slug)->orWhere('id', $slug)->firstOrFail();
    
    // Increment reads count
    $stat = $book->stat()->firstOrCreate(['book_id' => $book->id]);
    $stat->increment('reads_count');

    // Get pages
    $pagesPath = storage_path('app/public/books/' . $book->id . '/pages');
    $pages = [];
    if (file_exists($pagesPath)) {
        $files = \Illuminate\Support\Facades\File::files($pagesPath);
        // Sort naturally: page-1.jpg, page-2.jpg, ..., page-10.jpg
        usort($files, function($a, $b) {
            return strnatcmp($a->getFilename(), $b->getFilename());
        });

        foreach ($files as $file) {
            $pages[] = asset('storage/books/' . $book->id . '/pages/' . $file->getFilename());
        }
    }

    return view('public.flipbook', compact('book', 'pages'));
})->name('book.read');

// Manual Trigger for PDF Conversion (Debugging/Maintenance)
Route::get('/admin/books/{id}/process', function($id) {
    if (!auth()->check()) abort(403);
    $book = \App\Models\Book::findOrFail($id);
    \App\Jobs\ProcessBookPages::dispatchSync($book);
    return "Proses konversi selesai untuk buku: " . $book->title;
})->name('admin.books.process');


/*
|--------------------------------------------------------------------------
| AUTH ADMIN
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.submit');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ADMIN (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(AdminAuth::class)
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard.index');
        })->name('admin.dashboard');

        // ===== BUKU =====
        Route::resource('books', \App\Http\Controllers\Admin\BookController::class)->names([
            'index'   => 'admin.books.index',
            'create'  => 'admin.books.create',
            'store'   => 'admin.books.store',
            'show'    => 'admin.books.show',
            'edit'    => 'admin.books.edit',
            'update'  => 'admin.books.update',
            'destroy' => 'admin.books.destroy',
        ]);

        // ===== KATEGORI =====
        Route::resource('categories', CategoryController::class)->names([
            'index'   => 'admin.categories.index',
            'store'   => 'admin.categories.store',
            'update'  => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',
        ])->only(['index', 'store', 'update', 'destroy']);

               // ===== JENIS BUKU (LEGACY — tidak digunakan lagi) =====
       // Route type-book dipertahankan agar admin lama tidak error
       Route::resource('type-book', TypeBookController::class)->names([
            'index'   => 'admin.type-book.index',
            'store'   => 'admin.type-book.store',
            'update'  => 'admin.type-book.update',
            'destroy' => 'admin.type-book.destroy',
        ])->only(['index', 'store', 'update', 'destroy']);

        // ===== DAERAH =====
        Route::resource('daerah', DaerahController::class)->names([
            'index'   => 'admin.daerah.index',
            'store'   => 'admin.daerah.store',
            'update'  => 'admin.daerah.update',
            'destroy' => 'admin.daerah.destroy',
        ])->only(['index', 'store', 'update', 'destroy']);

        // ===== JENJANG BACA =====
        Route::resource('reading-levels', ReadingLevelController::class)->names([
            'index'   => 'admin.reading-levels.index',
            'store'   => 'admin.reading-levels.store',
            'update'  => 'admin.reading-levels.update',
            'destroy' => 'admin.reading-levels.destroy',
        ])->only(['index', 'store', 'update', 'destroy']);

        // ===== PENGATURAN =====
        Route::get('/pengaturan', [APengaturanController::class, 'index'])
            ->name('admin.pengaturan');

        Route::post('/pengaturan', [APengaturanController::class, 'store'])
            ->name('admin.pengaturan.store');

        Route::post('/pengaturan/update', [APengaturanController::class, 'update'])
            ->name('admin.pengaturan.update');

        Route::post('/pengaturan/delete', [APengaturanController::class, 'destroy'])
            ->name('admin.pengaturan.destroy');

    });

/*
|--------------------------------------------------------------------------
| MAINTENANCE ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/linkstorage', function () {
    $log = [];

    // Target storage yang berisi file upload
    $storagePath = storage_path('app/public');
    // /home/xjkvtwyw/sembari/storage/app/public

    // Web root yang benar-benar diakses browser (public_html)
    // Naik dari: sembari/ -> xjkvtwyw/ -> masuk ke public_html/
    $publicHtml  = realpath(base_path('/../public_html'));
    // Fallback: coba deteksi manual jika realpath gagal
    if (!$publicHtml) {
        $publicHtml = dirname(base_path()) . '/public_html';
    }

    // Daftar path symlink yang akan dicoba (prioritas: public_html dulu)
    $linkTargets = [
        $publicHtml . '/storage',                // public_html/storage  ← UTAMA
        public_path('storage'),                  // sembari/public/storage (backup)
    ];

    $log[] = "<b>Storage Source:</b> $storagePath";
    $log[] = "<b>public_html terdeteksi:</b> $publicHtml";
    $log[] = "---";

    // Fungsi rekursif hapus folder
    $deleteDir = function (string $dir) use (&$deleteDir): bool {
        if (!file_exists($dir)) return true;
        if (is_link($dir)) return unlink($dir);
        foreach (array_diff(scandir($dir), ['.', '..']) as $item) {
            $sub = $dir . DIRECTORY_SEPARATOR . $item;
            is_dir($sub) && !is_link($sub) ? $deleteDir($sub) : unlink($sub);
        }
        return rmdir($dir);
    };

    foreach ($linkTargets as $linkPath) {
        $log[] = "<b>Proses:</b> $linkPath";

        if (!file_exists(dirname($linkPath))) {
            $log[] = "&nbsp;&nbsp;❌ Folder induk tidak ditemukan, dilewati.";
            continue;
        }

        // Hapus jika sudah ada (folder asli atau symlink lama)
        if (file_exists($linkPath) || is_link($linkPath)) {
            if (is_link($linkPath)) {
                $target = readlink($linkPath);
                if ($target === $storagePath) {
                    $log[] = "&nbsp;&nbsp;✅ Symlink sudah benar, dilewati.";
                    continue;
                }
                unlink($linkPath);
                $log[] = "&nbsp;&nbsp;🗑️ Symlink lama (salah target) dihapus.";
            } else {
                $ok = $deleteDir($linkPath);
                $log[] = $ok
                    ? "&nbsp;&nbsp;🗑️ Folder asli berhasil dihapus."
                    : "&nbsp;&nbsp;❌ Gagal hapus folder asli (periksa permission).";
                if (!$ok) continue;
            }
        }

        // Buat symlink
        try {
            symlink($storagePath, $linkPath);
            $log[] = "&nbsp;&nbsp;✅ <span style='color:#4ade80'><b>Symlink berhasil dibuat!</b></span> → $storagePath";
        } catch (\Exception $e) {
            $log[] = "&nbsp;&nbsp;❌ Gagal: " . $e->getMessage();
        }
    }

    $output = implode("<br>", $log);

    return '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Storage Link</title>
    <style>
        body{font-family:sans-serif;background:#0f172a;display:flex;justify-content:center;align-items:flex-start;padding:50px;min-height:100vh;}
        .card{background:#1e293b;border-radius:16px;padding:40px;box-shadow:0 10px 40px rgba(0,0,0,.4);max-width:750px;width:100%;}
        h2{color:#818cf8;text-align:center;margin:0 0 24px;}
        .log{background:#0f172a;color:#a5b4fc;padding:20px;border-radius:10px;font-family:monospace;font-size:13px;line-height:2.2;word-break:break-all;}
        .btn{display:block;text-align:center;margin-top:24px;text-decoration:none;background:#6366f1;color:white;padding:12px 28px;border-radius:8px;font-weight:700;}
        .btn:hover{background:#4f46e5;}
    </style></head><body><div class="card">
    <h2>🔗 Storage Link Manager</h2>
    <div class="log">' . $output . '</div>
    <a class="btn" href="' . url('/') . '">← Kembali ke Home</a>
    </div></body></html>';
});



Route::get('/maintenance', function () {
    $log = [];
    
    // 1. Clear Caches
    try {
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        $log[] = "✅ Cache Cleared (View, Config, Route)";
    } catch (\Exception $e) {
        $log[] = "❌ Cache Clear Error: " . $e->getMessage();
    }

    // 2. Path Debugging
    $basePath = base_path();
    $publicPath = public_path();
    $storagePath = storage_path('app/public');
    
    $log[] = "----------------------------------";
    $log[] = "<b>Base Path:</b> " . $basePath;
    $log[] = "<b>Public Path (Laravel):</b> " . $publicPath;
    $log[] = "<b>Storage Target Path:</b> " . $storagePath;
    $log[] = "----------------------------------";

    // 3. STORAGE LINK ATTEMPT
    $linksAttempted = [];
    
    // Path 1: Default Laravel Public Path
    $linksAttempted[] = $publicPath . '/storage';
    
    // Path 2: Deteksi cPanel umum (naik satu level ke public_html)
    // Jika app ada di /home/user/sembari, maka public mungkin di /home/user/public_html
    $cpanelPublic = realpath($basePath . '/../public_html');
    if ($cpanelPublic) {
        $linksAttempted[] = $cpanelPublic . '/storage';
        $linksAttempted[] = $cpanelPublic . '/sembari/storage'; // Jika subfolder
    }
    
    // Path 3: Deteksi jika app ada di subfolder public_html
    $cpanelSub = realpath($basePath . '/../../public_html');
    if ($cpanelSub) {
        $linksAttempted[] = $cpanelSub . '/storage';
    }

    $linkSuccess = false;
    foreach ($linksAttempted as $linkPath) {
        if (file_exists($linkPath)) {
            if (is_link($linkPath)) {
                $target = readlink($linkPath);
                $log[] = "ℹ️ Link ditemukan di: <b>$linkPath</b><br>&nbsp;&nbsp;&nbsp;Mengarah ke: $target";
                if ($target === $storagePath) {
                    $log[] = "✅ <span style='color:green'>LINK INI BENAR!</span>";
                    $linkSuccess = true;
                } else {
                    $log[] = "⚠️ <span style='color:orange'>Link salah sasaran!</span>";
                }
            } else {
                $log[] = "⚠️ <b>$linkPath</b> ada tapi BUKAN LINK (Folder/File Asli). Hapus manual via File Manager!";
            }
        } else {
            // Coba buat link
            try {
                // Pastikan folder induk ada
                $parentDir = dirname($linkPath);
                if (!file_exists($parentDir)) {
                     $log[] = "❌ Gagal buat link di <b>$linkPath</b>: Folder induk ($parentDir) tidak ditemukan.";
                     continue;
                }

                symlink($storagePath, $linkPath);
                $log[] = "✅ <span style='color:green'>BERHASIL membuat link baru di:</span> <b>$linkPath</b>";
                $linkSuccess = true;
            } catch (\Exception $e) {
                $log[] = "❌ Gagal membuat link di <b>$linkPath</b>: " . $e->getMessage();
            }
        }
    }

    // Output
    $output = implode("<br><br>", $log);
    
    $statusIcon = $linkSuccess ? '✅' : '⚠️';
    $statusMsg = $linkSuccess ? 'Storage Link Berhasil Dibuat/Ditemukan' : 'Periksa Log di Bawah';

    return '<div style="font-family:sans-serif; padding:50px; background:#f8fafc; color:#1e293b; min-height:100vh; display:flex; flex-direction:column; align-items:center;">
                <div style="background:white; padding:40px; border-radius:16px; box-shadow:0 10px 25px rgba(0,0,0,0.1); max-width:800px; width:100%;">
                    <div style="text-align:center; margin-bottom:20px;">
                        <span style="font-size:40px;">'.$statusIcon.'</span>
                        <h2 style="color:#6366f1; margin:10px 0;">'.$statusMsg.'</h2>
                    </div>
                    
                    <div style="background:#1e293b; color:#a5b4fc; padding:20px; border-radius:8px; font-family:monospace; font-size:13px; line-height:1.6; word-break:break-all;">
                        ' . $output . '
                    </div>
                    
                    <div style="margin-top:20px; text-align:center; font-size:13px; color:#64748b;">
                        Tips: Jika link sudah benar tapi gambar tetap 404, pastikan permission folder <b>storage/app/public</b> adalah 755 atau 777.
                    </div>

                    <div style="text-align:center; margin-top:30px;">
                        <a href="'.url('/').'" style="text-decoration:none; background:#6366f1; color:white; padding:12px 24px; border-radius:8px; font-weight:600;">Kembali ke Home</a>
                    </div>
                </div>
            </div>';
});
