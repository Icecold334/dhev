<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\LogStok;
use App\Models\ListMenu;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KasirPenjualan extends Component
{
    public $cart = [], $search = '';

    public function tambahMenu($menuId)
    {
        $menu = Menu::findOrFail($menuId);
        $jumlahSaatIni = $this->cart[$menuId] ?? 0;
        $jumlahBaru = $jumlahSaatIni + 1;

        if (!$this->cekStokMenu($menuId, $jumlahBaru)) {
            $this->dispatch('toast', type: 'error', message: 'Stok bahan untuk "' . $menu->nama . '" tidak cukup untuk ' . $jumlahBaru . ' porsi.');
            return;
        }

        $this->cart[$menuId] = $jumlahBaru;
    }

    public function kurangiMenu($menuId)
    {
        if (!isset($this->cart[$menuId])) return;

        $jumlahBaru = $this->cart[$menuId] - 1;

        if ($jumlahBaru <= 0) {
            unset($this->cart[$menuId]);
        } else {
            $this->cart[$menuId] = $jumlahBaru;
        }
    }

    public function simpanTransaksi()
    {
        DB::transaction(function () {
            $kode = 'TRX-' . strtoupper(Str::random(6));

            foreach ($this->cart as $menuId => $jumlah) {
                $menu = Menu::findOrFail($menuId);

                $transaksi = Transaksi::create([
                    'kode' => $kode,
                    'menu_id' => $menuId,
                    'jumlah' => $jumlah,
                    'harga' => $menu->harga,
                    'keterangan' => null,
                ]);

                $listBahan = ListMenu::where('menu_id', $menuId)->get();

                foreach ($listBahan as $item) {
                    $totalJumlah = $item->jumlah * $jumlah;

                    LogStok::create([
                        'jenis' => 'OUT',
                        'kode' => 'OUT-' . now()->format('d-m-s') . '-' . rand(100, 999),
                        'transaksi_id' => $transaksi->id,
                        'bahan_id' => $item->bahan_id,
                        'jumlah' => $totalJumlah,
                        'harga' => null,
                        'keterangan' => 'Pengurangan karena penjualan',
                    ]);
                }
            }

            $this->dispatch('toast', type: 'success', message: 'Transaksi berhasil!');
            $this->reset(['cart', 'search']);
        });
    }

    private function cekStokMenu($menuId, $jumlahTotal): bool
    {
        $listBahan = ListMenu::where('menu_id', $menuId)->get();

        foreach ($listBahan as $item) {
            $stok = $item->bahan->getTotalStok()['kecil'];
            $kebutuhan = $item->jumlah * $jumlahTotal;

            if ($stok < $kebutuhan) {
                return false;
            }
        }

        return true;
    }

    public function render()
    {
        $menus = Menu::where('slug', 'like', '%' . Str::slug($this->search) . '%')->get();

        $menus = $menus->sortBy(function ($menu) {
            foreach ($menu->listMenus as $item) {
                $stok = $item->bahan->getTotalStok()['kecil'];
                $kebutuhan = $item->jumlah * (($this->cart[$menu->id] ?? 0) + 1);

                if ($stok < $kebutuhan) {
                    return 1; // stok kurang → tampil di bawah
                }
            }
            return 0; // stok cukup → tampil di atas
        });

        return view('livewire.kasir-penjualan', compact('menus'));
    }
}
