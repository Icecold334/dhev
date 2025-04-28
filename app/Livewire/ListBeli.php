<?php

namespace App\Livewire;

use App\Models\Bahan;
use App\Models\Pembelian;
use App\Models\Transaksi;
use Livewire\Attributes\On;
use Livewire\Component;

class ListBeli extends Component
{
    public $list = [], $newBahan, $newHarga, $newHargaRupiah, $newJumlah, $newKeterangan;


    #[On('bahan_id')]
    public function fillNewRow($id)
    {
        $bahan = Bahan::find($id);
        $this->newBahan = $bahan;
    }

    public function updated($field) {}
    public function addToList()
    {
        $this->list[] = [
            'bahan' => $this->newBahan,
            'bahanNama' => $this->newBahan->nama,
            'jumlah' => $this->newJumlah,
            'harga' => $this->newHarga,
            'hargaRupiah' => $this->newHargaRupiah,
            'keterangan' => $this->newKeterangan ?? '-'
        ];
        $this->totalSum();
        $this->reset('newBahan', 'newJumlah', 'newHarga', 'newKeterangan');
    }

    public function totalSum()
    {
        $total = collect($this->list)->sum(function ($item) {
            return (int)$item['jumlah'] * (int)$item['harga'];
        });

        $this->dispatch('totalDisplay', total: $total);
        $this->dispatch('listBeli', list: $this->list);
        return $total;
    }

    public function removeList($index)
    {
        unset($this->list[$index]); // Hapus item dari array
        $this->list = array_values($this->list); // Reset index array agar tetap berurutan
        $this->totalSum();
    }

    public function saveList()
    {
        $kode = 'IN' . fake()->numerify('-###-###-###');
        $data = [];
        foreach ($this->list as $key => $value) {
            $jumlahKonversi = $value['bahan']->konversi * $value['jumlah'];
            $data[] = [
                'kode' => $kode,
                'jenis' => true,
                'bahan_id' => $value['bahan']->id,
                'jumlah' => $jumlahKonversi,
                'keterangan' => $value['keterangan'],
                'harga' => $value['harga'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        Pembelian::insert($data);
        $this->reset();
        $this->totalSum();
    }


    public function render()
    {
        return view('livewire.list-beli');
    }
}
