<?php

namespace Database\Factories;

use App\Models\Bahan;
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
        $jenis = fake()->boolean;
        $kode = ($jenis ? 'IN' : 'KC') . fake()->numerify('-###-###-###');
        return [
            'jenis' => $jenis,
            'kode' => $kode,
            'bahan_id' => Bahan::inRandomOrder()->first()->id,
            'jumlah' => fake()->numberBetween(50, 200),
            'harga' => fake()->numberBetween(10, 70) * 1000,
            'keterangan' => fake()->boolean ? fake()->sentence : ''
        ];
    }
}
