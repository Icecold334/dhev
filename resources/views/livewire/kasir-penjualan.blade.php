<div class="">
    <div class="grid grid-cols-12 gap-6 ">

        <div class="col-span-8 grid grid-cols-2 gap-6">
            <div
                class="bg-white col-span-2 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg shadow p-4">
                <input type="text" wire:model.live="search" placeholder="Cari menu" autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
            </div>
            @forelse($menus as $menu)
            <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-zinc-100">{{ $menu->nama }}</h3>
                {{-- <p class="text-sm text-gray-600 dark:text-zinc-400 mb-2">{{ $menu->deskripsi }}</p> --}}
                <div class="flex items-center justify-between">
                    <span class="text-green-600 dark:text-green-400 font-semibold">Rp {{ number_format($menu->harga)
                        }}</span>
                    <flux:button wire:click="tambahMenu({{ $menu->id }})"> Tambah
                    </flux:button>
                </div>
            </div>
            @empty
            <div
                class="bg-white dark:bg-zinc-800 border col-span-2 border-gray-200 dark:border-zinc-700 rounded-lg shadow p-4">
                <h3 class="text-lg  text-gray-900 text-center dark:text-zinc-100"><span class="font-semibold">"{{
                        $search }}"</span> tidak ada
                    dalam
                    daftar menu.</h3>

            </div>
            @endforelse
        </div>
        <div
            class="col-span-4 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg shadow p-4">
            <div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600 dark:text-zinc-300">
                        <thead class="text-xs text-gray-700 dark:text-zinc-200 uppercase bg-gray-100 dark:bg-zinc-700">
                            <tr>
                                <th scope="col" class="px-4 py-3 rounded-l-lg text-center">Menu</th>
                                <th scope="col" class="px-4 py-3 text-center">Jumlah</th>
                                <th scope="col" class="px-4 py-3 text-center">Subtotal</th>
                                <th scope="col" class="px-4 py-3 rounded-r-lg w-1/12 text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $totalJumlah = 0;
                            $totalHarga = 0;
                            @endphp
                            @forelse($cart as $menuId => $jumlah)
                            @php
                            $menu = App\Models\Menu::find($menuId);
                            $totalJumlah += $jumlah;
                            $totalHarga += $menu->harga * $jumlah;
                            @endphp
                            <tr class="bg-white dark:bg-zinc-800 border-b dark:border-zinc-700">
                                <td class="px-2 py-3 font-medium text-gray-900 dark:text-zinc-100 whitespace-nowrap">{{
                                    $menu->nama }}</td>
                                <td class="px-2 py-3 text-center">{{ $jumlah }}</td>
                                <td class="px-2 py-3">Rp {{ number_format($menu->harga * $jumlah) }}</td>
                                <td class="px-2 py-3 text-center">
                                    <flux:button wire:click="kurangiMenu({{ $menuId }})" icon="trash" variant="danger">
                                    </flux:button>

                                </td>
                            </tr>
                            @empty
                            <tr class="bg-white dark:bg-zinc-800  dark:border-zinc-700">
                                <td class="px-2 py-3 font-medium text-gray-900 dark:text-zinc-100 text-center"
                                    colspan="4">
                                    Daftar Kosong.</td>

                                </td>
                            </tr>
                            @endforelse
                            @if(count($cart) > 0 )
                            <!-- ✅ Total Row -->
                            <tr class="bg-gray-100 dark:bg-zinc-700 font-semibold border-t dark:border-zinc-600">
                                <td class="px-2 py-1 text-gray-900 dark:text-white text-right">Total</td>
                                <td class="px-2 py-1 text-center">{{ $totalJumlah }}</td>
                                <td class="px-2 py-1">Rp {{ number_format($totalHarga) }}</td>
                                <td></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="flex  mt-4">
                    @if(count($cart) > 0 )
                    <flux:button class="w-full" wire:click="simpanTransaksi">Bayar</flux:button>
                    @endif

                </div>

            </div>
        </div>
    </div>

</div>