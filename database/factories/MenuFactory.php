<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $slug = new Str;

        $namaList = [
            ['nama' => 'Nasi Goreng', 'tipe' => 'makanan'],
            ['nama' => 'Mie Ayam', 'tipe' => 'makanan'],
            ['nama' => 'Sate Ayam', 'tipe' => 'makanan'],
            ['nama' => 'Bakso', 'tipe' => 'makanan'],
            ['nama' => 'Soto Ayam', 'tipe' => 'makanan'],
            ['nama' => 'Ayam Geprek', 'tipe' => 'makanan'],
            ['nama' => 'Es Teh Manis', 'tipe' => 'minuman'],
            ['nama' => 'Jus Alpukat', 'tipe' => 'minuman'],
            ['nama' => 'Kopi Susu', 'tipe' => 'minuman'],
            ['nama' => 'Teh Tarik', 'tipe' => 'minuman'],
            ['nama' => 'Rendang', 'tipe' => 'makanan'],
            ['nama' => 'Gado-Gado', 'tipe' => 'makanan'],
            ['nama' => 'Burger', 'tipe' => 'makanan'],
            ['nama' => 'Pizza', 'tipe' => 'makanan'],
            ['nama' => 'Spaghetti Bolognese', 'tipe' => 'makanan'],
            ['nama' => 'Smoothie Mangga', 'tipe' => 'minuman'],
            ['nama' => 'Cappuccino', 'tipe' => 'minuman'],
            ['nama' => 'Thai Tea', 'tipe' => 'minuman'],
            ['nama' => 'Martabak Manis', 'tipe' => 'makanan'],
            ['nama' => 'Pecel Lele', 'tipe' => 'makanan'],
        ];

        $namaSudahAda = Menu::pluck('slug')->toArray();

        // Ambil yang belum ada
        $availableNama = array_filter($namaList, function ($item) use ($namaSudahAda, $slug) {
            return !in_array($slug->slug($item['nama']), $namaSudahAda);
        });

        $availableNama = array_values($availableNama); // reset index

        if (count($availableNama) > 0) {
            $pilihan = fake()->randomElement($availableNama);
            $nama = $pilihan['nama'];
            $tipe = $pilihan['tipe'];
        } else {
            // Kalau sudah habis semua, generate nama random
            $nama = fake()->unique()->words(2, true); // true biar jadi string
            $tipe = 'makanan'; // defaultin makanan kalau random
        }
        // dd($nama, $tipe);
        return [
            'nama' => $nama,
            'slug' => $slug->slug($nama),
            'tipe' => $tipe,
            'deskripsi' => fake()->paragraph(),
            'harga' => fake()->numberBetween(10, 50) * 1000,
        ];
    }
}
