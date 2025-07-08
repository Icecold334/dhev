<?php

namespace App\View\Components;

use Closure;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Sideitem extends Component
{
    public $href;
    public $title;
    public $active;
    public $icon;

    public function __construct($href, $title,  $icon, $active)
    {
        $this->href = $href;
        $this->title = $title;
        $this->icon = $icon;
        $this->active = $active;
        // dump(Str::startsWith(request()->getPathInfo() . '/', rtrim($href, '/') . '/'), $href);
        // test
        // $this->active = Str::startsWith(request()->getPathInfo() . '/', rtrim($href, '/') . '/');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sideitem');
    }
}
