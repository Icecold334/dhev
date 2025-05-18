<div>
    <table id="bahan-table">
        <thead>
            <tr>
                <th scope="col">
                    #
                </th>
                <th scope="col">
                    Nama Bahan
                </th>
                <th scope="col">
                    Satuan Besar
                </th>
                <th scope="col">
                    Satuan Kecil
                </th>
                <th scope="col">
                    Sisa
                </th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bahans as $bahan)
            <tr>
                <td scope="row">
                    {{ $loop->iteration }}
                </td>
                <td scope="row">
                    {{ $bahan->nama }}
                </td>
                <td>
                    {{ $bahan->satuanBesar->nama }}
                </td>
                <td>
                    {{ $bahan->satuanKecil->nama }}
                </td>
                <td>
                    50 Kg - 50000 Gram
                </td>
                <td class="px-6 py-4 flex">
                    <a href="#" class="font-medium text-zinc-100 dark:text-zinc-500 hover:underline">
                        <flux:icon.pencil-square />
                    </a>
                    <a href="#" class="font-medium text-red-100 dark:text-red-500 hover:underline">
                        <flux:icon.trash />
                    </a>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    @pushOnce('scripts')
    <script type="module">
        if (document.getElementById("bahan-table")) {
                
                const dataTable = new DataTable("#bahan-table", {
                searchable: true,
                sortable: false
                });
                }
    </script>
    @endPushOnce
</div>