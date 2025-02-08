<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Photo;

class GaleriGrid extends Component
{
    public $activeCategory = 'all';

    protected $listeners = ['categoryChanged' => 'updateCategory'];

    public function updateCategory($category)
    {
        $this->activeCategory = $category;
    }

    public function render()
    {
        // ✅ Ambil data dengan relasi
        $query = Photo::with('images', 'group.kategori');

        if ($this->activeCategory !== 'all') {
            // ✅ Filter berdasarkan kategori dari group, bukan langsung di photo
            $query->whereHas('group', function ($q) {
                $q->where('kategori_id', $this->activeCategory);
            });
        }

        $photos = $query->get();

        return view('livewire.galeri-grid', ['photos' => $photos]);
    }
}
