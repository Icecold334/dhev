<?php

namespace Database\Factories;

use App\Models\Bahan;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LogStok>
 */
class LogStokFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenis = fake()->randomElement(['IN', 'OUT']);
        $kode = $jenis . fake()->numerify('-###-###-###');
        return [
            'jenis' => $jenis,
            'kode' => $kode,
            'transaksi_id' => $jenis === 'OUT' ? Transaksi::inRandomOrder()->first()->id : null,
            'bahan_id' => Bahan::inRandomOrder()->first()->id,
            'jumlah' => fake()->numberBetween(50, 200),
            'harga' => fake()->numberBetween(10, 70) * 1000,
            'keterangan' => fake()->boolean ? fake()->sentence : ''
        ];
    }
}
