<x-layouts.body :title="__('Dashboard')">
    <div class="flex flex-col gap-6">
        {{-- Stats Card Grid --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
            @role('admin')
            {{-- Pendapatan --}}
            <div
                class="rounded-2xl bg-gradient-to-bl from-primary-50 to-primary-100 p-4 shadow border border-zinc-200 ">
                <p class="text-sm text-black">Jumlah Pendapatan Hari Ini</p>
                <h3 class="mt-1 text-2xl font-semibold text-black">Rp {{ number_format($pendapatanHariIni, 0, ',', '.')
                    }}</h3>
                <div class="relative h-45 max-h-45">
                    <canvas id="pendapatan" data-values='@json($dataPendapatanHariIniChart)'
                        class="absolute left-0 top-0 h-full w-full"></canvas>
                </div>
            </div>
            @endrole

            {{-- Transaksi --}}
            <div
                class="rounded-2xl bg-gradient-to-bl @role('kasir') col-span-1 @endrole from-primary-50 to-primary-100 p-4 shadow border border-zinc-200 ">
                <p class="text-sm text-black">Jumlah Transaksi Hari Ini</p>
                <h3 class="mt-1 text-2xl font-semibold text-black">{{ $totalTransaksi }} Transaksi</h3>
                <div class="relative h-45 max-h-45">
                    <canvas id="transaksi" data-values='@json($dataTransaksi7Hari)'
                        class="absolute left-0 top-0 h-full w-full"></canvas>
                </div>
            </div>

            {{-- Menu Terjual Hari Ini --}}
            <div
                class=" rounded-2xl bg-gradient-to-bl from-primary-50 to-primary-100 p-4 shadow border border-zinc-200">
                <p class="text-sm text-black">Menu Terjual Hari Ini</p>
                <div class="mt-2 overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-primary-900">
                        <thead class="text-xs uppercase text-primary-700 bg-primary-200">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Nama Menu</th>
                                <th class="px-4 py-2">Jumlah Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($menuHariIni as $index => $menu)
                            <tr class="odd:bg-white even:bg-primary-100 border-b border-primary-200">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $menu->nama }}</td>
                                <td class="px-4 py-2">{{ $menu->total }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-center">Tidak ada data hari ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @role('kasir')
            {{-- Bahan Stok Menipis --}}
            <div class="rounded-2xl bg-gradient-to-bl from-primary-50 to-primary-100 p-4 shadow border border-zinc-200">
                <h2 class="text-lg font-semibold text-black ">Bahan dengan Stok Menipis</h2>
                <div class="mt-2 overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-primary-900">
                        <thead class="text-xs uppercase text-primary-700 bg-primary-200">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Nama Bahan</th>
                                <th class="px-4 py-2">Stok Sekarang</th>
                                <th class="px-4 py-2">Minimal Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bahanStokMenipis as $index => $bahan)
                            <tr class="odd:bg-white even:bg-primary-100 border-b border-primary-200">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $bahan->nama }}</td>
                                <td class="px-4 py-2">{{ $bahan->getTotalStok()['besar'] }} {{ $bahan->satuanBesar->nama
                                    ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $bahan->minimal_stok }} {{ $bahan->satuanBesar->nama ?? '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-2 text-center">Semua bahan dalam stok aman.</td>
                            </tr>
                            @endforelse

                            @if($jumlahStokMenipis > 4)
                            <tr class="odd:bg-white even:bg-primary-100 border-b border-primary-200">
                                <td colspan="4" class="px-4 py-2 text-center">
                                    <a href="{{ route('bahan.index') }}"
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-primary-300 text-primary-800 hover:bg-primary-200 transition">
                                        Dan {{ $jumlahStokMenipis - 3 }} bahan lainnya...
                                    </a>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endrole
        </div>

        @role('admin')
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
            {{-- Grafik Pendapatan 14 Hari --}}
            <div
                class="rounded-2xl col-span-2 bg-gradient-to-bl from-primary-50 to-primary-100 p-4 shadow border border-zinc-200 ">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-black ">Grafik Pendapatan 14 Hari Terakhir</h2>
                </div>
                <div class="relative h-52 max-h-52">
                    <canvas id="weeks" data-pendapatan='@json($dataPendapatan14Hari)' class="w-full h-full"></canvas>
                </div>
            </div>
            {{-- Bahan Stok Menipis --}}
            <div class="rounded-2xl bg-gradient-to-bl from-primary-50 to-primary-100 p-4 shadow border border-zinc-200">
                <h2 class="text-lg font-semibold text-black ">Bahan dengan Stok Menipis</h2>
                <div class="mt-2 overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-primary-900">
                        <thead class="text-xs uppercase text-primary-700 bg-primary-200">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Nama Bahan</th>
                                <th class="px-4 py-2">Stok Sekarang</th>
                                <th class="px-4 py-2">Minimal Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bahanStokMenipis as $index => $bahan)
                            <tr class="odd:bg-white even:bg-primary-100 border-b border-primary-200">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $bahan->nama }}</td>
                                <td class="px-4 py-2">{{ $bahan->getTotalStok()['besar'] }} {{ $bahan->satuanBesar->nama
                                    ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $bahan->minimal_stok }} {{ $bahan->satuanBesar->nama ?? '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-2 text-center">Semua bahan dalam stok aman.</td>
                            </tr>
                            @endforelse

                            @if($jumlahStokMenipis > 4)
                            <tr class="odd:bg-white even:bg-primary-100 border-b border-primary-200">
                                <td colspan="4" class="px-4 py-2 text-center">
                                    <a href="{{ route('bahan.index') }}"
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-primary-300 text-primary-800 hover:bg-primary-200 transition">
                                        Dan {{ $jumlahStokMenipis - 3 }} bahan lainnya...
                                    </a>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endrole


    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        @role('admin')
        // Grafik Pendapatan 14 Hari
        var weeksEl = document.getElementById('weeks');
        var pendapatanData = JSON.parse(weeksEl.dataset.pendapatan);

        new Chart(weeksEl.getContext('2d'), {
            type: 'line',
            data: {
                labels: @json($dataLabelHari14),
                datasets: [{
                    data: pendapatanData,
                    borderColor: "#b775a9",
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: true }
                },
                scales: {
                    x: { display: true },
                    y: { display: true }
                }
            }
        });
        @endrole
        @role('admin')
        // Mini Chart Pendapatan 7 Hari
        var pendapatanCanvas = document.getElementById('pendapatan');
        var pendapatanHariIni = JSON.parse(pendapatanCanvas.dataset.values);
        new Chart(pendapatanCanvas.getContext('2d'), {
        type: 'line',
        data: {
        labels: Array(pendapatanHariIni.length).fill(""),
        datasets: [{
        data: pendapatanHariIni,
        borderColor: "#0ea5e9",
        backgroundColor: "rgba(14, 165, 233, 0.1)",
        fill: true,
        tension: 0.4,
        pointRadius: 0,
        borderWidth: 2
        }]
        },
        options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
        legend: { display: false },
        tooltip: { enabled: false }
        },
        scales: {
        x: { display: false },
        y: { display: false }
        }
        }
        });
@endrole
        // Mini Chart Transaksi 7 Hari
        var transaksiCanvas = document.getElementById('transaksi');
        var transaksi7 = JSON.parse(transaksiCanvas.dataset.values);
        new Chart(transaksiCanvas.getContext('2d'), {
            type: 'line',
            data: {
                labels: Array(transaksi7.length).fill(""),
                datasets: [{
                    data: transaksi7,
                    borderColor: "#2fc921",
                    backgroundColor: "rgba(47, 201, 33, 0.1)",
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                },
                scales: {
                    x: { display: false },
                    y: { display: false }
                }
            }
        });

        // Pie Chart Menu Terlaris
        var menuCanvas = document.getElementById('menu');
        var menuLabels = JSON.parse(menuCanvas.dataset.labels);
        var menuValues = JSON.parse(menuCanvas.dataset.values);
        new Chart(menuCanvas.getContext('2d'), {
            type: 'pie',
            data: {
                labels: menuLabels,
                datasets: [{
                    data: menuValues,
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: true }
                }
            }
        });
    </script>
    @endpush
</x-layouts.body>