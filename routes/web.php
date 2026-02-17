<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\APengaturanController;
use App\Http\Middleware\AdminAuth;

// Test route
Route::get('/test-admin', function () {
    return view('test-admin');
});

Route::get('/', function () {
    return view('welcome');
});

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
            return view('admin.dashboard');
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
