<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Kategori;
use Livewire\Attributes\On;

class SearchForm extends Component
{
    public $selectedCategory = null;
    public $searchTerm = '';
    public $categories;

    public function mount()
    {
        $this->categories = Kategori::all();
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
    }

    public function performSearch()
    {
        if ($this->selectedCategory) {
            return redirect()->route('search.index', ['category' => $this->selectedCategory]);
        } elseif (!empty($this->searchTerm)) {
            return redirect()->route('search.index', ['query' => $this->searchTerm]);
        }
    }

    public function render()
    {
        return view('livewire.search-form');
    }
}