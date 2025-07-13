<div>
    {{-- Header --}}
    <div class="grid grid-cols-1 md:grid-cols-2 justify-between mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="text-4xl font-semibold text-primary-700">Daftar Bahan</div>
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
                    placeholder="Cari nama bahan">
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
                    <th class="px-6 py-3 text-center">Nama Bahan</th>
                    <th class="px-6 py-3 text-center">Stok</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bahans as $index => $bahan)
                <tr class="odd:bg-white even:bg-primary-100 text-primary-900 border-b border-primary-200">
                    <td class="px-6 py-4 text-center">{{ ($bahans->currentPage() - 1) * $bahans->perPage() + $index + 1
                        }}</td>
                    <td class="px-6 py-4 text-center">{{ $bahan->nama }}</td>
                    <td class="px-6 py-4 text-center">
                        {{ $bahan->total_stok['besar'] }} {{ $bahan->satuanBesar->nama ?? '-' }} -
                        {{ $bahan->total_stok['kecil'] }} {{ $bahan->satuanKecil->nama ?? '-' }}
                    </td>
                    <td class="px-6 py-4 flex justify-center gap-2">
                        <button wire:click="openEditForm({{ $bahan->id }})"
                            class="text-white bg-warning-500 hover:bg-warning-600 font-medium rounded-md text-xs px-2 py-1">
                            <i class="fa-solid fa-pencil"></i>
                        </button>
                        <button onclick="confirmDelete({{ $bahan->id }})"
                            class="text-white bg-danger-700 hover:bg-danger-800 font-medium rounded-md text-xs px-2 py-1">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                        <button wire:click="openOpname({{ $bahan->id }})"
                            class="text-white bg-amber-600 hover:bg-amber-700 font-medium rounded-md text-xs px-2 py-1">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr class="odd:bg-white even:bg-primary-100 text-primary-900 border-b border-primary-200">
                    <td colspan="4" class="text-center py-4">Tidak ada bahan ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 px-4">{{ $bahans->links() }}</div>
    </div>

    {{-- Modal Form --}}
    @if($showFormModal)
    <div class="fixed inset-0 z-50 flex justify-center items-center bg-black/50 backdrop-blur-md">
        <div class="bg-gradient-to-bl from-primary-50 to-primary-100 rounded-lg shadow w-full max-w-lg">
            <div
                class="flex items-start justify-between p-4 bg-gradient-to-br from-primary-200 to-primary-300 border-b rounded-t">
                <h3 class="text-xl font-semibold text-primary-900">{{ $isEditing ? 'Edit' : 'Tambah' }} Bahan</h3>
                <button wire:click="$set('showFormModal', false)"
                    class="text-primary-700 hover:bg-primary-600 hover:text-primary-100 rounded-lg text-sm w-8 h-8 inline-flex items-center justify-center">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="p-6 space-y-4 text-primary-900">
                <input type="text" wire:model.defer="form.nama" placeholder="Nama Bahan"
                    class="w-full rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500">

                <input type="number" wire:model.defer="form.konversi" placeholder="Jumlah konversi"
                    class="w-full rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500">

                <select wire:model.defer="form.besar_id"
                    class="w-full rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500">
                    <option value="">-- Pilih Satuan Besar --</option>
                    @foreach($allSatuan as $satuan)
                    <option value="{{ $satuan->id }}">{{ $satuan->nama }}</option>
                    @endforeach
                </select>

                <select wire:model.defer="form.kecil_id"
                    class="w-full rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500">
                    <option value="">-- Pilih Satuan Kecil --</option>
                    @foreach($allSatuan as $satuan)
                    <option value="{{ $satuan->id }}">{{ $satuan->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end p-6 space-x-2 border-t">
                <button wire:click="$set('showFormModal', false)"
                    class="text-primary-700 bg-white border border-primary-300 font-medium rounded-lg text-sm px-4 py-2 hover:bg-primary-600 hover:text-white">Batal</button>
                <button wire:click="save"
                    class="text-white bg-primary-600 hover:bg-primary-700 font-medium rounded-lg text-sm px-4 py-2">Simpan</button>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal Opname --}}
    @if($showOpnameModal)
    <div class="fixed inset-0 z-50 flex justify-center items-center bg-black/50 backdrop-blur-md">
        <div class="bg-white rounded-lg shadow w-full max-w-md p-6">
            <h3 class="text-lg font-semibold text-primary-900 mb-2">Stok Opname: {{ $selectedBahan?->nama }}</h3>
            <p class="text-sm text-primary-700 mb-4">
                Stok saat ini: {{ $selectedBahan?->getTotalStok()['besar'] }} {{ $selectedBahan?->satuanBesar->nama ??
                '' }}
            </p>
            <input type="number" wire:model.defer="stokOpnameInput"
                class="w-full mb-4 rounded-md border-primary-300 shadow-sm focus:ring-primary-500 focus:border-primary-500"
                placeholder="Jumlah stok nyata (satuan besar)">

            <div class="flex justify-end gap-2">
                <button wire:click="$set('showOpnameModal', false)"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-black rounded">Batal</button>
                <button wire:click="saveOpname"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">Simpan</button>
            </div>
        </div>
    </div>
    @endif

    {{-- SweetAlert Delete --}}
    @pushOnce('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data bahan akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('delete', id)
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