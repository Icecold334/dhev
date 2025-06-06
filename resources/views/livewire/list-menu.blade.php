<div class="space-y-4">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-2">
        <input type="text" wire:model.live="search"
            class="border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 text-sm w-full sm:w-1/3 dark:bg-zinc-900 dark:text-white"
            placeholder="Cari nama menu...">

        <div class="flex gap-6">
            <flux:button icon="plus" wire:click="openCreateForm">Tambah Menu</flux:button>
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
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Harga</th>
                    <th class="px-4 py-2 w-1/6 "></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $index => $menu)
                <tr class="border-b dark:border-zinc-600">
                    <td class="px-4 py-2">{{ ($menus->currentPage() - 1) * $menus->perPage() + $index + 1 }}</td>
                    <td class="px-4 py-2 font-medium">{{ $menu->nama }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 text-center">
                        <flux:button icon="eye" wire:click="showDetail({{ $menu->id }})"></flux:button>
                        <flux:button icon="pencil" wire:click="openEditForm({{ $menu->id }})" class="ml-2">
                        </flux:button>
                        <flux:button icon="trash" wire:click="confirmDelete({{ $menu->id }})" class="ml-2"
                            variant="danger"></flux:button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        {{ $menus->links() }}
    </div>

    {{-- Modal Detail --}}
    @if ($showModal && $selectedMenu)
    <div class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-md bg-black/50 dark:bg-black/20">
        <div class="bg-white dark:bg-zinc-800 text-black dark:text-zinc-100 p-6 rounded-md shadow-md w-full max-w-xl">
            <div class="flex justify-between items-center border-b border-zinc-200 dark:border-zinc-600 pb-2 mb-4">
                <h2 class="text-lg font-bold">Detail Menu</h2>
                <flux:button icon="x-mark" wire:click="$set('showModal', false)" variant="danger"></flux:button>
            </div>

            <div class="mt-4">
                <table class="">
                    <tbody>
                        <tr class="">
                            <th class=" w-1/6 text-left">Nama</th>
                            <th class=" w-1/12">:</th>
                            <td class="">{{ $selectedMenu->nama }}</td>
                        </tr>
                        <tr class="">
                            <th class=" w-1/6 text-left">Tipe</th>
                            <th class=" w-1/12">:</th>
                            <td class="">{{ $selectedMenu->tipe }}</td>
                        </tr>
                        <tr class="">
                            <th class=" w-1/6 text-left">Harga</th>
                            <th class=" w-1/12">:</th>
                            <td class="">Rp {{ number_format($selectedMenu->harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th class=" w-1/6 text-left">Deskripsi</th>
                            <th class=" w-1/12">:</th>
                            <td class="">{{ $selectedMenu->deskripsi }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                <h3 class="font-semibold">Bahan-bahan:</h3>
                <table
                    class="w-full mt-2 text-sm text-left text-zinc-700 dark:text-zinc-200 border dark:border-zinc-600">
                    <thead class="text-xs uppercase bg-zinc-100 dark:bg-zinc-700">
                        <tr>
                            <th class="px-3 py-2 border dark:border-zinc-600">#</th>
                            <th class="px-3 py-2 border dark:border-zinc-600">Nama</th>
                            <th class="px-3 py-2 border dark:border-zinc-600">Jumlah</th>
                            {{-- <th class="px-3 py-2 border dark:border-zinc-600">Satuan</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($selectedMenu->listMenus as $index => $item)
                        <tr class="bg-white dark:bg-zinc-800 border-b dark:border-zinc-600">
                            <td class="px-3 py-2">{{ $index + 1 }}</td>
                            <td class="px-3 py-2">{{ $item->bahan->nama }}</td>
                            <td class="px-3 py-2">{{ $item->jumlah }} {{ $item->bahan->satuanKecil->nama ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
    @if($showFormModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 dark:bg-black/70">
        <div class="bg-white dark:bg-zinc-800 text-black dark:text-white p-6 rounded shadow-md w-full max-w-2xl">
            <div class="flex justify-between mb-4 border-b pb-2">
                <h2 class="text-lg font-semibold">{{ $isEditing ? 'Edit' : 'Tambah' }} Menu</h2>
                <button wire:click="$set('showFormModal', false)">❌</button>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <input type="text" wire:model.defer="form.nama" placeholder="Nama Menu"
                    class="rounded w-full px-3 py-2 border dark:bg-zinc-900">
                <input type="text" wire:model.defer="form.tipe" placeholder="Tipe"
                    class="rounded w-full px-3 py-2 border dark:bg-zinc-900">
                <input type="number" wire:model.defer="form.harga" placeholder="Harga"
                    class="rounded w-full px-3 py-2 border dark:bg-zinc-900">
                <textarea wire:model.defer="form.deskripsi" rows="3" placeholder="Deskripsi"
                    class="rounded w-full px-3 py-2 border dark:bg-zinc-900"></textarea>

                <h3 class="font-semibold">Bahan</h3>
                <div class="max-h-44 overflow-y-auto pr-2 space-y-2">
                    @foreach ($form['bahanList'] as $index => $bahan)
                    <div class="flex items-center gap-2">
                        <select wire:model.defer="form.bahanList.{{ $index }}.bahan_id"
                            class="w-1/2 border rounded dark:bg-zinc-900">
                            <option value="">-- pilih bahan --</option>
                            @foreach($allBahans as $b)
                            <option value="{{ $b->id }}">{{ $b->nama }} ({{ $b->satuanKecil->nama ?? '' }})</option>
                            @endforeach
                        </select>
                        <input type="number" wire:model.defer="form.bahanList.{{ $index }}.jumlah"
                            class="w-1/3 border rounded dark:bg-zinc-900" placeholder="Jumlah">
                        <button wire:click.prevent="removeBahan({{ $index }})" class="text-red-500">🗑️</button>
                    </div>
                    @endforeach
                </div>

                <button wire:click.prevent="addBahan" class="text-sm text-blue-600 dark:text-blue-400 mt-2">
                    + Tambah Bahan
                </button>
            </div>

            <div class="mt-4 flex justify-end gap-2">
                <button wire:click="$set('showFormModal', false)"
                    class="px-4 py-2 bg-gray-300 dark:bg-zinc-600 rounded">Batal</button>
                <button wire:click="save" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
            </div>
        </div>
    </div>
    @endif
    @if($showDeleteConfirm)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-md dark:bg-black/70">
        <div class="bg-white dark:bg-zinc-800 text-black dark:text-white p-6 rounded shadow-md w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Hapus Menu</h2>
            <p>Apakah kamu yakin ingin menghapus menu ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="mt-6 flex justify-end gap-3">
                <button wire:click="$set('showDeleteConfirm', false)"
                    class="px-4 py-2 bg-gray-300 dark:bg-zinc-600 rounded">Batal</button>
                <button wire:click="delete" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
            </div>
        </div>
    </div>
    @endif
</div>