<?php

namespace App\Livewire;

use App\Models\Transaksi;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ListPembelian extends Component
{
    use WithPagination, WithoutUrlPagination;


    public function mount() {}

    public function fetchData()
    {
        return Transaksi::where('jenis', true)->distinct('kode')->paginate(5);
    }
    public function render()
    {
        $transaksis = $this->fetchData();

        return view('livewire.list-pembelian', compact('transaksis'));
    }
}
