<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithStyles,
    WithEvents,
    WithTitle,
    ShouldAutoSize
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanExport implements FromCollection, WithStyles, WithEvents, WithTitle, ShouldAutoSize
{
    protected $data;
    protected $info;

    public function __construct(Collection $data, array $info = [])
    {
        $this->data = $data;
        $this->info = $info;
    }

    public function collection()
    {
        function format_rupiah($angka)
        {
            return 'Rp ' . number_format($angka, 0, ',', '.');
        }

        $rows = collect([
            ['Laporan ' . $this->info['type']],
            ['Tanggal Export:', $this->info['tanggal_export']],
            ['Filter Bulan:', $this->info['filter_bulan'] ?? 'Semua Bulan'],
            ['Filter Tahun:', $this->info['filter_tahun'] ?? 'Semua Tahun'],
            ['Total Transaksi:', $this->info['total_transaksi']],
            ['Total Nominal:', format_rupiah($this->info['total_nominal'])],
            ['No', 'Kode Transaksi', 'Tanggal', 'Total'],
        ]);


        $dataRows = $this->data->values()->map(function ($item, $index) {
            return [
                $index + 1,
                $item->kode,
                \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y H:i'),
                'Rp ' . number_format($item->total, 0, ',', '.'),
            ];
        });

        return $rows->concat($dataRows)->values();
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A1' => [
                'font' => ['bold' => true, 'size' => 16],
                'alignment' => ['horizontal' => 'center'],
            ],
            7 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = 7 + $this->data->count();

                // Judul merge
                $event->sheet->mergeCells('A1:D1');
                $event->sheet->freezePane('A7');
                $event->sheet->setAutoFilter("A7:D7");

                // Styling header
                $event->sheet->getStyle('A7:D7')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => 'facc15'], // kuning
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);
            }
        ];
    }

    public function title(): string
    {
        return 'Laporan ' . $this->info['type'];
    }
}
