<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderCreate extends Component
{
    /**
     * Create a new component instance.
     */
    public $title;
    public $description;
    public $route;
    public $buttonText;
    public $breadcrumbTitle;
    public $breadcrumbActive;


    public function __construct($title, $description, $route, $buttonText, $breadcrumbTitle, $breadcrumbActive)
    {
        $this->title = $title;
        $this->description = $description;
        $this->route = $route;
        $this->buttonText = $buttonText;
        $this->breadcrumbTitle = $breadcrumbTitle;
        $this->breadcrumbActive = $breadcrumbActive;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header-create');
    }
}
