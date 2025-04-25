<?php

namespace App\Livewire;

use App\Models\Bahan;
use Livewire\Component;

class SelectBahan extends Component
{
    public $bahans;
    public function mount()
    {
        $this->bahans = Bahan::all();
    }

    public function selectBahan($bahan)
    {
        $this->dispatch('bahan_id', id: $bahan);
    }
    public function render()
    {
        return view('livewire.select-bahan');
    }
}
