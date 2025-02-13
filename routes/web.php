<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ActivityLogsController;
use App\Models\Photo;
use App\Models\Kategori;

Route::get('/', function () {
    $photos = Photo::with(['kategori', 'images'])->latest()->get();
    return view('welcome', compact('photos'));
})->name('welcome');

// Route untuk admin dan pegawai
Route::prefix('admin')->middleware(['auth', 'role:admin|pegawai'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // CRUD routes untuk foto dan kategori
    Route::resource('photos', PhotoController::class)->except('show');
    Route::post('/photos/bulk-delete', [PhotoController::class, 'bulkDelete'])->name('photos.bulkDelete');

    Route::resource('kategoris', KategoriController::class);
});

Route::middleware(['auth', 'role:admin|pegawai'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::delete('/logs/clear', [ActivityLogsController::class, 'clearAllLogs'])->name('logs.clear');
    Route::delete('/logs/{id}', [ActivityLogsController::class, 'deleteLog'])->name('logs.delete');
});

// Route untuk akses profile
Route::view('profile', 'profile')->middleware(['auth', 'verified'])->name('profile');

// Route untuk dashboard agar sesuai dengan lokasi blade (`resources/views/dashboard.blade.php`)
Route::get('dashboard', [AdminController::class, 'dashboard'])->middleware(['auth', 'role:admin|pegawai'])->name('dashboard');

// Route untuk menampilkan foto yang bisa diakses siapa saja
Route::get('photos/{photo}', [PhotoController::class, 'show'])->name('photos.show');

// Untuk autentikasi
require __DIR__ . '/auth.php';
