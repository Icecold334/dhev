<?php

namespace App\Livewire;

use App\Models\Menu;
use Livewire\Component;

class ListMenu extends Component
{

    public $menus;

    public function mount()
    {
        $this->menus = Menu::all();
    }
    public function render()
    {
        return view('livewire.list-menu');
    }
}
