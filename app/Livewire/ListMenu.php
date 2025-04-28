<?php

namespace App\Livewire;

use Livewire\Component;

class ListMenu extends Component
{

    public $menus = [
        [
            'name' => 'Nasi Goreng',
            'price' => 25000,
            'image' => 'https://flowbite.com/docs/images/examples/image-1.jpg',
        ],
        [
            'name' => 'Mie Ayam',
            'price' => 20000,
            'image' => 'https://flowbite.com/docs/images/examples/image-2.jpg',
        ],
        [
            'name' => 'Es Teh Manis',
            'price' => 8000,
            'image' => 'https://flowbite.com/docs/images/examples/image-3.jpg',
        ],
    ];
    public function render()
    {
        return view('livewire.list-menu');
    }
}
