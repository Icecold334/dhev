<?php

use App\Models\Transaksi;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\DB;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->to('login');
})->name('home');

Route::get('dashboard', function () {
    $today = now()->startOfDay();

    // === Pendapatan Hari Ini ===
    $pendapatanHariIni = Transaksi::whereDate('created_at', $today)
        ->sum(DB::raw('harga * jumlah'));

    // === Jumlah Transaksi Hari Ini ===
    $totalTransaksi = Transaksi::whereDate('created_at', $today)
        ->count();

    // === Menu Terfavorit Hari Ini ===
    $menuTerfavorit = Transaksi::select('menu_id', DB::raw('SUM(jumlah) as total'))
        ->groupBy('menu_id')
        ->orderByDesc('total')
        ->first();

    $namaMenuTerfavorit = $menuTerfavorit?->menu->nama ?? '-';

    // === Pendapatan 14 Hari Terakhir ===
    $tanggal14 = collect(range(0, 13))
        ->map(fn($i) => now()->subDays($i)->toDateString())
        ->reverse();

    $pendapatan14Hari = Transaksi::whereBetween('created_at', [now()->subDays(13)->startOfDay(), now()])
        ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(harga * jumlah) as total'))
        ->groupBy('tanggal')
        ->pluck('total', 'tanggal');

    $dataChartPendapatan14Hari = $tanggal14->map(fn($tgl) => $pendapatan14Hari[$tgl] ?? 0)->values();

    // === Pendapatan 7 Hari (untuk mini chart) ===
    $tanggal7 = collect(range(0, 6))
        ->map(fn($i) => now()->subDays($i)->toDateString())
        ->reverse();

    $pendapatan7Hari = Transaksi::whereBetween('created_at', [now()->subDays(6)->startOfDay(), now()])
        ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(harga * jumlah) as total'))
        ->groupBy('tanggal')
        ->pluck('total', 'tanggal');

    $jamHariIni = collect(range(0, 23))->map(fn($i) => now()->startOfDay()->addHours($i)->format('H'));

    $pendapatanPerJam = Transaksi::whereDate('created_at', now())
        ->select(DB::raw("strftime('%H', created_at) as jam"), DB::raw('SUM(harga * jumlah) as total'))
        ->groupBy('jam')
        ->pluck('total', 'jam');


    $dataPendapatanHariIniChart = $jamHariIni->map(fn($jam) => $pendapatanPerJam[$jam] ?? 0)->values();


    // === Transaksi 7 Hari (untuk mini chart) ===
    $transaksi7Hari = Transaksi::whereBetween('created_at', [now()->subDays(6)->startOfDay(), now()])
        ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('COUNT(*) as total'))
        ->groupBy('tanggal')
        ->pluck('total', 'tanggal');

    $dataTransaksi7Hari = $tanggal7->map(fn($tgl) => $transaksi7Hari[$tgl] ?? 0)->values();

    // === Menu Terlaris (untuk pie chart) ===
    $menuTerjual = Transaksi::select('menus.nama', DB::raw('SUM(jumlah) as total'))
        ->join('menus', 'menus.id', '=', 'transaksis.menu_id')
        ->groupBy('menus.nama')
        ->orderByDesc('total')
        ->get();


    $menuLabels = $menuTerjual->pluck('nama');
    $menuValues = $menuTerjual->pluck('total');
    $labelHari14 = $tanggal14->map(fn($tgl) => \Carbon\Carbon::parse($tgl)->translatedFormat('D'))->values();

    return view('dashboard', [
        'pendapatanHariIni' => $pendapatanHariIni,
        'totalTransaksi' => $totalTransaksi,
        'menuTerfavorit' => $namaMenuTerfavorit,
        'dataPendapatan14Hari' => $dataChartPendapatan14Hari,
        'dataLabelHari14' => $labelHari14,
        'dataPendapatanHariIniChart' => $dataPendapatanHariIniChart,
        'dataTransaksi7Hari' => $dataTransaksi7Hari,
        'menuLabels' => $menuLabels,
        'menuValues' => $menuValues,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('laporan/{type}', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::resource('bahan', BahanController::class);
    Route::resource('beli', PembelianController::class);
    Route::resource('jual', PenjualanController::class);
    Route::resource('menu', MenuController::class);
});

require __DIR__ . '/auth.php';
