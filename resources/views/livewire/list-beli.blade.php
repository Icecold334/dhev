<div class="relative overflow-x-auto  sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-zinc-500 dark:text-zinc-400">
        <thead class="text-xs text-zinc-700 uppercase bg-zinc-50 dark:bg-zinc-900 dark:text-zinc-400">
            <tr class="text-center">
                <th scope="col" class="px-6 py-3">
                    Bahan
                </th>
                <th scope="col" class="px-6 py-3 w-1/6">
                    Jumlah
                </th>
                <th scope="col" class="px-6 py-3 w-1/4">
                    Harga
                </th>
                <th scope="col" class="px-6 py-3 w-1/4">
                    Total
                </th>
                <th scope="col" class="px-6 py-3">
                    Keterangan
                </th>
                <th scope="col" class="px-6 py-3">

                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $index => $item)
            <tr class="bg-white dark:bg-zinc-700  even:dark:bg-zinc-800 border-b dark:border-zinc-700 border-zinc-200">
                <th scope="row" class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-white">
                    <flux:input wire:model='list.{{ $index }}.bahanNama' disabled />
                </th>
                <td class="px-6 py-4">
                    <flux:input type="number" wire:model='list.{{ $index }}.jumlah' disabled />
                </td>
                <td class="px-6 py-4">
                    <flux:input.group>
                        <flux:input.group.prefix>Rp</flux:input.group.prefix>
                        <flux:input placeholder="Harga (Satuan)" wire:model='list.{{ $index }}.hargaRupiah'
                            autocomplete="off" disabled />
                    </flux:input.group>
                </td>
                <th scope="row" class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-white">

                    <flux:input.group>
                        <flux:input.group.prefix>Rp</flux:input.group.prefix>
                        <flux:input placeholder="Total" id="newTotal"
                            value="{{ number_format((int) $item['jumlah'] * (int) $item['harga'], 0, ',', '.') }}"
                            readonly autocomplete="off" />
                    </flux:input.group>
                </th>
                <td class="px-6 py-4">
                    <flux:textarea wire:model='list.{{ $index }}.keterangan' disabled rows="1" />
                </td>

                <td class="px-6 py-4">
                    <flux:button icon="x-mark" variant="danger" wire:click='removeList({{ $index }})'></flux:button>
                </td>
            </tr>
            @endforeach

            {{-- @if ($newBahan) --}}
            <tr class="bg-white dark:bg-zinc-700  even:dark:bg-zinc-800 border-b dark:border-zinc-700 border-zinc-200">
                <th scope="row" class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-white">
                    <flux:input value="{{ $newBahan->nama ?? null }}" placeholder="Pilih bahan di atas" disabled />
                </th>
                <td class="px-6 py-4">
                    <flux:input type="number" wire:model.live='newJumlah' id="newJumlah" placeholder="Jumlah" />
                </td>
                <th scope="row" class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-white">

                    <flux:input.group>
                        <flux:input.group.prefix>Rp</flux:input.group.prefix>
                        <flux:input placeholder="Harga (Satuan)" id="newHarga" autocomplete="off" />
                    </flux:input.group>
                </th>
                <th scope="row" class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-white">

                    <flux:input.group>
                        <flux:input.group.prefix>Rp</flux:input.group.prefix>
                        <flux:input placeholder="Total" id="newTotal" readonly autocomplete="off" />
                    </flux:input.group>
                </th>
                <td class="px-6 py-4">
                    <flux:textarea placeholder="Masukkan Keterangan (Opsional)" wire:model.live='newKeterangan'
                        rows="1" />
                </td>

                <td class="px-6 py-4">
                    <flux:button icon="plus" wire:click='addToList' id="addToList"></flux:button>
                </td>
            </tr>
            {{-- @endif --}}
        </tbody>
    </table>
    <div class="flex justify-center mt-4">
        <flux:button wire:click='saveList'>Simpan</flux:button>
    </div>
</div>
@pushOnce('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
            const inputHarga = document.getElementById('newHarga');
            const inputJumlah = document.getElementById('newJumlah');
            const inputTotal = document.getElementById('newTotal');
            const addButton = document.getElementById('addToList');

            if (inputHarga) {
                inputHarga.addEventListener('keyup', function () {
                    let rawValue = inputHarga.value.replace(/[^0-9]/g, ''); // Ambil hanya angka
                    let jumlah = inputJumlah.value.replace(/[^0-9]/g, ''); // Ambil hanya angka
                    console.log(jumlah);
                    
                    let formattedValue = new Intl.NumberFormat('id-ID', {
                        minimumFractionDigits: 0
                    }).format(rawValue);

                    inputHarga.value = formattedValue;
                    let total = rawValue * jumlah;
                    let formattedJumlah = new Intl.NumberFormat('id-ID', {
                    minimumFractionDigits: 0
                    }).format(total);
                    inputTotal.value = formattedJumlah;
                    @this.set('newHarga', rawValue);
                    @this.set('newHargaRupiah', formattedValue);
                });
            }
            if (inputHarga) {
                addButton.addEventListener('click', function () {
                inputHarga.value = null; // Ambil hanya angka
                inputTotal.value = null; // Ambil hanya angka

                });
            }
        });
</script>
@endPushOnce