<x-layouts.body :title="__('Pembelian')">
  <div class="grid grid-cols-12  gap-4">

    <div class="border p-4 rounded-lg col-span-12 md:col-span-9 border-primary-700">
      <livewire:select-bahan />
    </div>
    <div class="border p-4 rounded-lg col-span-12 md:col-span-3 border-primary-700">
      <livewire:total-display />
    </div>
  </div>
  <div class="mt-4">
    <div class="border p-4 rounded-lg col-span-12 md:col-span-3 border-primary-700">
      <livewire:list-beli />
    </div>

  </div>
</x-layouts.body>