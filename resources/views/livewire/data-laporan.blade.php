<div class="space-y-4">
    {{-- Search & Filter --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-2">
        <input type="text" wire:model.live="search"
            class="border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 text-sm w-full sm:w-1/3 dark:bg-zinc-900 dark:text-white"
            placeholder="Cari berdasar kode transaksi">

        <div class="flex gap-6">

            <flux:select wire:model.live="perPage">
                <flux:select.option value="5">5</flux:select.option>
                <flux:select.option value="10">10</flux:select.option>
                <flux:select.option value="15">15</flux:select.option>
            </flux:select>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto rounded-md">
        <table class="w-full text-sm text-left text-gray-700 dark:text-zinc-200 border dark:border-zinc-600">
            <thead class="text-xs uppercase bg-gray-100 dark:bg-zinc-700">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Kode Transaksi</th>
                    <th class="px-4 py-2">Total Harga</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2 text-center"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporans as $i => $lap)
                <tr class="border-b dark:border-zinc-600">
                    <td class="px-4 py-2">{{ ($laporans->currentPage() - 1) * $laporans->perPage() + $i + 1 }}</td>
                    <td class="px-4 py-2 font-medium">{{ $lap->kode }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($lap->total, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($lap->tanggal)->translatedFormat('d M Y') }}</td>
                    <td class="px-4 py-2 text-center">
                        <flux:button icon="eye" wire:click="showDetail('{{ $lap->kode }}')" />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        {{ $laporans->links() }}
    </div>

    {{-- Modal Detail --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 dark:bg-black/70">
        <div class="bg-white dark:bg-zinc-800 p-6 rounded shadow-md w-full max-w-2xl">
            <div class="flex justify-between mb-4 border-b pb-2">
                <h2 class="text-lg font-semibold">Detail Transaksi: {{ $selectedKode }}</h2>
                <button wire:click="$set('showModal', false)">❌</button>
            </div>
            <div class="space-y-2">
                @if($type === 'jual')
                @foreach($detailItems as $item)
                <div class="flex justify-between border-b pb-1">
                    <span>{{ $item->menu->nama }}</span>
                    <span>{{ $item->jumlah }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                </div>
                @endforeach
                @else
                @foreach($detailItems as $item)
                <div class="flex justify-between border-b pb-1">
                    <span>{{ $item->bahan->nama }}</span>
                    <span>{{ $item->jumlah }} x Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}</span>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
    @endif
</div>