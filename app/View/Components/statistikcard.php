<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class statistikcard extends Component
{

    public $title;
    public $count;
    public $icon;

    public function __construct($title = 'Total Foto', $count = 0, $icon = '')
    {
        $this->title = $title;
        $this->count = $count;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.statistik-card');
    }
}
