<div>
    <table id="menuTable" class="display w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">Gambar</th>
                <th scope="col" class="px-6 py-3">Nama</th>
                <th scope="col" class="px-6 py-3">Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menus as $menu)
            <tr>
                <td class="px-6 py-4">
                    <img src="{{ $menu['image'] }}" alt="{{ $menu['name'] }}" class="w-16 h-16 object-cover rounded">
                </td>
                <td class="px-6 py-4 font-medium text-gray-900">{{ $menu['name'] }}</td>
                <td class="px-6 py-4">Rp {{ number_format($menu['price'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@pushOnce('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    // document.addEventListener('livewire:load', function () {
                    $('#menuTable').DataTable();
                // });
</script>

@endPushOnce