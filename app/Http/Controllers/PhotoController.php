<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Kategori;
use App\Models\Image;
use App\Models\Group;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Intervention\Image\Facades\Image as ImageIntervention;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;



class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photos = Photo::with(['kategori', 'images'])->latest()->get();
        return view('admin.photos.index', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.photos.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'kategori_id' => 'required|exists:kategoris,id',
        'title' => 'required|max:255', // Judul grup
        'deskripsi' => 'nullable|string',
        'tanggal' => 'nullable|date',
        'lokasi' => 'nullable|string',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'images'   => 'required|array',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:20480',
    ], [
        'images.*.max' => 'Ukuran file :attribute tidak boleh lebih dari 20MB.',
    ], [
        'images.*' => 'gambar',
    ]);


    // **1. Buat grup baru otomatis**
    $group = Group::create([
        'kategori_id' => $request->kategori_id,
        'title' => $request->title, // Nama grup dari input
        'deskripsi' => $request->deskripsi,
    ]);
    // **2. Buat satu entri di tabel `photos` untuk grup tersebut**
    $photo = $group->photos()->create([
        'kategori_id' => $request->kategori_id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // **3. Simpan semua gambar dalam tabel `images`**
    foreach ($request->file('images') as $file) {
        $folderPath = "photos/{$group->id}"; // Simpan berdasarkan grup
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs($folderPath, $filename, 'public');

        // Simpan informasi gambar
        $photo->images()->create([
            'path' => $path,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'waktu' => $request->tanggal ? now() : null,
        ]);
    }

    return redirect()->route('photos.index')->with('success', 'Photo berhasil disimpan dalam grup baru.');
}


    // Tambahkan method edit, update, show, destroy

    private function convertGps($gps, $hemisphere)
    {
        // Implementasi konversi GPS seperti sebelumnya
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        return view('admin.photos.show', compact('photo'));  // Make sure to create 'show.blade.php'
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        $kategoris = Kategori::all();
        return view('admin.photos.edit', compact('photo', 'kategoris'));  // Make sure to create 'edit.blade.php'
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'title' => 'required|max:255',
            'deskripsi' => 'required',
            'tanggal' => 'required|date',
            'lokasi' => 'required',
        ]);

        $photo->update($request->only('kategori_id', 'title', 'deskripsi', 'tanggal', 'lokasi'));

        return redirect()->route('photos.index');  // Redirect back to the list page
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        foreach ($photo->images as $image) {
            $imagePath = $image->path; // Adjusted here

            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            } else {
                Log::error('Image not found: ' . $imagePath);
            }
        }

        $photo->forceDelete();
        return redirect()->route('photos.index');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'exists:photos,id',
        ]);

        $photos = Photo::whereIn('id', $request->photos)->get();

        foreach ($photos as $photo) {
            foreach ($photo->images as $image) {
                $imagePath = $image->path; // Perbaiki path

                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                } else {
                    Log::error('Image not found: ' . $imagePath);
                }
            }

            $photo->forceDelete();
        }

        return redirect()->route('photos.index')->with('success', 'Selected photos deleted successfully.');
    }
}
