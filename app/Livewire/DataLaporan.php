<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\LogStok;
use Illuminate\Http\Request;

class DataLaporan extends Component
{
    use WithPagination;

    public $type;
    public $search = '';
    public $perPage = 10;

    public $selectedKode;
    public $detailItems = [];
    public $showModal = false;

    public function mount(Request $request)
    {
        $this->type = $request->route('type');
    }

    public function showDetail($kode)
    {
        $this->selectedKode = $kode;
        if ($this->type === 'jual') {
            $this->detailItems = Transaksi::where('kode', $kode)
                ->with('menu')
                ->get();
        } else {
            $this->detailItems = LogStok::where('kode', $kode)
                ->with('bahan')
                ->get();
        }
        $this->showModal = true;
    }

    public function render()
    {
        if ($this->type === 'jual') {
            $data = Transaksi::where('kode', 'like', "%{$this->search}%")
                ->select('kode', DB::raw('SUM(harga * jumlah) as total'), DB::raw('MAX(created_at) as tanggal'))
                ->groupBy('kode')
                ->orderByDesc('tanggal')
                ->paginate($this->perPage);
        } else {
            $data = LogStok::where('jenis', 'IN')
                ->where('kode', 'like', "%{$this->search}%")
                ->select('kode', DB::raw('SUM(harga * jumlah) as total'), DB::raw('MAX(created_at) as tanggal'))
                ->groupBy('kode')
                ->orderByDesc('tanggal')
                ->paginate($this->perPage);
        }

        return view('livewire.data-laporan', [
            'laporans' => $data
        ]);
    }
}
