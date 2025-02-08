<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Kategori;
class SearchForm extends Component
{
    public $categories = [];

    public function render()
    {
        return view('livewire.search-form');
    }
}
