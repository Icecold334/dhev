<?php
// database/seeders/SatuanSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Satuan;
use Illuminate\Support\Carbon;

class SatuanSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $satuanList = [
            'gram',
            'kilogram',
            'mililiter',
            'liter',
            'sendok teh',
            'sendok makan',
            'cup',
            'buah',
            'sachet',
            'bungkus',
            'potong',
            'butir',
            'ikat',
            'piring',
            'gelas',
        ];

        $data = array_map(fn($nama) => [
            'nama' => $nama,
            'created_at' => $now,
            'updated_at' => $now,
        ], $satuanList);

        Satuan::insert($data);
    }
}
