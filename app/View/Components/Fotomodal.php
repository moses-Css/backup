<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Kategori;

class Fotomodal extends Component
{
   public $kategoris;
    public function __construct()
    {
        $this -> kategoris = Kategori::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.foto-modal');
    }
}
