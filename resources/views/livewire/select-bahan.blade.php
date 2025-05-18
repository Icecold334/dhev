<div class="flex gap-6">
    <flux:select wire:model.live="bahan_id">
        <flux:select.option value="">Pilih Bahan</flux:select.option>
        @foreach ($availableBahans as $item)
        <flux:select.option value="{{ $item->id }}">{{ $item->nama }}</flux:select.option>
        @endforeach
    </flux:select>

    @if ($selectedBahan)
    <flux:button wire:click="confirmSelect" icon="plus">Pilih Bahan</flux:button>
    @endif
</div>