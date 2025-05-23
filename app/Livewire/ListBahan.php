<?php

namespace App\Livewire;

use App\Models\Bahan;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ListBahan extends Component
{
    use WithPagination, WithoutUrlPagination;
    public function fetchData()
    {
        return Bahan::paginate(5);
    }


    public function render()
    {
        $bahans = $this->fetchData();
        // Tambahkan total stok ke setiap item
        foreach ($bahans as $bahan) {
            $bahan->total_stok = $bahan->getTotalStok();
        }

        return view('livewire.list-bahan', compact('bahans'));
    }
}
