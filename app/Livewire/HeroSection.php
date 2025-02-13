<?php

namespace App\Livewire;

use Livewire\Component;

class HeroSection extends Component
{

    public $count;
    public function render()
    {
        return view('livewire.hero-section');
    }
}
