<?php

namespace Database\Factories;

use App\Models\Bahan;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaksi>
 */
class TransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kode = 'N' . fake()->numerify('-###-###-###');
        $menu = Menu::inRandomOrder()->first();
        return [
            'kode' => $kode,
            'menu_id' => $menu->id,
            'jumlah' => fake()->numberBetween(1, 10),
            'harga' => $menu->harga,
            'keterangan' => fake()->boolean ? fake()->sentence : ''
        ];
    }
}
