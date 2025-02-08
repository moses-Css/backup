<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Kategori;

class KategoriTab extends Component
{
    public $categories = [];
    public $activeCategory = 'all';

    public function mount()
    {
        $this->categories = Kategori::all(); // Ambil semua data kategori
    }

    public function filterCategory($categoryId)
    {
        $this->activeCategory = $categoryId;
        $this->dispatch('categoryChanged', $categoryId);
    }

    public function render()
    {
        return view('livewire.kategori-tab', [
            'categories' => $this->categories,
            'activeCategory' => $this->activeCategory
        ]);
    }
}