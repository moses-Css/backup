<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Icon extends Component
{
    public $name;
    public $class;

    protected $icons = [
        'x-mark' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M204.24,195.76a6,6,0,1,1-8.48,8.48L128,136.49,60.24,204.24a6,6,0,0,1-8.48-8.48L119.51,128,51.76,60.24a6,6,0,0,1,8.48-8.48L128,119.51l67.76-67.75a6,6,0,0,1,8.48,8.48L136.49,128Z"></path></svg>',
        'images-square' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M208,34H80A14,14,0,0,0,66,48V66H48A14,14,0,0,0,34,80V208a14,14,0,0,0,14,14H176a14,14,0,0,0,14-14V190h18a14,14,0,0,0,14-14V48A14,14,0,0,0,208,34ZM78,48a2,2,0,0,1,2-2H208a2,2,0,0,1,2,2v74.2l-20.1-20.1a14,14,0,0,0-19.8,0L94.2,178H80a2,2,0,0,1-2-2ZM178,208a2,2,0,0,1-2,2H48a2,2,0,0,1-2-2V80a2,2,0,0,1,2-2H66v98a14,14,0,0,0,14,14h98Zm30-30H111.17l67.41-67.41a2,2,0,0,1,2.83,0L210,139.17V176A2,2,0,0,1,208,178Zm-88-68A22,22,0,1,0,98,88,22,22,0,0,0,120,110Zm0-32a10,10,0,1,1-10,10A10,10,0,0,1,120,78Z"></path></svg>',
    ];

    public function __construct($name, $class = '')
    {
        $this->name = $name;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.icon', ['icons' => $this->icons]);
    }
}