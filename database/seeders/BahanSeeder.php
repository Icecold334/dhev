<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Satuan;
use App\Models\Bahan;
use Illuminate\Support\Carbon;

class BahanSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $satuanList = Satuan::all();

        $bahanNames = [
            'Tepung Terigu',
            'Gula Pasir',
            'Minyak Goreng',
            'Susu Cair',
            'Mentega',
            'Garam',
            'Kecap Manis',
            'Santan',
            'Telur Ayam',
            'Daun Bawang',
            'Cabe Merah',
            'Cabe Rawit',
            'Bawang Putih',
            'Bawang Merah',
            'Jahe',
            'Kunyit',
            'Lengkuas',
            'Serai',
            'Tomat',
            'Wortel',
            'Kentang',
            'Kol',
            'Bayam',
            'Kangkung',
            'Tahu',
            'Tempe',
            'Ayam Fillet',
            'Daging Sapi',
            'Ikan Lele',
            'Ikan Tuna',
            'Udang',
            'Kacang Hijau',
            'Kacang Merah',
            'Mie Instan',
            'Penyedap Rasa',
            'Saus Tomat',
            'Saus Sambal',
            'Margarin',
            'Minyak Wijen',
            'Cuka',
            'Tepung Maizena',
            'Ragi Instan',
            'Cokelat Bubuk',
            'Keju Parut',
            'Mayones',
            'Selai Stroberi',
            'Selai Kacang',
            'Susu Kental Manis',
            'Susu Bubuk',
        ];

        $data = collect($bahanNames)->map(function ($nama) use ($satuanList, $now) {
            $besar = $satuanList->random();
            do {
                $kecil = $satuanList->random();
            } while ($kecil->id === $besar->id);

            return [
                'nama' => $nama,
                'konversi' => rand(10, 100),
                'besar_id' => $besar->id,
                'kecil_id' => $kecil->id,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        })->toArray();

        Bahan::insert($data);
    }
}
