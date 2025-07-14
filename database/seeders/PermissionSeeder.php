<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entities = ['dashboard', 'menu', 'bahan', 'penjualan', 'pembelian', 'laporan_jual', 'laporan_beli',];
        $actions = ['create', 'read', 'view', 'update', 'delete'];

        foreach ($entities as $entity) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$action} {$entity}"], ['guard_name' => 'web']);
            }
        }


        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());
        $adminUser = User::find(1)->assignRole('admin');

        $kasir = Role::firstOrCreate(['name' => 'kasir']);
        $kasir->syncPermissions(['read menu', 'read bahan', 'read penjualan', 'view menu', 'view bahan']);
        $kasirUser = User::find(2)->assignRole('kasir');
    }
}
