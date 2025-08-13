<?php

namespace Database\Seeders;

use App\Models\ListMenu;
use App\Models\LogStok;
use App\Models\Menu;
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
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
        ]);
        User::factory()->create([
            'name' => 'Kasir',
            'email' => 'kasir@email.com',
        ]);
        $this->call([
            SatuanSeeder::class,
            // BahanSeeder::class,
            // MenuSeeder::class,
            PermissionSeeder::class
        ]);
        // foreach (Menu::all() as $key => $value) {
        //     ListMenu::factory(fake()->numberBetween(3, 7))->fillMenu($value)->create();
        // }
        // Transaksi::factory(10)->create();
        // LogStok::factory(1000)->create();
    }
}
