<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout heading="Perbarui Kata Sandi"
        subheading="Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman">
        <form wire:submit="updatePassword" class="mt-6 space-y-6">
            <flux:input wire:model="current_password" label="Kata Sandi Saat Ini" type="password" required
                autocomplete="current-password" />
            <flux:input wire:model="password" label="Kata Sandi Baru" type="password" required
                autocomplete="new-password" />
            <flux:input wire:model="password_confirmation" label="Konfirmasi Kata Sandi" type="password" required
                autocomplete="new-password" />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">Simpan</flux:button>
                </div>

                <x-action-message class="me-3" on="password-updated">
                    Disimpan.
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>