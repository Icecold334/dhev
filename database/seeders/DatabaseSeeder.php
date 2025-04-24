<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SatuanSeeder::class,
            BahanSeeder::class
        ]);

        Transaksi::factory(100)->create();

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@user.com',
        ]);
    }
}
