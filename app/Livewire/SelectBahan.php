<?php

namespace App\Livewire;

use App\Models\Bahan;
use Livewire\Component;

class SelectBahan extends Component
{
    public $bahans, $bahan_id, $selectedBahan;
    public $availableBahans;

    public function mount()
    {
        $this->bahans = Bahan::all();
        $this->availableBahans = $this->bahans;
    }

    public function updatedBahanId()
    {
        $this->selectedBahan = $this->bahans->firstWhere('id', $this->bahan_id);
    }

    public function confirmSelect()
    {
        if ($this->bahan_id) {
            $this->dispatch('bahan_id', id: $this->bahan_id);
            // Hapus dari dropdown
            $this->availableBahans = $this->availableBahans->reject(fn($item) => $item->id == $this->bahan_id);
            // Reset selected
            $this->bahan_id = null;
            $this->selectedBahan = null;
        }
    }

    #[\Livewire\Attributes\On('return_bahan')]
    public function returnBahan($id)
    {
        $bahan = $this->bahans->firstWhere('id', $id);
        if ($bahan && !$this->availableBahans->contains('id', $id)) {
            $this->availableBahans->push($bahan);
        }
    }

    public function render()
    {
        return view('livewire.select-bahan');
    }
}
