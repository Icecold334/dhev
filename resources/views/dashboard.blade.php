<x-layouts.body :title="__('Dashboard')">
    <div class="flex flex-col gap-6">
        {{-- Stats Card Grid --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
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

            {{-- Transaksi --}}
            <div
                class="rounded-2xl bg-gradient-to-bl from-primary-50 to-primary-100 p-4 shadow border border-zinc-200 ">
                <p class="text-sm text-black">Jumlah Transaksi Hari Ini</p>
                <h3 class="mt-1 text-2xl font-semibold text-black">{{ $totalTransaksi }} Transaksi</h3>
                <div class="relative h-45 max-h-45">
                    <canvas id="transaksi" data-values='@json($dataTransaksi7Hari)'
                        class="absolute left-0 top-0 h-full w-full"></canvas>
                </div>
            </div>

            {{-- Menu Terfavorit --}}
            <div
                class="rounded-2xl bg-gradient-to-bl from-primary-50 to-primary-100 p-4 shadow border border-zinc-200 ">
                <p class="text-sm text-black">Menu Terfavorit</p>
                <h3 class="mt-1 text-2xl font-semibold text-black">{{ $menuTerfavorit }}</h3>
                <div class="relative h-45 max-h-45">
                    <canvas id="menu" data-labels='@json($menuLabels)' data-values='@json($menuValues)'
                        class="absolute left-0 top-0 h-full w-full"></canvas>
                </div>
            </div>
        </div>

        {{-- Grafik Pendapatan 14 Hari --}}
        <div
            class="relative w-full flex-1 overflow-hidden rounded-xl border border-zinc-200 bg-gradient-to-bl from-primary-50 to-primary-100 p-6 ">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-black ">Grafik Pendapatan 14 Hari Terakhir</h2>
            </div>
            <div class="relative h-52 max-h-52">
                <canvas id="weeks" data-pendapatan='@json($dataPendapatan14Hari)' class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
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