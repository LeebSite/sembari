<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\APengaturanController;
use App\Http\Middleware\AdminAuth;
use App\Http\Controllers\Web\HomeController;

// --- PUBLIC ROUTES ---
Route::get('/', [HomeController::class, 'index'])->name('home');

// --- EBOOK VIEWER (PUBLIC) ---
Route::get('/baca/{slug}', function () {
    return view('flipbook');
})->name('book.read');

Route::get('/flipbook', function () {
    return view('flipbook');
});

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
            'index' => 'admin.books.index',
            'create' => 'admin.books.create',
            'store' => 'admin.books.store',
            'show' => 'admin.books.show',
            'edit' => 'admin.books.edit',
            'update' => 'admin.books.update',
            'destroy' => 'admin.books.destroy',
        ]);

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
