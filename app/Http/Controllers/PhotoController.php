<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Kategori;
use App\Models\Image;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Intervention\Image\Facades\Image as ImageIntervention;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLogs;
use App\Helpers\LogHelper;



class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $totalPhotos = Photo::count();
        $totalCategories = Kategori::count();
        $totalUser = User::count();

        $photos = Photo::with(['kategori', 'images'])->latest()->get();
        return view('admin.photos.index', compact('photos'));
    }

    public function search(Request $request)
    {
        $categoryId = $request->query('category');
        $searchTerm = $request->query('query');

        if ($categoryId) {
            // Search by category
            $kategori = Kategori::findOrFail($categoryId);
            $groups = $kategori->groups()
                ->with(['photos.images'])
                ->get();

            return view('search.index', [
                'type' => 'category',
                'kategori' => $kategori,
                'groups' => $groups
            ]);
        } elseif ($searchTerm) {
            // Search by group title
            $groups = Group::where('title', 'like', "%{$searchTerm}%")
                ->with(['photos.images'])
                ->get();

            $images = $groups->flatMap(function ($group) {
                return $group->photos->flatMap->images;
            });

            return view('search.index', [
                'type' => 'query',
                'searchTerm' => $searchTerm,
                'images' => $images
            ]);
        }

        return view('search.index');
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

        // **Ambil nama kategori berdasarkan kategori_id**
        $kategori = Kategori::find($request->kategori_id);

        if (!$kategori) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        // **1. Buat grup baru**
        $group = Group::create([
            'kategori_id' => $request->kategori_id,
            'title' => $request->title,
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
            $folderPath = "photos/{$group->id}";
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs($folderPath, $filename, 'public');

            $photo->images()->create([
                'path' => $path,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'waktu' => $request->tanggal ? now() : null,
            ]);
        }

        // **4. Simpan log aktivitas**
        ActivityLogs::create([
            'user_id'   => Auth::id(),
            'action'    => 'Mengunggah foto',
            'timestamp' => now(),
            'activity'  => "Menambahkan Foto \"{$request->title}\" di Kategori \"{$kategori->nama}\"",
            'created_at' => now(),
        ]);

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
