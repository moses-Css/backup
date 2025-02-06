<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Kategori;
use App\Models\Image;
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
            'title' => 'required|max:255',
            'deskripsi' => 'required',
            'tanggal' => 'required|date',
            'lokasi' => 'required',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Menyimpan data foto
        $photo = Photo::create($request->except('images'));

        // Menyimpan gambar
        foreach ($request->file('images') as $file) {
            // Simpan file di folder 'photos' dalam 'storage/app/public'
            $path = $file->store('photos', 'public');  // Gunakan disk 'public'

            // Simpan path gambar ke database
            $photo->images()->create([
                'path' => $path, // Simpan path langsung tanpa mengubah 'public/'
            ]);
        }

        return redirect()->route('photos.index');
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
