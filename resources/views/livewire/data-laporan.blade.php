<div>
    {{-- Header --}}
    <div class="grid grid-cols-1 md:grid-cols-2 justify-between mb-6">
        <div class="text-4xl font-semibold text-primary-700">
            Laporan {{ $type === 'jual' ? 'Penjualan' : 'Pembelian' }}
        </div>

        <div class="flex flex-wrap gap-3 justify-end mt-4 md:mt-0">
            <input type="text" wire:model.live="search"
                class="bg-primary-50 border border-primary-300 text-primary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full md:w-52 p-2.5"
                placeholder="Cari kode transaksi">

            <select wire:model.live="filterBulan"
                class="bg-primary-50 border border-primary-300 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2.5">
                <option value="">Semua Bulan</option>
                @for ($m = 1; $m <= 12; $m++) <option value="{{ $m }}">{{
                    \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                    @endfor
            </select>

            <select wire:model.live="filterTahun"
                class="bg-primary-50 border border-primary-300 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2.5">
                <option value="">Semua Tahun</option>
                @for ($y = now()->year; $y >= now()->year - 5; $y--)
                <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>

            <select wire:model.live="perPage"
                class="bg-primary-50 border border-primary-300 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2.5 w-24">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
            </select>

            <button wire:click="exportExcel"
                class="text-white bg-primary-600 hover:bg-primary-700 font-medium rounded-lg text-sm px-4 py-2">
                <i class="fa-solid fa-file-excel mr-1"></i> Download
            </button>
        </div>
    </div>

    {{-- Table --}}
    <div class="relative overflow-x-auto rounded-lg shadow-sm">
        <table class="w-full text-sm text-left text-primary-500">
            <thead class="text-xs uppercase bg-primary-200 text-primary-700">
                <tr>
                    <th class="px-6 py-3 text-center">#</th>
                    <th class="px-6 py-3 text-center">Kode Transaksi</th>
                    <th class="px-6 py-3 text-center">Total Harga</th>
                    <th class="px-6 py-3 text-center">Tanggal</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporans as $i => $lap)
                <tr class="odd:bg-white even:bg-primary-100 text-primary-900 border-b border-primary-200">
                    <td class="px-6 py-4 text-center">{{ ($laporans->currentPage() - 1) * $laporans->perPage() + $i + 1
                        }}</td>
                    <td class="px-6 py-4 text-center">{{ $lap->kode }}</td>
                    <td class="px-6 py-4 text-center">Rp {{ number_format($lap->total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center">{{ \Carbon\Carbon::parse($lap->tanggal)->translatedFormat('d M Y')
                        }}</td>
                    <td class="px-6 py-4 text-center">
                        <button wire:click="showDetail('{{ $lap->kode }}')"
                            class="text-white bg-info-700 hover:bg-info-800 font-medium rounded-md text-xs px-2 py-1">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr class="text-center text-primary-700">
                    <td colspan="5" class="py-6">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 px-4">
            {{ $laporans->links() }}
        </div>
    </div>

    {{-- Modal Detail --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 flex justify-center items-center bg-black/50 backdrop-blur-md">
        <div class="w-full max-w-3xl bg-white rounded-lg shadow dark:bg-zinc-800 p-6">
            <div class="flex items-start justify-between border-b pb-3 mb-4">
                <h3 class="text-lg font-bold text-primary-900 dark:text-white">
                    Detail Transaksi: {{ $selectedKode }}
                </h3>
                <button wire:click="$set('showModal', false)"
                    class="text-primary-700 hover:text-white hover:bg-primary-600 rounded-full p-1">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <table class="w-full text-sm text-left border dark:border-zinc-600">
                <thead class="bg-primary-100 dark:bg-zinc-700 text-primary-900 dark:text-white">
                    <tr>
                        <th class="p-2 border dark:border-zinc-600">Nama</th>
                        @if($type === 'jual')
                        <th class="p-2 border dark:border-zinc-600">Jumlah x Harga</th>
                        @else
                        <th class="p-2 border dark:border-zinc-600">Keterangan</th>
                        <th class="p-2 border dark:border-zinc-600">Jumlah x Harga</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-800 text-primary-900 dark:text-zinc-100">
                    @if($type === 'jual')
                    @foreach($detailItems as $item)
                    <tr>
                        <td class="p-2 border dark:border-zinc-600">{{ $item->menu->nama }}</td>
                        <td class="p-2 border dark:border-zinc-600">
                            {{ $item->jumlah }} x Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                    @else
                    @foreach($detailItems as $item)
                    <tr>
                        <td class="p-2 border dark:border-zinc-600">{{ $item->bahan->nama }}</td>
                        <td class="p-2 border dark:border-zinc-600">{{ $item->keterangan ?? '-' }}</td>
                        <td class="p-2 border dark:border-zinc-600">
                            {{ round($item->jumlah / $item->bahan->konversi, 1) }}
                            {{ $item->bahan->satuanBesar->nama }} x
                            Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>