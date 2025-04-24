<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class TotalDisplay extends Component
{

    public $total = 0;

    #[On('totalDisplay')]
    public function updateTotal($total)
    {
        $this->total = $total;
    }
    public function render()
    {
        return view('livewire.total-display');
    }
}
