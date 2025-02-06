<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\KategoriController;
use App\Models\Photo;
use App\Models\Kategori;


Route::get('/', function () {
    $photos = Photo::with(['kategori', 'images'])->latest()->get();
    return view('welcome', compact('photos')); // Pastikan data photos tetap dikirim
})->name('welcome');
// Route untuk admin dan pegawai, di dalam grup 'admin' 
Route::prefix('admin')->middleware(['auth', 'role:admin|pegawai'])->group(function () {
    Route::get('/dashboard', function () {
        $photos = Photo::with(['kategori', 'images'])->latest()->get();
        $kategoris = Kategori::all();
        return view('admin.dashboard', compact('photos', 'kategoris'));
    });

    // CRUD routes untuk photo dan kategori
    Route::resource('photos', PhotoController::class)->except('show'); 
    Route::post('/admin/photos/bulk-delete', [PhotoController::class, 'bulkDelete'])->name('photos.bulkDelete');


    Route::resource('kategoris', KategoriController::class);
});

// Route untuk akses profile bagi authenticated user
Route::view('profile', 'profile')
    ->middleware(['auth', 'verified'])
    ->name('profile');

// Route untuk dashboard bagi authenticated user
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'role:admin|pegawai'])
    ->name('dashboard');

// Route untuk show foto yang bisa diakses oleh siapa saja
Route::get('photos/{photo}', [PhotoController::class, 'show'])->name('photos.show');

// Untuk autentikasi
require __DIR__ . '/auth.php';
