<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-zinc-500 dark:text-zinc-400">
        <thead class="text-xs text-zinc-700 uppercase bg-zinc-50 dark:bg-zinc-900 dark:text-zinc-400">
            <tr class="text-center">
                <th scope="col" class="px-6 py-3">
                    Bahan
                </th>
                <th scope="col" class="px-6 py-3 w-1/6">
                    Jumlah
                </th>
                <th scope="col" class="px-6 py-3">
                    Keterangan
                </th>
                <th scope="col" class="px-6 py-3">

                </th>
            </tr>
        </thead>
        <tbody>

            <tr class="bg-white dark:bg-zinc-700  even:dark:bg-zinc-800 border-b dark:border-zinc-700 border-zinc-200">
                <th scope="row" class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-white">
                    <flux:input value="Gula" disabled />
                </th>
                <td class="px-6 py-4">
                    <flux:input type="number" />
                </td>
                <td class="px-6 py-4">
                    <flux:textarea placeholder="Masukkan Keterangan (Opsional)" rows="1" />
                </td>

                <td class="px-6 py-4">
                    <flux:button icon="plus"></flux:button>
                </td>
            </tr>
        </tbody>
    </table>
</div>