<div class="space-y-4">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-2">
        <input type="text" wire:model.live="search"
            class="border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 text-sm w-full sm:w-1/3 dark:bg-zinc-900 dark:text-white"
            placeholder="Cari nama bahan...">

        <div class="flex gap-6">
            <flux:button icon="plus" wire:click="openCreateForm">Tambah Bahan</flux:button>
            <flux:select wire:model.live="perPage">
                <flux:select.option value="5">5</flux:select.option>
                <flux:select.option value="10">10</flux:select.option>
                <flux:select.option value="15">15</flux:select.option>
            </flux:select>
        </div>
    </div>



    <div class="overflow-x-auto rounded-md">
        <table class="w-full text-sm text-left text-gray-700 dark:text-zinc-200 border dark:border-zinc-600">
            <thead class="text-xs uppercase bg-gray-100 dark:bg-zinc-700">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Nama Bahan</th>
                    <th class="px-4 py-2">Stok</th>
                    <th class="px-4 py-2 w-1/6 text-center"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bahans as $index => $bahan)
                <tr class="border-b dark:border-zinc-600">
                    <td class="px-4 py-2">{{ ($bahans->currentPage() - 1) * $bahans->perPage() + $index + 1 }}</td>
                    <td class="px-4 py-2 font-medium">{{ $bahan->nama }}</td>
                    <td class="px-4 py-2">
                        {{ $bahan->total_stok['besar'] }} {{ $bahan->satuanBesar->nama ?? '-' }} -
                        {{ $bahan->total_stok['kecil'] }} {{ $bahan->satuanKecil->nama ?? '-' }}
                    </td>
                    <td class="px-4 py-2 text-center">
                        <flux:button icon="pencil" wire:click="openEditForm({{ $bahan->id }})" class="ml-2">
                        </flux:button>
                        <flux:button icon="trash" wire:click="confirmDelete({{ $bahan->id }})" class="ml-2"
                            variant="danger"></flux:button>
                        <flux:button icon="adjustments-horizontal" class="ml-2" variant="primary" color="amber"
                            wire:click="openOpname({{ $bahan->id }})">
                        </flux:button>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        {{ $bahans->links() }}
    </div>

    {{-- Modal Form --}}
    @if($showFormModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 dark:bg-black/70">
        <div class="bg-white dark:bg-zinc-800 text-black dark:text-white p-6 rounded shadow-md w-full max-w-lg">
            <div class="flex justify-between mb-4 border-b pb-2">
                <h2 class="text-lg font-semibold">{{ $isEditing ? 'Edit' : 'Tambah' }} Bahan</h2>
                <button wire:click="$set('showFormModal', false)">❌</button>
            </div>

            <div class="space-y-4">
                <input type="text" wire:model.live="form.nama" placeholder="Nama Bahan"
                    class="w-full border px-3 py-2 rounded dark:bg-zinc-900">

                <input type="number" wire:model.live="form.konversi"
                    placeholder="Jumlah Konversi (berapa kecil per besar)"
                    class="w-full border px-3 py-2 rounded dark:bg-zinc-900">

                <select wire:model.live="form.besar_id" class="w-full border px-3 py-2 rounded dark:bg-zinc-900">
                    <option value="">-- Pilih Satuan Besar --</option>
                    @foreach($allSatuan as $satuan)
                    <option value="{{ $satuan->id }}">{{ $satuan->nama }}</option>
                    @endforeach
                </select>

                <select wire:model.live="form.kecil_id" class="w-full border px-3 py-2 rounded dark:bg-zinc-900">
                    <option value="">-- Pilih Satuan Kecil --</option>
                    @foreach($allSatuan as $satuan)
                    <option value="{{ $satuan->id }}">{{ $satuan->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4 flex justify-end gap-2">
                <button wire:click="$set('showFormModal', false)"
                    class="px-4 py-2 bg-gray-300 dark:bg-zinc-600 rounded">Batal</button>
                <button wire:click="save" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal Delete --}}
    @if($showDeleteConfirm)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-md dark:bg-black/70">
        <div class="bg-white dark:bg-zinc-800 text-black dark:text-white p-6 rounded shadow-md w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Hapus Bahan</h2>
            <p>Apakah kamu yakin ingin menghapus bahan ini?</p>
            <div class="mt-6 flex justify-end gap-3">
                <button wire:click="$set('showDeleteConfirm', false)"
                    class="px-4 py-2 bg-gray-300 dark:bg-zinc-600 rounded">Batal</button>
                <button wire:click="delete" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
            </div>
        </div>
    </div>
    @endif

    @if($showOpnameModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 dark:bg-black/70">
        <div class="bg-white dark:bg-zinc-800 text-black dark:text-white p-6 rounded shadow-md w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Stok Opname: {{ $selectedBahan?->nama }}</h2>


            <p class="mb-2 text-sm">
                Stok saat ini: {{ $selectedBahan?->getTotalStok()['besar'] }} {{ $selectedBahan?->satuanBesar->nama ??
                '' }}
            </p>

            <input type="number" wire:model.live="stokOpnameInput"
                class="w-full border px-3 py-2 rounded dark:bg-zinc-900"
                placeholder="Jumlah stok nyata (satuan besar)" />



            <div class="mt-6 flex justify-end gap-3">
                <button wire:click="$set('showOpnameModal', false)"
                    class="px-4 py-2 bg-gray-300 dark:bg-zinc-600 rounded">Batal</button>
                <button wire:click="saveOpname" class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
            </div>
        </div>
    </div>
    @endif
</div>