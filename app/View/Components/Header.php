<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    /**
     * Create a new component instance.
     */
    public $title;
    public $subtitle;
    public $route;
    public $buttonText;

    public function __construct($title, $subtitle, $route, $buttonText)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->route = $route;
        $this->buttonText = $buttonText;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header');
    }
}
