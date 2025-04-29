<table id="search-table">
    <thead>
        <tr>
            <th class="w-1/3">
                <span class="flex items-center">#</span>
            </th>
            <th class="w-1/3">
                <span class="flex items-center">Nama</span>
            </th>
            <th class="w-1/5">
                <span class="flex items-center">Harga</span>
            </th>
            {{-- <th class="w-1/6">
                <span class="flex items-center">Deskripsi</span>
            </th> --}}
            <th class="w-1/12">
                <span class="flex items-center"></span>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($menus as $menu)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $menu->nama }}</td>
            <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
            <td>
                <flux:button icon="eye" href='/menu/{{ $menu->id }}'></flux:button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@pushOnce('scripts')
<script type="module">
    if (document.getElementById("search-table")) {
        
        const dataTable = new DataTable("#search-table", {
        searchable: true,
        sortable: false
        });
        }
</script>
@endPushOnce