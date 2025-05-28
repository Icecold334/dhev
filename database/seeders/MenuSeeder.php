<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slug = new Str;
        $menu = new Menu;

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

        foreach ($namaList as $key => $value) {
            $menu->create([
                'nama' => $value['nama'],
                'slug' => $slug->slug($value['nama']),
                'tipe' => $value['tipe'],
                'deskripsi' => fake()->paragraph(),
                'harga' => fake()->numberBetween(10, 50) * 1000,
            ]);
        }
    }
}
