<div>
    {{-- Header --}}
    <div class="grid grid-cols-1 md:grid-cols-2 justify-between mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="text-4xl font-semibold text-primary-700">Daftar Menu</div>
                <button wire:click="openCreateForm" type="button"
                    class="text-primary-100 hover:text-primary-50 bg-primary-700 hover:bg-primary-800 transition duration-200 font-medium rounded-lg text-sm px-3 py-2">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="flex items-center gap-6 justify-self-end mt-4 md:mt-0">
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex text-primary-600 items-center ps-3.5 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" wire:model.live="search"
                    class="bg-primary-50 border border-primary-300 text-primary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full ps-10 p-2.5"
                    placeholder="Cari nama menu">
            </div>

            <select wire:model.live="perPage"
                class="bg-primary-50 border border-primary-300 text-primary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-28 p-2.5">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="relative overflow-x-auto sm:rounded-lg">
        <table class="w-full text-sm text-left text-primary-500">
            <thead class="text-xs text-primary-700 uppercase bg-primary-200">
                <tr>
                    <th class="px-6 py-3 text-center">#</th>
                    <th class="px-6 py-3 text-center">Nama</th>
                    <th class="px-6 py-3 text-center">Harga</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($menus as $index => $menu)
                <tr class="odd:bg-white even:bg-primary-100 text-primary-900 border-b border-primary-200">
                    <td class="px-6 py-4 text-center">{{ ($menus->currentPage() - 1) * $menus->perPage() + $index + 1 }}
                    </td>
                    <td class="px-6 py-4 text-center">{{ $menu->nama }}</td>
                    <td class="px-6 py-4 text-center">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center flex justify-center gap-2">
                        <button wire:click="showDetail({{ $menu->id }})"
                            class="text-white bg-info-700 hover:bg-info-800 font-medium rounded-md text-xs px-2 py-1">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button wire:click="openEditForm({{ $menu->id }})"
                            class="text-white bg-warning-500 hover:bg-warning-600 font-medium rounded-md text-xs px-2 py-1">
                            <i class="fa-solid fa-pencil"></i>
                        </button>
                        <button onclick="confirmDelete({{ $menu->id }})"
                            class="text-white bg-danger-700 hover:bg-danger-800 font-medium rounded-md text-xs px-2 py-1">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr class="odd:bg-white even:bg-primary-100 text-primary-900 border-b border-primary-200">
                    <td colspan="4" class="text-center py-4">Tidak ada menu ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 px-4">{{ $menus->links() }}</div>
    </div>

    {{-- Modal Form (Tambah/Edit) --}}
    @if($showFormModal)
    <div class="fixed inset-0 z-50 flex justify-center items-center bg-black/50 backdrop-blur-md">
        <div class="relative w-full max-w-4xl">
            <div class="relative bg-gradient-to-bl from-primary-50 to-primary-100 rounded-lg shadow ">
                <div
                    class="flex items-start justify-between p-4 bg-gradient-to-br from-primary-200 to-primary-300 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-primary-900">{{ $isEditing ? 'Edit Menu' : 'Tambah Menu' }}
                    </h3>
                    <button wire:click="$set('showFormModal', false)"
                        class="text-primary-700 hover:bg-primary-600 hover:text-primary-100 rounded-lg text-sm w-8 h-8 inline-flex items-center justify-center">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="p-6 space-y-4 grid grid-cols-12 gap-4">
                    <div class="col-span-6">
                        <div>
                            <label class="block text-sm font-medium text-primary-700">Nama Menu</label>
                            <input type="text" wire:model.defer="form.nama"
                                class="w-full mt-1 rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Masukkan nama menu">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-primary-700">Tipe</label>
                            <input type="text" wire:model.defer="form.tipe"
                                class="w-full mt-1 rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Masukkan tipe">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-primary-700">Harga</label>
                            <input type="number" wire:model.defer="form.harga"
                                class="w-full mt-1 rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Masukkan harga">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-primary-700">Deskripsi</label>
                            <textarea wire:model.defer="form.deskripsi" rows="3"
                                class="w-full mt-1 rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Deskripsi menu..."></textarea>
                        </div>
                    </div>
                    <div class="col-span-6">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-primary-700">Bahan</label>
                            <div class="max-h-64 overflow-y-auto space-y-2">
                                @foreach ($form['bahanList'] as $index => $bahan)
                                <div class="flex items-center gap-2">
                                    <select wire:model.defer="form.bahanList.{{ $index }}.bahan_id"
                                        class="w-1/2 rounded-md border-primary-300 focus:ring-primary-500 focus:border-primary-500">
                                        <option value="">-- Pilih bahan --</option>
                                        @foreach($allBahans as $b)
                                        <option value="{{ $b->id }}">{{ $b->nama }} ({{ $b->satuanKecil->nama ?? '' }})
                                        </option>
                                        @endforeach
                                    </select>
                                    <input type="number" wire:model.defer="form.bahanList.{{ $index }}.jumlah"
                                        class="w-1/3 rounded-md border-primary-300 focus:ring-primary-500 focus:border-primary-500"
                                        placeholder="Jumlah">
                                    <button wire:click.prevent="removeBahan({{ $index }})"
                                        class="text-red-500">🗑️</button>
                                </div>
                                @endforeach
                            </div>
                            <button wire:click.prevent="addBahan"
                                class="text-sm text-primary-600 dark:text-primary-400 mt-2">+
                                Tambah Bahan</button>
                        </div>
                    </div>



                </div>

                <div class="flex justify-end p-6 space-x-2 border-t">
                    <button wire:click="$set('showFormModal', false)"
                        class="text-primary-700 bg-white border border-primary-300 font-medium rounded-lg text-sm px-4 py-2 hover:bg-primary-600 hover:text-white">
                        Batal
                    </button>
                    <button wire:click="save"
                        class="text-white bg-primary-600 hover:bg-primary-700 font-medium rounded-lg text-sm px-4 py-2">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal Detail (lihat) --}}
    @if($showModal && $selectedMenu)
    <div class="fixed inset-0 z-50 flex justify-center items-center bg-black/50 backdrop-blur-md">
        <div class="relative w-full max-w-lg">
            <div class="bg-gradient-to-bl from-primary-50 to-primary-100 rounded-lg shadow">
                <div
                    class="flex items-start justify-between p-4 bg-gradient-to-br from-primary-200 to-primary-300 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-primary-900">Detail Menu</h3>
                    <button wire:click="$set('showModal', false)"
                        class="text-primary-700 hover:bg-primary-600 hover:text-primary-100 rounded-lg text-sm w-8 h-8 inline-flex items-center justify-center">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="p-6 space-y-2 text-primary-900">
                    <p><strong>Nama:</strong> {{ $selectedMenu->nama }}</p>
                    <p><strong>Tipe:</strong> {{ $selectedMenu->tipe }}</p>
                    <p><strong>Harga:</strong> Rp {{ number_format($selectedMenu->harga, 0, ',', '.') }}</p>
                    <p><strong>Deskripsi:</strong> {{ $selectedMenu->deskripsi }}</p>
                    <p><strong>Bahan:</strong></p>
                    <ul class="list-disc list-inside">
                        @foreach ($selectedMenu->listMenus as $item)
                        <li>{{ $item->bahan->nama }} - {{ $item->jumlah }} {{ $item->bahan->satuanKecil->nama ?? '-' }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="flex justify-end p-4 border-t">
                    <button wire:click="$set('showModal', false)"
                        class="text-primary-700 bg-white border border-primary-300 font-medium rounded-lg text-sm px-4 py-2 hover:bg-primary-600 hover:text-white">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Confirm Delete (pakai SweetAlert) --}}
    @pushOnce('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Menu akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('delete', id);
                }
            });
        }

        window.addEventListener('toast', event => {
            
            const { type = 'success', message = '' } = event.detail[0][0];
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: type,
                title: message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        });
    </script>
    @endPushOnce
</div>