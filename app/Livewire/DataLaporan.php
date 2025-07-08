<?php

namespace App\Livewire;

use App\Models\LogStok;
use Livewire\Component;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Exports\LaporanExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DataLaporan extends Component
{
    use WithPagination;

    public $type;
    public $search = '';
    public $perPage = 10;
    public $filterBulan;
    public $filterTahun;

    public $selectedKode;
    public $detailItems = [];
    public $showModal = false;

    public function mount(Request $request)
    {
        $this->type = $request->route('type');
    }
    public function exportExcel()
    {
        if ($this->type === 'jual') {
            $query = Transaksi::query()
                ->select('kode', DB::raw('SUM(harga * jumlah) as total'), DB::raw('MAX(created_at) as tanggal'))
                ->where('kode', 'like', "%{$this->search}%");

            if ($this->filterBulan) {
                $query->whereMonth('created_at', $this->filterBulan);
            }

            if ($this->filterTahun) {
                $query->whereYear('created_at', $this->filterTahun);
            }

            $query->groupBy('kode')->orderByDesc('tanggal');
        } else {
            $query = LogStok::query()
                ->where('jenis', 'IN')
                ->select('kode', DB::raw('SUM(harga * jumlah) as total'), DB::raw('MAX(created_at) as tanggal'))
                ->where('kode', 'like', "%{$this->search}%");

            if ($this->filterBulan) {
                $query->whereMonth('created_at', $this->filterBulan);
            }

            if ($this->filterTahun) {
                $query->whereYear('created_at', $this->filterTahun);
            }

            $query->groupBy('kode')->orderByDesc('tanggal');
        }

        $data = $query->get();

        $info = [
            'type' => $this->type === 'jual' ? 'Penjualan' : 'Pembelian',
            'tanggal_export' => now()->translatedFormat('l, d F Y'),
            'total_transaksi' => $data->count(),
            'total_nominal' => $data->sum('total'),
            'filter_bulan' => $this->filterBulan
                ? \Carbon\Carbon::create()->month((int)$this->filterBulan)->translatedFormat('F')
                : 'Semua Bulan',

            'filter_tahun' => $this->filterTahun ?: 'Semua Tahun',
        ];

        $filename = 'Laporan_' . $info['type'] . '_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new LaporanExport($data, $info), $filename);
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
            $query = Transaksi::query()
                ->select('kode', DB::raw('SUM(harga * jumlah) as total'), DB::raw('MAX(created_at) as tanggal'))
                ->where('kode', 'like', "%{$this->search}%");

            if ($this->filterBulan) {
                $query->whereMonth('created_at', $this->filterBulan);
            }

            if ($this->filterTahun) {
                $query->whereYear('created_at', $this->filterTahun);
            }

            $query->groupBy('kode')->orderByDesc('tanggal');
            $data = $query->paginate($this->perPage);
        } else {
            $query = LogStok::query()
                ->where('jenis', 'IN')
                ->select('kode', DB::raw('SUM(harga * jumlah) as total'), DB::raw('MAX(created_at) as tanggal'))
                ->where('kode', 'like', "%{$this->search}%");

            if ($this->filterBulan) {
                $query->whereMonth('created_at', $this->filterBulan);
            }

            if ($this->filterTahun) {
                $query->whereYear('created_at', $this->filterTahun);
            }

            $query->groupBy('kode')->orderByDesc('tanggal');
            $data = $query->paginate($this->perPage);
        }

        return view('livewire.data-laporan', [
            'laporans' => $data
        ]);
    }
}
