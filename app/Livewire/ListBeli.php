<?php

namespace App\Livewire;

use App\Models\Bahan;
use App\Models\LogStok;
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

    public function updated($field)
    {
        if (in_array($field, ['newJumlah', 'newHarga'])) {
            $this->recalculateNewTotal();
        }
    }

    public function recalculateNewTotal()
    {
        $jumlah = (int) $this->newJumlah;
        $harga = (int) $this->newHarga;

        if ($jumlah > 0 && $harga > 0) {
            $total = $jumlah * $harga;
            $this->newHargaRupiah = number_format($harga, 0, ',', '.');
            $this->dispatch('update-total', total: number_format($total, 0, ',', '.'));
        }
    }

    public function addToList()
    {
        // Validasi sederhana
        if (!$this->newBahan || !$this->newJumlah || !$this->newHarga) {
            $this->addError('newBahan', 'Semua field harus diisi');
            return;
        }

        $this->list[] = [
            'bahan' => $this->newBahan,
            'bahanNama' => $this->newBahan->nama,
            'jumlah' => $this->newJumlah,
            'harga' => $this->newHarga,
            'hargaRupiah' => $this->newHargaRupiah,
            'keterangan' => $this->newKeterangan ?? '-'
        ];

        // Reset & hitung ulang
        $this->totalSum();
        $this->reset('newBahan', 'newJumlah', 'newHarga', 'newHargaRupiah', 'newKeterangan');
    }

    public function removeList($index)
    {
        $bahan = $this->list[$index]['bahan'] ?? null;
        if ($bahan) {
            // Dispatch ke SelectBahan untuk mengembalikan bahan
            $this->dispatch('return_bahan', id: $bahan->id);
        }

        unset($this->list[$index]);
        $this->list = array_values($this->list);
        $this->totalSum();
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


    public function saveList()
    {
        $kode = 'IN' . fake()->numerify('-###-###-###');
        $data = [];
        foreach ($this->list as $key => $value) {
            $jumlahKonversi = $value['bahan']->konversi * $value['jumlah'];
            $data[] = [
                'jenis' => 'IN',
                'kode' => $kode,
                'bahan_id' => $value['bahan']->id,
                'jumlah' => $jumlahKonversi,
                'keterangan' => $value['keterangan'],
                'harga' => $value['harga'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        LogStok::insert($data);
        $this->reset();
        $this->totalSum();
    }


    public function render()
    {
        return view('livewire.list-beli');
    }
}
