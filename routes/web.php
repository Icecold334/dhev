<?php

use App\Http\Controllers\BahanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->to('login');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::resource('bahan', BahanController::class);
    Route::resource('beli', PembelianController::class);
    Route::resource('jual', PenjualanController::class);
    Route::resource('menu', MenuController::class);
});

require __DIR__ . '/auth.php';
