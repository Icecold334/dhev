<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\LogStok;
use App\Models\ListMenu;
use App\Models\Bahan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KasirPenjualan extends Component
{
    public $cart = [], $search = ''; // format: [menu_id => jumlah]

    public function mount() {}
    public function tambahMenu($menuId)
    {
        if (isset($this->cart[$menuId])) {
            $this->cart[$menuId]++;
        } else {
            $this->cart[$menuId] = 1;
        }
    }

    public function kurangiMenu($menuId)
    {
        if (isset($this->cart[$menuId]) && $this->cart[$menuId] > 1) {
            $this->cart[$menuId]--;
        } else {
            unset($this->cart[$menuId]);
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

                // Ambil list bahan
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
            $this->dispatch(
                'toast',
                type: 'success',
                message: 'Transaksi berhasil!'
            );

            $this->reset('cart');
        });
    }

    public function render()
    {
        $menus = Menu::where('slug', 'like', '%' . Str::slug($this->search) . '%')->get();
        return view('livewire.kasir-penjualan', compact('menus'));
    }
}
