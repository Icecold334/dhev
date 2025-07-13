<aside id="sidebar"
  class="fixed top-0 left-0 z-40 w-64 h-screen bg-gradient-to-b from-primary-600 to-primary-800 shadow-2xl transition-transform -translate-x-full lg:translate-x-0">
  <div class="h-full  overflow-y-auto">
    {{-- <h2 class="text-2xl font-bold mb-6 text-white text-center px-4 py-3">{{ env('APP_NAME') }}</h2> --}}
    <div class="flex flex-col items-center justify-center bg-gradient-to-t rounded-lg shadow-2xl px-4 py-3">
      <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-24 h-24 mb-2 ">
      <h2 class="text-white text-xl font-bold text-center">{{ env('APP_NAME') }}</h2>
    </div>
    <ul class="space-y-2 px-4 py-6">
      <x-sideitem :active="request()->routeIs('dashboard')" href="{{ route('dashboard') }}" title="Dashboard"
        icon="fa-solid fa-gauge-high" />
      <x-sideitem :active="request()->routeIs('menu.index')" href="{{ route('menu.index') }}" title="Menu"
        icon="fa-solid fa-clipboard-list" />
      <x-sideitem :active="request()->routeIs('bahan.index')" href="{{ route('bahan.index') }}" title="Bahan"
        icon="fa-solid fa-box-archive" />
      <x-sideitem :active="request()->routeIs('jual.index')" href="{{ route('jual.index') }}" title="Penjualan"
        icon="fa-solid fa-gauge-high" />
      <x-sideitem :active="request()->routeIs('beli.index')" href="{{ route('beli.index') }}" title="Pembelian"
        icon="fa-solid fa-cart-shopping" />
      <x-sideitem :active="request()->is('laporan/jual')" href="{{ route('laporan.index',['type'=>'jual']) }}"
        title="Laporan Penjualan" icon="fa-solid fa-arrow-trend-up" />
      <x-sideitem :active="request()->is('laporan/beli')" href="{{ route('laporan.index',['type'=>'beli']) }}"
        title="Laporan Pembelian" icon="fa-solid fa-arrow-trend-down" />
      <x-sideitem :active="request()->is('logout.get')" href="{{ route('logout.get') }}" title="Keluar"
        icon="fa-solid fa-right-from-bracket" />
    </ul>
  </div>
</aside>