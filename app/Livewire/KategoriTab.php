<?php

namespace App\Livewire;

use Livewire\Component;

class KategoriTab extends Component
{
    public $categories = ['all', 'minggu', 'hutri', 'sabtu', 'pancasila', 'perayaan', 'sosial'];
    public $activeCategory = 'all';

    public function filterCategory($category)
    {
        $this->activeCategory = $category;
        $this->dispatch('categoryChanged', $category); // ✅ Panggil emit dengan benar
    }

    public function render()
    {
        return view('livewire.kategori-tab', [
            'categories' => $this->categories,
            'activeCategory' => $this->activeCategory
        ]);
    }
}
